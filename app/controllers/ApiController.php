<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
    }

    public function preflight()
    {
        $this->api->respond([], 204);
    }

    public function login()
    {
        $this->api->rate_limit('api-login', 10, 60);
        $input = $this->input();
        $email = trim((string) ($input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $this->api->respond_error('A valid email and password are required', 422);
        }

        $user = $this->db->raw(
            'SELECT id, email, password, role FROM users WHERE email = ? AND is_active = 1 LIMIT 1',
            [$email]
        )->fetch(PDO::FETCH_ASSOC);

        $password_is_hashed = $user && !empty(password_get_info($user['password'])['algo']);
        $password_matches = $user && ($password_is_hashed
            ? password_verify($password, $user['password'])
            : hash_equals((string) $user['password'], $password));

        if (!$password_matches) {
            $this->api->respond_error('Invalid credentials', 401);
        }

        if (!$password_is_hashed) {
            $this->db->raw(
                'UPDATE users SET password = ? WHERE id = ?',
                [password_hash($password, PASSWORD_DEFAULT), $user['id']]
            );
        }

        $this->api->respond($this->api->issue_tokens([
            'id' => (int) $user['id'],
            'role' => $user['role'],
        ]));
    }

    public function register()
    {
        $this->api->rate_limit('api-register', 5, 60);
        $input = $this->input();
        $username = trim((string) ($input['username'] ?? ''));
        $email = trim((string) ($input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');

        if ($username === '' || strlen($username) > 100 ||
            strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            strlen($password) < 8 || strlen($password) > 72) {
            $this->api->respond_error(
                'Username (1-100 characters), a valid email, and a password (8-72 characters) are required',
                422
            );
        }

        $existing = $this->db->raw(
            'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$username, $email]
        )->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $this->api->respond_error('Username or email already exists', 409);
        }

        $user_id = $this->db->table('users')->insert([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $this->api->respond([
            'message' => 'Account created',
            'user' => $this->user_by_id($user_id),
        ], 201);
    }

    public function refresh()
    {
        $this->api->rate_limit('api-refresh', 20, 60);
        $input = $this->input();
        $refresh_token = (string) ($input['refresh_token'] ?? '');
        if ($refresh_token === '') {
            $this->api->respond_error('Refresh token is required', 422);
        }

        $this->api->refresh_access_token($refresh_token);
    }

    public function logout()
    {
        $user = $this->require_user();
        $input = $this->input();
        $refresh_token = (string) ($input['refresh_token'] ?? '');
        $refresh_claims = $this->api->validate_jwt($refresh_token);
        if (!$refresh_claims ||
            ($refresh_claims['type'] ?? '') !== 'refresh' ||
            (int) ($refresh_claims['sub'] ?? 0) !== (int) $user['id']) {
            $this->api->respond_error('A valid refresh token for this account is required', 422);
        }
        $this->api->revoke_refresh_token($refresh_token);

        $this->api->respond(['message' => 'Logged out']);
    }

    public function profile()
    {
        $user = $this->require_user();
        $this->api->respond($this->public_user($user));
    }

    public function list()
    {
        $this->require_admin();
        $users = $this->db->table('users')
            ->select('id, username, email, role, is_active, created_at')
            ->get_all();
        $this->api->respond($users);
    }

    public function show($id)
    {
        $this->require_admin();
        $user = $this->user_by_id($this->resource_id($id));
        if (!$user) {
            $this->api->respond_error('User not found', 404);
        }
        $this->api->respond($user);
    }

    public function create()
    {
        $this->require_admin();
        $input = $this->input();
        $username = trim((string) ($input['username'] ?? ''));
        $email = trim((string) ($input['email'] ?? ''));
        $password = (string) ($input['password'] ?? '');
        $role = (string) ($input['role'] ?? 'user');

        if ($username === '' || strlen($username) > 100 ||
            strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            strlen($password) < 8 || strlen($password) > 72 ||
            !in_array($role, ['admin', 'moderator', 'user'], true)) {
            $this->api->respond_error('Valid username, email, password (8-72 characters), and role are required', 422);
        }
        $this->assert_user_is_unique($username, $email);

        $active = array_key_exists('is_active', $input)
            ? (filter_var($input['is_active'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0)
            : 1;
        $user_id = $this->db->table('users')->insert([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'is_active' => $active,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->api->respond([
            'message' => 'User created',
            'user' => $this->user_by_id((int) $user_id),
        ], 201);
    }

    public function update($id)
    {
        $this->require_admin();
        $id = $this->resource_id($id);
        $current = $this->user_by_id($id, true);
        if (!$current) {
            $this->api->respond_error('User not found', 404);
        }

        $input = $this->input();
        $username = trim((string) ($input['username'] ?? $current['username']));
        $email = trim((string) ($input['email'] ?? $current['email']));
        $role = (string) ($input['role'] ?? $current['role']);
        $active = array_key_exists('is_active', $input)
            ? (filter_var($input['is_active'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0)
            : (int) $current['is_active'];
        $password = (string) ($input['password'] ?? '');

        if ($username === '' || strlen($username) > 100 ||
            strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            !in_array($role, ['admin', 'moderator', 'user'], true) ||
            ($password !== '' && (strlen($password) < 8 || strlen($password) > 72))) {
            $this->api->respond_error('Invalid username, email, role, or password', 422);
        }

        $this->assert_user_is_unique($username, $email, $id);
        if ($current['role'] === 'admin' && (int) $current['is_active'] === 1 &&
            ($role !== 'admin' || !$active) &&
            $this->admin_count() <= 1) {
            $this->api->respond_error('The last active administrator cannot be demoted or disabled', 409);
        }

        if ($password !== '') {
            $this->db->raw(
                'UPDATE users SET username = ?, email = ?, role = ?, is_active = ?, password = ? WHERE id = ?',
                [$username, $email, $role, $active, password_hash($password, PASSWORD_DEFAULT), $id]
            );
            $this->db->raw('DELETE FROM refresh_tokens WHERE user_id = ?', [$id]);
        } else {
            $this->db->raw(
                'UPDATE users SET username = ?, email = ?, role = ?, is_active = ? WHERE id = ?',
                [$username, $email, $role, $active, $id]
            );
        }

        $this->api->respond([
            'message' => 'User updated',
            'user' => $this->user_by_id($id),
        ]);
    }

    public function delete($id)
    {
        $auth = $this->require_admin();
        $id = $this->resource_id($id);
        $user = $this->user_by_id($id, true);
        if (!$user) {
            $this->api->respond_error('User not found', 404);
        }
        if ((int) $auth['id'] === $id) {
            $this->api->respond_error('You cannot delete your own account', 409);
        }
        if ($user['role'] === 'admin' && (int) $user['is_active'] === 1 && $this->admin_count() <= 1) {
            $this->api->respond_error('The last active administrator cannot be deleted', 409);
        }

        $this->db->raw('DELETE FROM refresh_tokens WHERE user_id = ?', [$id]);
        $this->db->raw('DELETE FROM users WHERE id = ?', [$id]);
        $this->api->respond(['message' => 'User deleted']);
    }

    public function products()
    {
        $this->require_user();
        $products = $this->db->table('products')->get_all();
        $this->api->respond($products);
    }

    public function product_show($id)
    {
        $this->require_user();
        $product = $this->db->raw('SELECT * FROM products WHERE id = ? LIMIT 1', [
            $this->resource_id($id),
        ])->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            $this->api->respond_error('Product not found', 404);
        }
        $this->api->respond($product);
    }

    public function product_create()
    {
        $this->require_admin();
        $input = $this->validated_product($this->input());
        $product_id = $this->db->table('products')->insert($input);
        $this->api->respond([
            'message' => 'Product created',
            'product' => $this->db->raw('SELECT * FROM products WHERE id = ?', [$product_id])
                ->fetch(PDO::FETCH_ASSOC),
        ], 201);
    }

    public function product_update($id)
    {
        $this->require_admin();
        $id = $this->resource_id($id);
        $product = $this->db->raw('SELECT * FROM products WHERE id = ? LIMIT 1', [$id])
            ->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            $this->api->respond_error('Product not found', 404);
        }
        $input = $this->validated_product($this->input(), $product);
        $this->db->raw(
            'UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ? WHERE id = ?',
            [$input['product_name'], $input['description'], $input['price'], $input['quantity'], $id]
        );
        $this->api->respond([
            'message' => 'Product updated',
            'product' => $this->db->raw('SELECT * FROM products WHERE id = ?', [$id])
                ->fetch(PDO::FETCH_ASSOC),
        ]);
    }

    public function product_delete($id)
    {
        $this->require_admin();
        $id = $this->resource_id($id);
        $deleted = $this->db->raw('DELETE FROM products WHERE id = ?', [$id])->rowCount();
        if (!$deleted) {
            $this->api->respond_error('Product not found', 404);
        }
        $this->api->respond(['message' => 'Product deleted']);
    }

    public function students()
    {
        $this->require_user();
        $this->api->respond($this->db->table('students')->get_all());
    }

    public function student_show($id)
    {
        $this->require_user();
        $student = $this->student_by_id($this->resource_id($id));
        if (!$student) {
            $this->api->respond_error('Student not found', 404);
        }
        $this->api->respond($student);
    }

    public function student_create()
    {
        $this->require_admin();
        $student = $this->validated_student($this->input());
        $this->assert_student_is_unique($student['student_id'], $student['email']);
        $student['created_at'] = date('Y-m-d H:i:s');
        $student_id = $this->db->table('students')->insert($student);
        $this->api->respond([
            'message' => 'Student created',
            'student' => $this->student_by_id((int) $student_id),
        ], 201);
    }

    public function student_update($id)
    {
        $this->require_admin();
        $id = $this->resource_id($id);
        $current = $this->student_by_id($id);
        if (!$current) {
            $this->api->respond_error('Student not found', 404);
        }
        $student = $this->validated_student($this->input(), $current);
        $this->assert_student_is_unique($student['student_id'], $student['email'], $id);
        $this->db->raw(
            'UPDATE students SET student_id = ?, name = ?, course = ?, year = ?, section = ?, email = ?, updated_at = NOW() WHERE id = ?',
            array_merge(array_values($student), [$id])
        );
        $this->api->respond([
            'message' => 'Student updated',
            'student' => $this->student_by_id($id),
        ]);
    }

    public function student_delete($id)
    {
        $this->require_admin();
        $id = $this->resource_id($id);
        $deleted = $this->db->raw('DELETE FROM students WHERE id = ?', [$id])->rowCount();
        if (!$deleted) {
            $this->api->respond_error('Student not found', 404);
        }
        $this->api->respond(['message' => 'Student deleted']);
    }

    private function input()
    {
        $content_type = $_SERVER['CONTENT_TYPE'] ?? '';
        if (stripos($content_type, 'application/json') !== false) {
            $body = file_get_contents('php://input');
            $input = json_decode($body, true);
            if (!is_array($input) || json_last_error() !== JSON_ERROR_NONE) {
                $this->api->respond_error('Request body must be a valid JSON object', 400);
            }
        } elseif ($_POST) {
            $input = $_POST;
        } else {
            parse_str((string) file_get_contents('php://input'), $input);
        }

        foreach ($input as $value) {
            if (!is_scalar($value) && $value !== null) {
                $this->api->respond_error('Request fields must contain scalar values', 422);
            }
        }
        return $input;
    }

    private function require_user()
    {
        $claims = $this->api->require_jwt();
        if (!isset($claims['sub']) || !ctype_digit((string) $claims['sub']) || (int) $claims['sub'] < 1) {
            $this->api->respond_error('Unauthorized', 401);
        }

        $user = $this->db->raw(
            'SELECT id, username, email, role, is_active, created_at FROM users WHERE id = ? LIMIT 1',
            [(int) $claims['sub']]
        )->fetch(PDO::FETCH_ASSOC);
        if (!$user || (int) $user['is_active'] !== 1) {
            $this->api->respond_error('Unauthorized', 401);
        }

        return $user;
    }

    private function require_admin()
    {
        $user = $this->require_user();
        if ($user['role'] !== 'admin') {
            $this->api->respond_error('Administrator access is required', 403);
        }
        return $user;
    }

    private function user_by_id($id, $with_password = false)
    {
        $columns = $with_password
            ? 'id, username, email, role, is_active, password, created_at'
            : 'id, username, email, role, is_active, created_at';
        return $this->db->raw(
            "SELECT {$columns} FROM users WHERE id = ? LIMIT 1",
            [$id]
        )->fetch(PDO::FETCH_ASSOC);
    }

    private function public_user($user)
    {
        unset($user['password']);
        return $user;
    }

    private function assert_user_is_unique($username, $email, $except_id = null)
    {
        $sql = 'SELECT id FROM users WHERE (username = ? OR email = ?)';
        $params = [$username, $email];
        if ($except_id !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $except_id;
        }
        $sql .= ' LIMIT 1';
        if ($this->db->raw($sql, $params)->fetch(PDO::FETCH_ASSOC)) {
            $this->api->respond_error('Username or email already exists', 409);
        }
    }

    private function admin_count()
    {
        return (int) $this->db->raw(
            "SELECT COUNT(*) FROM users WHERE role = 'admin' AND is_active = 1"
        )->fetchColumn();
    }

    private function validated_product($input, $current = [])
    {
        $product = [
            'product_name' => trim((string) ($input['product_name'] ?? $current['product_name'] ?? '')),
            'description' => trim((string) ($input['description'] ?? $current['description'] ?? '')),
            'price' => $input['price'] ?? $current['price'] ?? null,
            'quantity' => $input['quantity'] ?? $current['quantity'] ?? null,
        ];
        if ($product['product_name'] === '' || strlen($product['product_name']) > 255 ||
            strlen($product['description']) > 65535 ||
            !is_numeric($product['price']) || !is_finite((float) $product['price']) ||
            (float) $product['price'] < 0 || (float) $product['price'] > 99999999.99 ||
            filter_var($product['quantity'], FILTER_VALIDATE_INT) === false ||
            (int) $product['quantity'] < 0 || (int) $product['quantity'] > 4294967295) {
            $this->api->respond_error('Product name, non-negative price, and non-negative integer quantity are required', 422);
        }
        $product['price'] = (float) $product['price'];
        $product['quantity'] = (int) $product['quantity'];
        return $product;
    }

    private function validated_student($input, $current = [])
    {
        $student = [
            'student_id' => trim((string) ($input['student_id'] ?? $current['student_id'] ?? '')),
            'name' => trim((string) ($input['name'] ?? $current['name'] ?? '')),
            'course' => trim((string) ($input['course'] ?? $current['course'] ?? '')),
            'year' => trim((string) ($input['year'] ?? $current['year'] ?? '')),
            'section' => trim((string) ($input['section'] ?? $current['section'] ?? '')),
            'email' => trim((string) ($input['email'] ?? $current['email'] ?? '')),
        ];
        if ($student['student_id'] === '' || strlen($student['student_id']) > 50 ||
            $student['name'] === '' || strlen($student['name']) > 150 ||
            $student['course'] === '' || strlen($student['course']) > 150 ||
            $student['year'] === '' || strlen($student['year']) > 30 ||
            $student['section'] === '' || strlen($student['section']) > 30 ||
            strlen($student['email']) > 255 ||
            !filter_var($student['email'], FILTER_VALIDATE_EMAIL)) {
            $this->api->respond_error('Student ID, name, course, year, section, and valid email are required', 422);
        }
        return $student;
    }

    private function student_by_id($id)
    {
        return $this->db->raw('SELECT * FROM students WHERE id = ? LIMIT 1', [$id])
            ->fetch(PDO::FETCH_ASSOC);
    }

    private function assert_student_is_unique($student_id, $email, $except_id = null)
    {
        $sql = 'SELECT id FROM students WHERE (student_id = ? OR email = ?)';
        $params = [$student_id, $email];
        if ($except_id !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $except_id;
        }
        $sql .= ' LIMIT 1';
        if ($this->db->raw($sql, $params)->fetch(PDO::FETCH_ASSOC)) {
            $this->api->respond_error('Student ID or email already exists', 409);
        }
    }

    private function resource_id($id)
    {
        if (!ctype_digit((string) $id) || (int) $id < 1) {
            $this->api->respond_error('Invalid resource ID', 422);
        }
        return (int) $id;
    }
}
