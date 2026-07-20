<?= $this->extend('Inc/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container adm-dashboard-container">
    <!-- En-tête avec titre et bouton retour -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="adm-main-title">🏆 Gestion des Comptes GOLD</h1>
        <a href="/admin" class="btn btn-light shadow-sm adm-btn-action border">
            <i class="bi bi-arrow-left me-2"></i>Dashboard
        </a>
    </div>

    <!-- Affichage des messages flash -->
    <?php if (session('success')): ?>
    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= session('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
    <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card adm-card shadow-sm border-0">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-cash-coin me-2 text-warning"></i>Prix du passage GOLD
                    </h6>
                    <form action="/admin/gold/update-price" method="POST" class="d-flex gap-2">
                        <?= csrf_field() ?>
                        <div class="input-group">
                            <input type="number" step="0.01" name="prix" class="form-control form-control-modern"
                                value="<?= esc($currentPrice['prix'] ?? '0.00') ?>" required>
                            <span class="input-group-text bg-white">Ar</span>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Section Statistiques -->
    <h5 class="adm-card-title mb-4 px-1">
        <i class="bi bi-graph-up-arrow me-2 text-primary"></i>Aperçu des abonnements
    </h5>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="adm-stat-card adm-border-warning">
                <i class="bi bi-gem adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Utilisateurs GOLD</div>
                <div class="adm-stat-value text-warning"><?= $totalGoldUsers ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="adm-stat-card adm-border-primary">
                <i class="bi bi-hourglass-split adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Demandes en attente</div>
                <div class="adm-stat-value text-primary"><?= $pendingCount ?></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="adm-stat-card adm-border-success">
                <i class="bi bi-person-check adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Demandes traitées</div>
                <div class="adm-stat-value text-success"><?= $processedCount ?></div>
            </div>
        </div>
    </div>

    <!-- Section Tableau des Demandes -->
    <div class="card adm-card mb-5 shadow-sm">
        <div class="adm-card-header d-flex justify-content-between align-items-center p-3">
            <h5 class="adm-card-title m-0">
                <i class="bi bi-card-list me-2 text-primary"></i>Demandes de passage GOLD
            </h5>
        </div>

        <div class="card-body p-0">
            <?php if (empty($requests)): ?>
            <div class="p-5 text-center text-muted">
                <i class="bi bi-inbox fa-3x mb-3 opacity-25"></i>
                <p class="mb-0">Aucune demande pour le moment.</p>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table adm-table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th># ID</th>
                            <th>Utilisateur</th>
                            <th>Statut</th>
                            <th>Date de demande</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $r): ?>
                        <tr>
                            <td><span class="fw-bold text-muted"><?= esc($r['id']) ?></span></td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold"><?= esc($r['nom']) ?></span>
                                    <small class="text-muted"><?= esc($r['email']) ?></small>
                                </div>
                            </td>
                            <td>
                                <?php if ($r['statut'] === 'pending'): ?>
                                <span
                                    class="badge bg-warning bg-opacity-10 text-dark border border-warning-subtle adm-badge">
                                    <i class="bi bi-clock-history me-1"></i>En attente
                                </span>
                                <?php elseif ($r['statut'] === 'approved'): ?>
                                <span
                                    class="badge bg-success bg-opacity-10 text-success border border-success-subtle adm-badge">
                                    <i class="bi bi-check-circle me-1"></i>Validé
                                </span>
                                <?php else: ?>
                                <span
                                    class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle adm-badge">
                                    <i class="bi bi-x-circle me-1"></i>Rejeté
                                </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i><?= esc($r['created_at'] ?? '-') ?>
                                </small>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <?php if ($r['statut'] === 'pending'): ?>
                                    <!-- Bouton Valider -->
                                    <a href="/admin/gold/approve/<?= $r['id'] ?>"
                                        class="btn btn-sm btn-outline-success adm-btn-action"
                                        onclick="return confirm('Valider cette demande GOLD ?')" title="Approuver">
                                        <i class="bi bi-check-lg"></i> Valider
                                    </a>

                                    <!-- Bouton Refuser -->
                                    <a href="/admin/gold/reject/<?= $r['id'] ?>"
                                        class="btn btn-sm btn-outline-danger adm-btn-action"
                                        onclick="return confirm('Refuser cette demande ?')" title="Refuser">
                                        <i class="bi bi-trash"></i> Refuser
                                    </a>
                                    <?php else: ?>
                                    <span class="small text-muted italic">Traité</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

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

<?= $this->endSection() ?>