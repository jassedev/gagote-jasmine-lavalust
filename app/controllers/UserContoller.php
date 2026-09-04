<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UserContoller
 * 
 * Automatically generated via CLI.
 */
class UserContoller extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function showUsers()
    {
        $this->call->database();
        $this->call->model('UserModel');
        $data['users'] = $this->UserModel->all();
        $this->call->view('users/index', $data);
    }
}