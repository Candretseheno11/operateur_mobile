<?php

namespace App\Models;
use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nom',
        'description',
        'prix',
        'duree',
        'variation_poids',
        'pourcentage_viande',
        'pourcentage_poisson',
        'pourcentage_volaille'
    ];

    public function getAllRegimes($perPage = 5)
    {
        return $this->paginate($perPage);
    }

    public function getRegimeById($id)
    {
        return $this->find($id);
    }

    public function createRegime($data)
    {
        return $this->insert($data);
    }

    public function updateRegime($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteRegime($id)
    {
        return $this->delete($id);
    }
}