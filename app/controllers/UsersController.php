<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller
{
    public function index()
    {
        // Load the UsersModel
        $this->call->model('UsersModel');

        // Retrieve all users
        $users = $this->UsersModel->all();

        // Pass users to the view
        $this->call->view('users', [
            'users' => $users
        ]);
    }
}