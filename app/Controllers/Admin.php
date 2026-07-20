<?php

namespace App\Controllers;

use App\Models\ActiviteModel;
use App\Models\UserModel;
use App\Models\RegimeModel;
use App\Models\TransactionModel;
use App\Models\WalletModel;
use App\Models\CodeModel;
use App\Models\PassageGoldModel;
use App\Models\PrixPassageModel;
class Admin extends BaseController
{
    protected $activiteModel;
    protected $userModel;
    protected $regimeModel;

    protected $transactionModel;

    protected $codeModel;
    protected $walletModel;

    protected $passageGoldModel;

    public function __construct()
    {
        $this->activiteModel = new ActiviteModel();
        $this->userModel = new UserModel();
        $this->regimeModel = new RegimeModel();
        $this->transactionModel = new TransactionModel();
        $this->walletModel = new WalletModel();
        $this->codeModel = new CodeModel();
        $this->passageGoldModel = new PassageGoldModel();


    }

    /**
     * Afficher le tableau de bord admin (interface principale)
     */
    public function index()
    {
        // Vérifier que l'utilisateur est administrateur
        if (session('user.role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé. Seuls les administrateurs peuvent accéder au panneau admin.');
        }

        $activites = $this->activiteModel->getActivites();
        $data = [
            'activites' => $activites,
            'stats' => $this->getDashboardStats($activites),
        ];

        return view('Admin/index', $data);
    }
    public function activity()
    {
        // Vérifier que l'utilisateur est administrateur
        if (session('user.role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé. Seuls les administrateurs peuvent accéder au panneau admin.');
        }

        $activites = $this->activiteModel->getActivites();
        $data = [
            'activites' => $activites,
            'stats' => $this->getDashboardStats($activites),
            'pager' => $this->activiteModel->pager
        ];

        return view('Admin/Activite/index', $data);
    }


    public function getDashboardStats(array $activites = [])
    {
        if (empty($activites)) {
            $activites = $this->activiteModel->getAllActivites();
        }

        $totalActivites = $this->activiteModel->countAll();
        $caloriesAverage = $totalActivites > 0 ? round(array_sum(array_column($activites, 'calories')) / $totalActivites) : 0;
        $dureeAverage = $totalActivites > 0 ? round(array_sum(array_column($activites, 'duree')) / $totalActivites) : 0;

        $totalUsers = $this->userModel->countAll();
        $totalAdmins = (new UserModel())->where('role', 'admin')->countAllResults();
        $totalUtilisateurs = (new UserModel())->where('role', 'utilisateur')->countAllResults();
        $totalRegimes = $this->regimeModel->countAll();

        $avgRegimePrix = 0;
        $regimeStats = (new RegimeModel())->selectAvg('prix')->first();
        if (is_array($regimeStats) && isset($regimeStats['prix'])) {
            $avgRegimePrix = round($regimeStats['prix']);
        }

        $transactionModel = new \App\Models\TransactionModel();


        $totalMontantTransactions = $transactionModel
            ->selectSum('montant')
            ->first()['montant'] ?? 0;


        $totalApproved = $transactionModel
            ->where('status', 'approved')
            ->countAllResults();


        $totalPending = $transactionModel
            ->where('status', 'pending')
            ->countAllResults();


        $totalRejected = $transactionModel
            ->where('status', 'rejected')
            ->countAllResults();
        return [
            'totalActivites' => $totalActivites,
            'caloriesAverage' => $caloriesAverage,
            'dureeAverage' => $dureeAverage,
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalUtilisateurs' => $totalUtilisateurs,
            'totalRegimes' => $totalRegimes,
            'avgRegimePrix' => $avgRegimePrix,
            'totalTransactionsMontant' => $totalMontantTransactions,
            'totalApproved' => $totalApproved,
            'totalPending' => $totalPending,
            'totalRejected' => $totalRejected,
        ];
    }

    /**
     * Afficher le formulaire de création d'activité
     */
    public function createActivity()
    {
        // Vérifier que l'utilisateur est administrateur
        if (session('user.role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé.');
        }

        return view('Admin/Activite/create_activite');
    }

    /**
     * Enregistrer une nouvelle activité (CREATE)
     */
    public function saveActivity()
    {
        // Vérifier que l'utilisateur est administrateur
        if (session('user.role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé.');
        }

        $rules = [
            'nom' => 'required|min_length[3]|max_length[100]',
            'description' => 'required|min_length[5]',
            'calories' => 'required|numeric|greater_than[0]',
            'duree' => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'calories' => $this->request->getPost('calories'),
            'duree' => $this->request->getPost('duree'),
        ];

        if ($this->activiteModel->createActivite($data)) {
            return redirect()->to('/admin')->with('success', 'Activité créée avec succès.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la création de l\'activité.');
        }
    }

