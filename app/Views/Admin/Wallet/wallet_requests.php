<?= $this->extend('Inc/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container adm-dashboard-container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="adm-main-title">
                💰 Validation des recharges
            </h1>

            <p class="text-muted mb-0">
                Gérez les demandes de recharge des utilisateurs.
            </p>
        </div>

        <a href="/admin" class="btn btn-light shadow-sm adm-btn-action border">
            <i class="bi bi-arrow-left me-2"></i>Retour
        </a>
    </div>

    <!-- ALERTES -->
    <?php if (session('success')): ?>
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i>
            <?= session('success') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <?= session('error') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>
        </div>
    <?php endif; ?>

    <!-- STATS -->
    <h5 class="adm-card-title mb-4 px-1">
        <i class="bi bi-bar-chart-line me-2 text-primary"></i>
        Statistiques des transactions
    </h5>

    <div class="row g-4 mb-5">

        <!-- TOTAL -->
        <div class="col-md-6 col-lg-3">
            <div class="adm-stat-card adm-border-primary">
                <i class="bi bi-list-check adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    Total
                </div>

                <div class="adm-stat-value">
                    <?= $stats['totalTransactions'] ?>
                </div>
            </div>
        </div>

        <!-- EN ATTENTE -->
        <div class="col-md-6 col-lg-3">
            <div class="adm-stat-card adm-border-warning">
                <i class="bi bi-hourglass-split adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    En attente
                </div>

                <div class="adm-stat-value">
                    <?= $stats['pendingTransactions'] ?>
                </div>
            </div>
        </div>

        <!-- VALIDÉ -->
        <div class="col-md-6 col-lg-3">
            <div class="adm-stat-card adm-border-success">
                <i class="bi bi-check-circle adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    Validées
                </div>

                <div class="adm-stat-value">
                    <?= $stats['approvedTransactions'] ?>
                </div>
            </div>
        </div>

        <!-- REJETÉ -->
        <div class="col-md-6 col-lg-3">
            <div class="adm-stat-card adm-border-danger">
                <i class="bi bi-x-circle adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    Rejetées
                </div>

                <div class="adm-stat-value">
                    <?= $stats['rejectedTransactions'] ?>
                </div>
            </div>
        </div>

        <!-- ARGENT VALIDÉ -->
        <div class="col-md-6 col-lg-3">
            <div class="adm-stat-card adm-border-success">
                <i class="bi bi-cash-stack adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    Argent validé
                </div>

                <div class="adm-stat-value">
                    <?= number_format($stats['validatedAmount'], 0, ',', ' ') ?>

                    <small class="fs-6">Ar</small>
                </div>
            </div>
        </div>

        <!-- ARGENT EN ATTENTE -->
        <div class="col-md-6 col-lg-3">
            <div class="adm-stat-card adm-border-warning">
                <i class="bi bi-wallet2 adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    En cours
                </div>

                <div class="adm-stat-value">
                    <?= number_format($stats['pendingAmount'], 0, ',', ' ') ?>

                    <small class="fs-6">Ar</small>
                </div>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="card adm-card mb-5">

        <div class="adm-card-header d-flex justify-content-between align-items-center">

            <h5 class="adm-card-title">
                <i class="bi bi-credit-card me-2 text-primary"></i>
                Demandes de recharge
            </h5>

        </div>

        <div class="card-body p-0">

            <?php if (empty($transactions)): ?>

                <div class="p-5 text-center text-muted">
                    <i class="bi bi-inbox fa-3x mb-3 opacity-25"></i>

                    <p class="mb-0">
                        Aucune transaction trouvée.
                    </p>
                </div>

            <?php else: ?>

                <div class="table-responsive">

                    <table class="table adm-table mb-0">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Utilisateur</th>
                                <th>Code</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($transactions as $transaction): ?>

                                <tr>

                                    <td>
                                        <span class="fw-bold text-muted">
                                            #<?= $transaction['id'] ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="fw-bold">
                                            <?= esc($transaction['nom']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= esc($transaction['code']) ?>
                                    </td>

                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info adm-badge">
                                            <?= number_format($transaction['montant'], 0, ',', ' ') ?> Ar
                                        </span>
                                    </td>

                                    <td>
                                        <small class="text-muted">
                                            <?= esc($transaction['date']) ?>
                                        </small>
                                    </td>

                                    <!-- STATUS -->
                                    <td>

                                        <?php if ($transaction['status'] == 'pending'): ?>

                                            <span class="badge bg-warning text-dark">
                                                En attente
                                            </span>

                                        <?php elseif ($transaction['status'] == 'approved'): ?>

                                            <span class="badge bg-success">
                                                Validé
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-danger">
                                                Rejeté
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- ACTIONS -->
                                    <td>

                                        <?php if ($transaction['status'] == 'pending'): ?>

                                            <div class="d-flex justify-content-center gap-2">

                                                <!-- VALIDER -->
                                                <form action="/admin/wallet-requests/accept/<?= $transaction['id'] ?>"
                                                    method="POST">

                                                    <?= csrf_field() ?>

                                                    <button type="submit" class="btn btn-success btn-sm" title="Valider">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>


                                                </form>

                                                <!-- REJETER -->
                                                <form action="/admin/wallet-requests/refuse/<?= $transaction['id'] ?>"
                                                    method="POST">

                                                    <?= csrf_field() ?>

                                                    <button type="submit" class="btn btn-danger btn-sm" title="Rejeter">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>

                                                </form>

                                            </div>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                Aucune action
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

            <!-- PAGINATION -->
            <div class="d-flex justify-content-center mt-4 mb-4">

                <nav>
                    <?= $pager->links('default', 'bootstrap_full') ?>
                </nav>

            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>