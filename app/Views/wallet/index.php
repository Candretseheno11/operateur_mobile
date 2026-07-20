<?= $this->extend('Inc/layout/main') ?>

<?= $this->section('content') ?>

<style>
    /* Style spécifique pour la carte Wallet */
</style>

<div class="container adm-dashboard-container mt-5">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="adm-main-title">💰 Mon Portefeuille</h1>
            <p class="text-muted">Gérez vos crédits et votre historique.</p>
        </div>
        <a href="/profile" class="btn btn-light shadow-sm adm-btn-action border">
            <i class="bi bi-person me-2"></i>Retour au profil
        </a>
    </div>

    <div class="row g-4">
        <!-- Colonne Gauche : Carte et Formulaire -->
        <div class="col-lg-4">

            <!-- Nouvelle Carte de Solde Compacte Style "Card" -->
            <div class="card wallet-card-premium">
                <div class="wallet-chip"></div>
                <div class="wallet-label">Solde disponible</div>
                <div class="wallet-balance">
                    <?= $wallet ? number_format($wallet['solde'], 0, ',', ' ') : '0' ?>
                    <span class="fs-5 fw-light">Ar</span>
                </div>
                <i class="bi bi-wifi-2 position-absolute"
                    style="top: 25px; right: 25px; transform: rotate(90deg); opacity: 0.5;"></i>
            </div>

            <!-- Formulaire de Recharge -->
            <div class="card adm-card shadow-sm border-0">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Recharger mon compte</h6>
                    <form action="/wallet/add" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i
                                        class="bi bi-upc"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="code" name="code"
                                    placeholder="Code de recharge" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">
                            Confirmer la recharge
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Colonne Droite : Historique -->
        <div class="col-lg-8">
            <!-- Alertes de Session déplacées ici pour ne pas casser le design à gauche -->
            <?php if (session('success')): ?>
                <div class="alert alert-success border-0 shadow-sm mb-4"><?= session('success') ?></div>
            <?php endif; ?>
            <?php if (session('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm mb-4"><?= session('error') ?></div>
            <?php endif; ?>

            <div class="card adm-card shadow-sm">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="adm-card-title m-0">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Transactions récentes
                    </h5>
                </div>

                <div class="card-body p-0">
                    <?php if (empty($transactions)): ?>
                        <div class="p-5 text-center text-muted">
                            <p>Aucun mouvement sur votre compte.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table adm-table mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Date</th>
                                        <th>Code</th>
                                        <th>Montant</th>
                                        <th class="text-center">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $transaction): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="small fw-bold"><?= date('d/m/Y', strtotime($transaction['date'])) ?>
                                                </div>
                                                <div class="text-muted small">
                                                    <?= date('H:i', strtotime($transaction['date'])) ?>
                                                </div>
                                            </td>
                                            <td><small
                                                    class="text-monospace text-muted"><?= esc($transaction['code'] ?? '—') ?></small>
                                            </td>
                                            <td><span class="fw-bold">+
                                                    <?= number_format($transaction['montant'], 0, ',', ' ') ?> Ar</span></td>
                                            <td class="text-center">
                                                <?php $status = $transaction['status'] ?? 'pending'; ?>
                                                <?php if ($status === 'approved'): ?>
                                                    <span
                                                        class="badge rounded-pill bg-success-subtle text-success px-3">Validé</span>
                                                <?php elseif ($status === 'rejected'): ?>
                                                    <span class="badge rounded-pill bg-danger-subtle text-danger px-3">Refusé</span>
                                                <?php else: ?>
                                                    <span
                                                        class="badge rounded-pill bg-warning-subtle text-warning px-3">Attente</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    <!-- Pagination -->
                    <?php if ($pager): ?>
                        <div class="card-footer bg-white border-0 py-3">
                            <div class="d-flex justify-content-center">
                                <?= $pager->links('default', 'bootstrap_full') ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>