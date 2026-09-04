<?php

class UsersModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUsers()
    {
        $this->db->query("SELECT * FROM users");
        return $this->db->resultSet();
    }

    public function getUserById($id)
    {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}