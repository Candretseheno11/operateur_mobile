<?php

namespace App\Models;
use CodeIgniter\Model;

class ObjectifModel extends Model
{
    protected $table = 'objectifs';
    protected $primaryKey = 'id';

    protected $allowedFields = ['libelle'];

    public function getAllObjectifs()
    {
        return $this->select('id, libelle')->findAll();
    }

    public function getObjectifById($id)
    {
        return $this->find($id);
    }

    public function saveObjectifs($data)
    {
        return $this->insert($data);
    }
}