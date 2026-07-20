<?php

namespace App\Models;
use CodeIgniter\Model;

class PrixPassageModel extends Model
{
    protected $table = 'prix_passage';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prix'];

    // C'EST CETTE LIGNE QUI CORRIGE L'ERREUR
    protected $useTimestamps = false;
}