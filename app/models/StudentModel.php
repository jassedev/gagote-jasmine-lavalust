<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentModel extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'id',
        'student_id',
        'name',
        'course',
        'year',
        'section',
        'email',
    ];

    protected $timestamps = true;
}
