<?= $this->extend('Inc/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container adm-dashboard-container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="adm-main-title">
            💳 Gestion des Codes
        </h1>

        <a href="/admin/code/create" class="btn btn-primary adm-btn-action">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un code
        </a>
    </div>

    <!-- FLASH MESSAGES -->
    <?php if (session('success')): ?>
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i><?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- STATS CARDS (4 SUR UNE LIGNE) -->
    <div class="row g-4 mb-5">

        <div class="col-md-3">
            <div class="adm-stat-card adm-border-primary">
                <i class="bi bi-tags adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Total Codes</div>
                <div class="adm-stat-value"><?= $stats['totalCodes'] ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="adm-stat-card adm-border-success">
                <i class="bi bi-check-circle adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Utilisés</div>
                <div class="adm-stat-value"><?= $stats['usedCodes'] ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="adm-stat-card adm-border-warning">
                <i class="bi bi-hourglass-split adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Disponibles</div>
                <div class="adm-stat-value"><?= $stats['unusedCodes'] ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="adm-stat-card adm-border-danger">
                <i class="bi bi-cash-stack adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Montant Total</div>
                <div class="adm-stat-value">
                    <?= number_format($stats['totalMontant'], 0, ',', ' ') ?> Ar
                </div>
            </div>
        </div>

    </div>

    <!-- TABLE CARD -->
    <div class="card adm-card">

        <div class="adm-card-header d-flex justify-content-between align-items-center">
            <h5 class="adm-card-title">
                <i class="bi bi-upc-scan me-2 text-primary"></i>Liste des codes
            </h5>
        </div>

        <div class="card-body p-0">

            <?php if (empty($codes)): ?>

                <div class="p-5 text-center text-muted">
                    <i class="bi bi-inbox fa-3x mb-3 opacity-25"></i>
                    <p>Aucun code enregistré.</p>

                    <a href="/admin/code/create" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter le premier code
                    </a>
                </div>

            <?php else: ?>

                <div class="table-responsive">
                    <table class="table adm-table mb-0">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Montant</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($codes as $code): ?>

                                <tr>
                                    <td><?= $code['id'] ?></td>

                                    <td class="fw-bold"><?= esc($code['code']) ?></td>

                                    <td>
                                        <?= number_format($code['montant'], 0, ',', ' ') ?> Ar
                                    </td>

                                    <td>
                                        <?php if ($code['is_used']): ?>
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>Utilisé
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Disponible
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="/admin/code/edit/<?= $code['id'] ?>" class="btn btn-light btn-sm border"
                                                title="Modifier">
                                                <i class="bi bi-pencil-square text-warning"></i>
                                            </a>

                                            <form action="/admin/code/delete/<?= $code['id'] ?>" method="POST">
                                                <?= csrf_field() ?>
                                                <button class="btn btn-light btn-sm border"
                                                    onclick="return confirm('Supprimer ce code ?')">
                                                    <i class="bi bi-trash text-danger"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>
                </div>

            <?php endif; ?>

        </div>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <?= $pager->links('default', 'bootstrap_full') ?>
            </nav>
        </div>

    </div>

</div>

<?= $this->endSection() ?>