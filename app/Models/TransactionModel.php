<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'code_id',
        'montant',
        'date',
        'status'
    ];

    public function createTransaction($data)
    {
        return $this->insert($data);
    }

    // Transactions simples
    public function getTransactionsByUser($user_id)
    {
        return $this->where('user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    // Transactions avec codes
    public function getTransactionsWithCodes($user_id)
    {
        return $this->select('
                transactions.id as transaction_id,
                transactions.user_id,
                transactions.code_id,
                transactions.montant,
                transactions.date,
                transactions.status,
                codes.code,
                codes.is_used
            ')
            ->join('codes', 'codes.id = transactions.code_id')
            ->where('transactions.user_id', $user_id)
            ->orderBy('transactions.id', 'DESC')
            ->findAll();
    }

    // SWITCH propre
    public function getTransactions($user_id, $withCodes = false)
    {
        return $withCodes
            ? $this->getTransactionsWithCodes($user_id)
            : $this->getTransactionsByUser($user_id);
    }

    public function getPaginatedByUser($user_id, $perPage = 5)
    {
        return $this->select('
            transactions.id as transaction_id,
            transactions.user_id,
            transactions.code_id,
            transactions.montant,
            transactions.date,
            transactions.status,
            codes.code
        ')
            ->join('codes', 'codes.id = transactions.code_id')
            ->where('transactions.user_id', $user_id)
            ->orderBy('transactions.id', 'DESC')
            ->paginate($perPage);
    }


    public function getPaginated($page)
    {
        $perPage = 5;
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        return $this->orderBy('id', 'DESC')->findAll($perPage, $offset);
    }
}