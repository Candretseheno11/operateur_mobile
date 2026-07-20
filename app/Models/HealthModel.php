<?php

namespace App\Models;
use CodeIgniter\Model;

class HealthModel extends Model
{
    protected $table = 'user_health';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'taille', 'poids', 'imc'];

    public function calculateIMC($poids, $taille)
    {
        $poids = (float) $poids;
        $taille = (float) $taille;

        if ($poids <= 0 || $taille <= 0) {
            return null;
        }
        // conversion cm → m
        $taille = $taille / 100;

        $imc = $poids / ($taille * $taille);

        return round($imc, 2);
    }

    public function saveHealth($data)
    {
        $data['imc'] = $this->calculateIMC($data['poids'], $data['taille']);
        return $this->insert($data);
    }

    public function getHealthByUser($user_id)
    {
        return $this->where('user_id', $user_id)->first();
    }

    public function updateHealth($user_id, $data)
    {
        $data['imc'] = $this->calculateIMC($data['poids'], $data['taille']);
        return $this->where('user_id', $user_id)->set($data)->update();
    }
}