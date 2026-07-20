<?php

namespace App\Models;
use CodeIgniter\Model;

class SuggestionModel extends Model
{
    protected $table = 'suggestions';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'regime_id', 'activite_id', 'date'];

    public function createSuggestion($data){
        return $this->insert($data);
    }

    public function getSuggestionsByUser($user_id){
        return $this->select('suggestions.id as suggestion_id, suggestions.user_id, suggestions.date as suggestion_date,
                regimes.id as regime_id, regimes.nom as regime_nom, regimes.description as regime_description,
                regimes.prix as regime_prix, regimes.duree as regime_duree, regimes.variation_poids as regime_variation_poids,
                activites.id as activite_id, activites.nom as activite_nom, activites.description as activite_description,
                activites.calories as activite_calories, activites.duree as activite_duree')
            ->where('suggestions.user_id', $user_id)
            ->join('regimes', 'regimes.id = suggestions.regime_id')
            ->join('activites', 'activites.id = suggestions.activite_id')
            ->findAll();
    }

    public function getSuggestionForUser($suggestion_id, $user_id){
        return $this->select('suggestions.id as suggestion_id, suggestions.user_id, suggestions.date as suggestion_date,
                regimes.id as regime_id, regimes.nom as regime_nom, regimes.description as regime_description,
                regimes.prix as regime_prix, regimes.duree as regime_duree, regimes.variation_poids as regime_variation_poids,
                activites.id as activite_id, activites.nom as activite_nom, activites.description as activite_description,
                activites.calories as activite_calories, activites.duree as activite_duree')
            ->where('suggestions.id', $suggestion_id)
            ->where('suggestions.user_id', $user_id)
            ->join('regimes', 'regimes.id = suggestions.regime_id')
            ->join('activites', 'activites.id = suggestions.activite_id')
            ->first();
    }

    public function clearSuggestionsByUser($user_id){
        return $this->where('user_id', $user_id)->delete();
    }
}