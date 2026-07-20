<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nom', 'email', 'password', 'genre', 'role', 'is_gold'];

    public function createUser($data)
    {
        return $this->insert($data);
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getUserById($id)
    {
        return $this->find($id);
    }

    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }

    public function setGold($userId)
    {
        return $this->update($userId, [
            'is_gold' => 1
        ]);
    }


    public function getProfile($id)
    {
        return $this->select('id, nom, email, genre, role, is_gold')
            ->find($id);
    }

    public function updateProfile($id, $data)
    {
        $allowed = ['nom', 'email', 'genre'];

        $filteredData = array_filter(
            $data,
            fn($key) => in_array($key, $allowed),
            ARRAY_FILTER_USE_KEY
        );

        return $this->update($id, $filteredData);
    }
}