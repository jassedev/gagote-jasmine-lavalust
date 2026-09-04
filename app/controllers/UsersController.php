<?php

namespace App\Controllers;

use App\Models\UsersModel;
use System\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $usersModel = new UsersModel();

        $data['users'] = $usersModel->all();

        $this->call->view('users', $data);
    }
}