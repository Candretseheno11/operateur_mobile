<?php

namespace App\Models;
use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $table = 'achats';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'suggestion_id', 'regime_id', 'activite_id', 'prix_total', 'date'];

    public function createPurchase($data){
        return $this->insert($data);
    }

    public function getPurchaseForSuggestionUser($user_id, $suggestion_id){
        return $this->where('user_id', $user_id)
            ->where('suggestion_id', $suggestion_id)
            ->first();
    }

    public function getPurchaseDetail($user_id, $suggestion_id){
        return $this->select('achats.id as achat_id, achats.user_id, achats.suggestion_id, achats.prix_total, achats.date as achat_date,
                regimes.id as regime_id, regimes.nom as regime_nom, regimes.description as regime_description,
                regimes.prix as regime_prix, regimes.duree as regime_duree, regimes.variation_poids as regime_variation_poids,
                activites.id as activite_id, activites.nom as activite_nom, activites.description as activite_description,
                activites.calories as activite_calories, activites.duree as activite_duree')
            ->where('achats.user_id', $user_id)
            ->where('achats.suggestion_id', $suggestion_id)
            ->join('regimes', 'regimes.id = achats.regime_id')
            ->join('activites', 'activites.id = achats.activite_id')
            ->first();
    }
}
