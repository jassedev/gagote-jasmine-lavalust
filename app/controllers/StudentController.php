<?php

class StudentController extends Controller
{
    public function index()
    {
        // Load the StudentModel
        $this->call->model('StudentModel');

        // Get all student records
        $students = $this->StudentModel->all();

        // Pass the data to the view
        $data['students'] = $students;

        // Load the students view
        $this->call->view('students', $data);
    }
}