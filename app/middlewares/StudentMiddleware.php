<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle()
    {
        // Check if the student is allowed to access the profile
        if (!isset($_SESSION['student_access']) || $_SESSION['student_access'] !== true) {

            // Redirect unauthorized users to the student home page
            redirect('student');

            exit;
        }

        // Allow the request to continue
        return true;
    }
}