    /**
     * Afficher le formulaire de modification d'une activité
     */
    public function editActivity($id)
    {
        // Vérifier que l'utilisateur est administrateur
        if (session('user.role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé.');
        }

        $data['activite'] = $this->activiteModel->getActivite($id);

        if (!$data['activite']) {
            return redirect()->to('/admin')->with('error', 'Activité non trouvée.');
        }

        return view('Admin/Activite/edit_activite', $data);
    }

    /**
     * Mettre à jour une activité (UPDATE)
     */
    public function updateActivity($id)
    {
        // Vérifier que l'utilisateur est administrateur
        if (session('user.role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé.');
        }

        $rules = [
            'nom' => 'required|min_length[3]|max_length[100]',
            'description' => 'required|min_length[5]',
            'calories' => 'required|numeric|greater_than[0]',
            'duree' => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'calories' => $this->request->getPost('calories'),
            'duree' => $this->request->getPost('duree'),
        ];

        if ($this->activiteModel->updateActivite($id, $data)) {
            return redirect()->to('/admin')->with('success', 'Activité mise à jour avec succès.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l\'activité.');
        }
    }

    /**
     * Afficher les détails d'une activité
     */
    public function viewActivity($id)
    {
        // Vérifier que l'utilisateur est administrateur
        if (session('user.role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé.');
        }

        $data['activite'] = $this->activiteModel->getActivite($id);

        if (!$data['activite']) {
            return redirect()->to('/admin')->with('error', 'Activité non trouvée.');
        }

        return view('Admin/Activite/view_activite', $data);
    }

