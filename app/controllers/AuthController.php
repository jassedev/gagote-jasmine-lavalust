<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $data['error'] = '';

        if ($this->form_validation->submitted()) {
            $email_input = $this->io->post('email');
            $password_input = $this->io->post('password');
            $requested_role = $this->io->post('role');

            if (is_string($email_input) && is_string($password_input) && is_string($requested_role)) {
                $email = trim($email_input);
                $password = $password_input;
                $user = $this->db->raw(
                    'SELECT id, email, password, role FROM users WHERE email = ? AND is_active = 1 LIMIT 1',
                    [$email]
                )->fetch(PDO::FETCH_ASSOC);

                $password_is_hashed = $user && !empty(password_get_info($user['password'])['algo']);
                $password_matches = $user && ($password_is_hashed
                    ? password_verify($password, $user['password'])
                    : hash_equals((string) $user['password'], $password));

                if ($password_matches && in_array($requested_role, ['user', 'admin'], true) &&
                    $requested_role === $user['role']) {
                    if (!$password_is_hashed) {
                        $this->db->raw(
                            'UPDATE users SET password = ? WHERE id = ?',
                            [password_hash($password, PASSWORD_DEFAULT), $user['id']]
                        );
                    }
                    $this->session->regenerate_on_login();
                    $this->session->set_userdata([
                        'user_id' => (int) $user['id'],
                        'user_email' => $user['email'],
                        'user_role' => $user['role']
                    ]);
                    header('Location: ' . site_url('/products'));
                    exit;
                }
            }

            $data['error'] = 'Invalid email, password, or account role.';
        }

        $this->call->view('auth/login', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        header('Location: ' . site_url('/login'));
        exit;
    }

}