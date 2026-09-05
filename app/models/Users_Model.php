<?php

class Users_model extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function getAllUsers()
    {
        return $this->db->table($this->table)->get()->getResult();
    }

    public function getUserById($id)
    {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->get()
                        ->getRow();
    }

    public function insertUser($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateUser($id, $data)
    {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->update($data);
    }

    public function deleteUser($id)
    {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->delete();
    }
}