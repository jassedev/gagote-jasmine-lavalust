<?php
defined('PREVENT_DIRECT_ACCESS') OR exit("No direct script access allowed");
class StudentController extends Controller
{
    public function index()
    {
      $this->call->view('student_home.php');
    }
    public function profile()
    {
    // Display student profile
   $student = [
           'student_id' => '2026 - 0123',
            'name' => 'Jasmine Gagote',
            'course' => 'Bachelor of Science in Information Technology',
            'year' => '3rd Year',
            'section' => '3F3',
            'email' => 'jasmine.gagote@example.com'
];

    $this->call->view('student_profile', $student);


 }
}