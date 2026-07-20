<?php

namespace App\Models;
use CodeIgniter\Model;

class PassageGoldModel extends Model
{
    protected $table = 'passage_gold';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'statut'];

    public function createRequest($userId)
    {
        $existing = $this->where('user_id', $userId)
            ->where('statut', 'pending')
            ->first();

        if ($existing) {
            return false;
        }

        return $this->insert([
            'user_id' => $userId,
            'statut' => 'pending'
        ]);
    }

    public function getPending()
    {
        return $this->where('statut', 'pending')->findAll();
    }
}