    /**
     * Supprimer une activité (DELETE)
     */
    public function deleteActivity($id)
    {
        // Vérifier que l'utilisateur est administrateur
        if (session('user.role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé.');
        }
        $db = \Config\Database::connect();

        // Supprimer les suggestions liées à l'activité
        $db->table('suggestions')
            ->where('activite_id', $id)
            ->delete();

        // Ensuite supprimer l'activité
        if ($this->activiteModel->deleteActivite($id)) {

            return redirect()->to('/admin')
                ->with('success', 'Activité supprimée avec succès.');

        } else {

            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de l\'activité.');
        }
    }

    /**
     * Afficher les demandes de recharge
     */
    public function walletRequests()
    {
        if (session('user.role') !== 'admin') {
            return redirect()->to('/')
                ->with('error', 'Accès refusé.');
        }

        // TABLEAU PAGINÉ
        $transactions = $this->transactionModel
            ->select('transactions.*, users.nom, codes.code')
            ->join('users', 'users.id = transactions.user_id', 'left')
            ->join('codes', 'codes.id = transactions.code_id', 'left')
            ->orderBy('transactions.date', 'DESC')
            ->paginate(5);

        //Statistiques 
        $totalTransactions = $this->transactionModel->countAll();

        $pendingTransactions = $this->transactionModel
            ->where('status', 'pending')
            ->countAllResults();

        $approvedTransactions = $this->transactionModel
            ->where('status', 'approved')
            ->countAllResults();

        $rejectedTransactions = $this->transactionModel
            ->where('status', 'rejected')
            ->countAllResults();

        // TOTAL ARGENT VALIDÉ
        $validatedAmount = $this->transactionModel
            ->selectSum('montant')
            ->where('status', 'approved')
            ->first()['montant'];

        // TOTAL ARGENT EN ATTENTE
        $pendingAmount = $this->transactionModel
            ->selectSum('montant')
            ->where('status', 'pending')
            ->first()['montant'];

        return view('Admin/Wallet/wallet_requests', [
            'transactions' => $transactions,

            'pager' => $this->transactionModel->pager,

            'stats' => [
                'totalTransactions' => $totalTransactions,
                'pendingTransactions' => $pendingTransactions,
                'approvedTransactions' => $approvedTransactions,
                'rejectedTransactions' => $rejectedTransactions,
                'validatedAmount' => $validatedAmount ?? 0,
                'pendingAmount' => $pendingAmount ?? 0,
            ]
        ]);
    }
    /**
     * Accepter une recharge
     */
    public function acceptWalletRequest($id)
    {
        // Vérifier admin
        if (session('user.role') !== 'admin') {

            return redirect()->to('/')
                ->with('error', 'Accès refusé.');

        }

        $transaction = $this->transactionModel->find($id);

        if (!$transaction) {

            return redirect()->back()
                ->with('error', 'Transaction introuvable.');

        }

        // Déjà traitée
        if ($transaction['status'] !== 'pending') {

            return redirect()->back()
                ->with('error', 'Cette transaction a déjà été traitée.');

        }

        // Récupérer wallet utilisateur
        $wallet = $this->walletModel
            ->where('user_id', $transaction['user_id'])
            ->first();

        // Créer wallet si inexistant
        if (!$wallet) {

            $this->walletModel->insert([
                'user_id' => $transaction['user_id'],
                'solde' => 0
            ]);

            $wallet = $this->walletModel
                ->where('user_id', $transaction['user_id'])
                ->first();
        }

        // Ajouter argent
        $newBalance = $wallet['solde'] + $transaction['montant'];

        $this->walletModel->update($wallet['id'], [
            'solde' => $newBalance
        ]);

        // Valider transaction
        $this->transactionModel->update($id, [
            'status' => 'approved'
        ]);

        return redirect()->back()
            ->with('success', 'Recharge acceptée avec succès.');
    }

    /**
     * Refuser une recharge
     */
    public function refuseWalletRequest($id)
    {
        // Vérifier admin
        if (session('user.role') !== 'admin') {

            return redirect()->to('/')
                ->with('error', 'Accès refusé.');

        }

        $transaction = $this->transactionModel->find($id);

        if (!$transaction) {

            return redirect()->back()
                ->with('error', 'Transaction introuvable.');

        }

        // Déjà traitée
        if ($transaction['status'] !== 'pending') {

            return redirect()->back()
                ->with('error', 'Cette transaction a déjà été traitée.');

        }

        // Refuser transaction
        $this->transactionModel->update($id, [
            'status' => 'rejected'
        ]);

        return redirect()->back()
            ->with('success', 'Recharge refusée.');
    }


    /**Acitviation gold */
    public function approveGold($id)
    {
        $walletModel = new WalletModel();
        $userModel = new UserModel();
        $passageModel = new PassageGoldModel();
        $db = \Config\Database::connect();

        $db->transStart();

        // prix dynamique
        $prix = $db->table('prix_passage')->get()->getRow()->prix;

        // demande
        $request = $passageModel->find($id);
        if (!$request) {
            return redirect()->back()->with('error', 'Demande introuvable');
        }

        $userId = $request['user_id'];

        // 1. vérifier wallet + débit
        $success = $walletModel->deductMoney($userId, $prix);

        if (!$success) {
            $db->transComplete();
            return redirect()->back()->with('error', 'Solde insuffisant');
        }

        // 2. activer gold user
        $userModel->update($userId, [
            'is_gold' => 1
        ]);

        // 3. update demande
        $passageModel->update($id, [
            'statut' => 'approved'
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Erreur transaction');
        }

        return redirect()->back()->with('success', 'Utilisateur passé en Gold');
    }
    /*rejet gold */
    public function rejectGold($id)
    {
        $model = new PassageGoldModel();

        $model->update($id, [
            'statut' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Demande rejetée');
    }

    public function goldPending()
    {
        $passageModel = new PassageGoldModel();
        $userModel = new UserModel();
        $db = \Config\Database::connect();

        $perPage = 5;

        // ✔ PAGINATION PROPRE CI4 (IMPORTANT)
        $builder = $db->table('passage_gold');
        $builder->select('passage_gold.*, users.nom, users.email');
        $builder->join('users', 'users.id = passage_gold.user_id');
        $builder->orderBy('passage_gold.id', 'DESC');

        $requests = $passageModel
            ->select('passage_gold.*, users.nom, users.email')
            ->join('users', 'users.id = passage_gold.user_id')
            ->orderBy('passage_gold.id', 'DESC')
            ->paginate($perPage);

        $pager = $passageModel->pager;
        $priceModel = new PrixPassageModel();

        // STATS
        $totalGoldUsers = $userModel->where('is_gold', 1)->countAllResults();
        $pendingCount = $db->table('passage_gold')->where('statut', 'pending')->countAllResults();
        $processedCount = $db->table('passage_gold')
            ->whereIn('statut', ['approved', 'rejected'])
            ->countAllResults();

        return view('Admin/Gold/index', [
            'requests' => $requests,
            'pager' => $pager,
            'totalGoldUsers' => $totalGoldUsers,
            'pendingCount' => $pendingCount,
            'processedCount' => $processedCount,
            'currentPrice' => $priceModel->first()
        ]);
    }

    public function updatePrice()
    {
        $priceModel = new PrixPassageModel();
        $nouveauPrix = $this->request->getPost('prix');

        $config = $priceModel->first();

        $data = ['prix' => $nouveauPrix];

        if ($config) {
            $priceModel->update($config['id'], $data);
        } else {
            $priceModel->insert($data);
        }

        return redirect()->back()->with('success', 'Le prix du passage GOLD a été mis à jour.');
    }
}