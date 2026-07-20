<?php

namespace App\Models;
use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table = 'codes';
    protected $primaryKey = 'id';

    protected $allowedFields = ['code', 'montant', 'is_used'];

    public function validateCode($code){
        return $this->where('code', $code)
                    ->where('is_used', 0)
                    ->first();
    }

    public function checkCode($code){
        return (bool) $this->validateCode($code);
    }

    public function markAsUsed($id){
        return $this->update($id, ['is_used' => 1]);
    }
}