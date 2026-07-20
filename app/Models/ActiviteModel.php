<?php

namespace App\Models;
use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table = 'activites';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nom', 'description', 'calories', 'duree'];

    public function getAllActivites()
    {
        return $this->findAll();
    }

    public function getActivites($perPage = 5)
    {
        return $this->paginate($perPage);
    }
    /**
     * Récupérer une activité par ID
     */
    public function getActivite($id)
    {
        return $this->find($id);
    }

    /**
     * Créer une nouvelle activité (CREATE)
     */
    public function createActivite($data)
    {
        return $this->insert($data);
    }

    /**
     * Modifier une activité (UPDATE)
     */
    public function updateActivite($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Supprimer une activité (DELETE)
     */
    public function deleteActivite($id)
    {
        return $this->delete($id);
    }

    /**
     * Récupérer les activités recommandées pour un objectif
     */
    public function getByCalories($minCalories, $maxCalories)
    {
        return $this->whereBetween('calories', [$minCalories, $maxCalories])
            ->findAll();
    }
}