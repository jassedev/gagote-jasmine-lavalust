<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    public function index()
    {
        $this->call->view('student_home');
    }

    public function profile()
    {
        $this->call->view('student_profile', [
            'student_id' => '2024-0001',
            'name'       => 'Juan Dela Cruz',
            'course'     => 'Bachelor of Science in Information Technology',
            'year'       => '3rd Year',
            'section'    => 'A',
            'email'      => 'juan.delacruz@example.com',
        ]);
    }
}