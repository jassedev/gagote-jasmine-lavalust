<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentModel extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'course',
        'email',
        'username',
    ];

    protected $timestamps = true;
}
