<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller
{
    public function index()
    {
        // Load the UsersModel
        $this->call->model('UsersModel');

        // Retrieve all records from the users table
        $users = $this->UsersModel->all();

        // Pass the users data to the User view
        $this->call->view('User.php', [
            'users' => $users
        ]);
    }
}