<?= $this->extend('Inc/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container adm-dashboard-container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-5">

        <h1 class="adm-main-title">
            🥗 Gestion des Régimes
        </h1>

        <a href="/" class="btn btn-light shadow-sm adm-btn-action border">
            <i class="bi bi-arrow-left me-2"></i>
            Retour
        </a>

    </div>

    <!-- FLASH MESSAGE -->
    <?php if (session('success')): ?>

        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4">

            <i class="bi bi-check-circle me-2"></i>
            <?= session('success') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php endif; ?>

    <?php if (session('error')): ?>

        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4">

            <i class="bi bi-exclamation-triangle me-2"></i>
            <?= session('error') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php endif; ?>
    <!-- STATS -->
    <h5 class="adm-card-title mb-4 px-1">

        <i class="bi bi-bar-chart-line me-2 text-success"></i>
        Statistiques des Régimes

    </h5>

    <div class="row g-4">

        <div class="col-md-3">

            <div class="adm-stat-card adm-border-success">

                <i class="bi bi-heart-pulse adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    Total Régimes
                </div>

                <div class="adm-stat-value">
                    <?= $stats['totalRegimes'] ?>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="adm-stat-card adm-border-primary">

                <i class="bi bi-cash adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    Prix Moyen
                </div>

                <div class="adm-stat-value">

                    <?= number_format($stats['avgRegimePrix'], 0, ',', ' ') ?>

                    <small class="fs-6">
                        Ar
                    </small>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="adm-stat-card adm-border-warning">

                <i class="bi bi-clock adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    Durée Moyenne
                </div>

                <div class="adm-stat-value">

                    <?= $stats['avgRegimeDuree'] ?>

                    <small class="fs-6">
                        jours
                    </small>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="adm-stat-card adm-border-danger">

                <i class="bi bi-graph-down adm-stat-icon-bg"></i>

                <div class="adm-stat-label">
                    Variation Moyenne
                </div>

                <div class="adm-stat-value">

                    <?= $stats['avgVariationPoids'] ?>

                    <small class="fs-6">
                        kg
                    </small>

                </div>

            </div>


        </div>
        <!-- TABLE REGIMES -->
        <div class="card adm-card mb-5">

            <div class="adm-card-header d-flex justify-content-between align-items-center">

                <h5 class="adm-card-title">
                    <i class="bi bi-heart-pulse me-2 text-success"></i>
                    Gestion des Régimes
                </h5>

                <a href="/admin/regime/create" class="btn btn-success adm-btn-action">

                    <i class="bi bi-plus-circle me-2"></i>
                    Ajouter un Régime

                </a>

            </div>

            <div class="card-body p-0">

                <?php if (empty($regimes)): ?>

                    <div class="p-5 text-center text-muted">

                        <i class="bi bi-folder-open fa-3x mb-3 opacity-25"></i>

                        <p class="mb-0">
                            Aucun régime trouvé.
                        </p>

                        <a href="/admin/regime/create" class="small text-success">

                            Créer le premier régime

                        </a>

                    </div>

                <?php else: ?>

                    <div class="table-responsive">

                        <table class="table adm-table mb-0">

                            <thead>

                                <tr>

                                    <th># ID</th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Prix</th>
                                    <th>Durée</th>
                                    <th>Variation</th>
                                    <th class="text-center">Actions</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($regimes as $regime): ?>

                                    <tr>

                                        <td>
                                            <span class="fw-bold text-muted">
                                                <?= $regime['id'] ?>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                <?= htmlspecialchars($regime['nom']) ?>
                                            </span>
                                        </td>

                                        <td style="max-width: 220px;">

                                            <small class="text-muted">

                                                <?= strlen($regime['description']) > 50
                                                    ? htmlspecialchars(substr($regime['description'], 0, 50)) . '...'
                                                    : htmlspecialchars($regime['description']) ?>

                                            </small>

                                        </td>

                                        <td>

                                            <span class="badge bg-success bg-opacity-10 text-success adm-badge">

                                                <?= number_format($regime['prix'], 0, ',', ' ') ?> Ar

                                            </span>

                                        </td>

                                        <td>

                                            <span class="badge bg-warning bg-opacity-10 text-warning adm-badge">

                                                <i class="bi bi-clock me-1"></i>
                                                <?= $regime['duree'] ?> jours

                                            </span>

                                        </td>

                                        <td>

                                            <span class="badge bg-danger bg-opacity-10 text-danger adm-badge">

                                                <?= $regime['variation_poids'] ?> kg

                                            </span>

                                        </td>

                                        <td>

                                            <div class="d-flex justify-content-center gap-2">

                                                <!-- VIEW -->
                                                <a href="/admin/regime/show/<?= $regime['id'] ?>"
                                                    class="btn btn-light btn-sm adm-btn-action border">

                                                    <i class="bi bi-eye text-info"></i>

                                                </a>

                                                <!-- EDIT -->
                                                <a href="/admin/regime/edit/<?= $regime['id'] ?>"
                                                    class="btn btn-light btn-sm adm-btn-action border">

                                                    <i class="bi bi-brush text-warning"></i>

                                                </a>

                                                <!-- DELETE -->

                                                <a href="/admin/regime/delete/<?= $regime['id'] ?>" class="btn "
                                                    onclick="return confirm('Supprimer ce régime ?')">
                                                    <i class="bi bi-trash text-danger"></i>

                                                </a>


                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php endif; ?>
                <div class="d-flex justify-content-center mt-4">
                    <nav>
                        <?= $pager->links('default', 'bootstrap_full') ?>
                    </nav>
                </div>
            </div>

        </div>


    </div>

    <?= $this->endSection() ?>