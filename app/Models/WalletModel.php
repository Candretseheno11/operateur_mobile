<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Models\CodeModel;
use App\Models\TransactionModel;
use Config\Database;

class WalletModel extends Model
{
    protected $table = 'wallet';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'solde'];

    public function getWalletByUser($user_id)
    {
        return $this->where('user_id', $user_id)->first();
    }

    public function createWallet($user_id, $initialSolde = 0)
    {
        $existing = $this->getWalletByUser($user_id);
        if ($existing) {
            return $existing;
        }

        $this->insert([
            'user_id' => $user_id,
            'solde' => $initialSolde,
        ]);

        return $this->getWalletByUser($user_id);
    }

    public function addMoney($user_id, $montant)
    {
        $wallet = $this->getWalletByUser($user_id);
        if (!$wallet) {
            $wallet = $this->createWallet($user_id, 0);
        }

        $newSolde = (float) $wallet['solde'] + (float) $montant;

        return $this->update($wallet['id'], ['solde' => $newSolde]);
    }

    public function deductMoney($user_id, $montant)
    {
        $wallet = $this->getWalletByUser($user_id);
        if (!$wallet) {
            $wallet = $this->createWallet($user_id, 0);
        }

        if ((float) $wallet['solde'] < (float) $montant) {
            return false;
        }

        $newSolde = (float) $wallet['solde'] - (float) $montant;

        return $this->update($wallet['id'], ['solde' => $newSolde]);
    }

    public function addMoneyWithCode($user_id, $code)
    {
        $db = Database::connect();
        $db->transStart();

        $codeModel = new CodeModel();
        $transactionModel = new TransactionModel();

        $codeData = $codeModel->validateCode($code);
        if (!$codeData) {
            $db->transComplete();
            return false;
        }

        $wallet = $this->getWalletByUser($user_id);
        if (!$wallet) {
            $wallet = $this->createWallet($user_id, 0);
        }

        $newSolde = (float) $wallet['solde'] + (float) $codeData['montant'];
        $this->update($wallet['id'], ['solde' => $newSolde]);

        $codeModel->markAsUsed($codeData['id']);
        $transactionModel->createTransaction([
            'user_id' => $user_id,
            'code_id' => $codeData['id'],
            'montant' => $codeData['montant'],
            'date' => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        return $db->transStatus();
    }



    public function hasEnoughBalance($user_id, $montant)
    {
        $wallet = $this->getWalletByUser($user_id);
        return $wallet && (float) $wallet['solde'] >= (float) $montant;
    }
    public function getPaginated($page)
    {
        $perPage = 5;
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        return $this->orderBy('id', 'DESC')->findAll($perPage, $offset);
    }
}