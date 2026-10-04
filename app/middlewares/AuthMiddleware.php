<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    public function handle($next)
    {
        $session = load_class('session', 'libraries');

        if (!$session->has_userdata('user_id')) {
            header('Location: ' . site_url('/login'));
            exit;
        }

        $lava = lava_instance();
        $user = $lava->db->raw(
            'SELECT id, email, role FROM users WHERE id = ? AND is_active = 1 LIMIT 1',
            [(int) $session->userdata('user_id')]
        )->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $session->sess_destroy();
            header('Location: ' . site_url('/login'));
            exit;
        }

        $session->set_userdata([
            'user_email' => $user['email'],
            'user_role' => $user['role'],
        ]);

        return $next();
    }
}