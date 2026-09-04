<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersModel extends Model
{
	protected $table = 'users';

	protected $fillable = [
		'firstname',
		'lastname',
		'username',
		'email',
		'password',
		'role',
		'is_active',
	];

	protected $timestamps = true;

	public function findByEmail(string $email)
	{
		return $this->find_by('email', $email);
	}

	public function createUser(array $data)
	{
		if (isset($data['password'])) {
			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		}

		return $this->insert($data);
	}
}
