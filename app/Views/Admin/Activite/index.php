<?= $this->extend('Inc/layout/admin') ?>


<?= $this->section('content') ?>

<div class="container adm-dashboard-container">
    <!-- En-tête avec titre et bouton retour -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="adm-main-title">✨ Gestion D'activite</h1>
        <a href="/" class="btn btn-light shadow-sm adm-btn-action border">
            <i class="bi bi-arrow-left me-2"></i>Retour
        </a>
    </div>


    <!-- Affichage des messages flash (Succès / Erreur) -->
    <?php if (session('success')): ?>
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Section Statistiques (Grid de cartes) -->
    <h5 class="adm-card-title mb-4 px-1">
        <i class="bi bi-chart-line me-2 text-primary"></i>Statistiques de la plateforme
    </h5>

    <!-- Première rangée de stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="adm-stat-card adm-border-primary">
                <i class="bi bi-list-check adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Total Activités</div>
                <div class="adm-stat-value"><?= $stats['totalActivites'] ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="adm-stat-card adm-border-success">
                <i class="bi bi-fire-alt adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Calories Moy.</div>
                <div class="adm-stat-value"><?= $stats['caloriesAverage'] ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="adm-stat-card adm-border-warning">
                <i class="bi bi-stopwatch adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Durée Moyenne</div>
                <div class="adm-stat-value"><?= $stats['dureeAverage'] ?> <small class="fs-6">min</small></div>
            </div>
        </div>

        <!-- Section Gestion des Activités (Tableau) -->
        <div class="card adm-card mb-5">
            <div class="adm-card-header d-flex justify-content-between align-items-center">
                <h5 class="adm-card-title">
                    <i class="bi bi-running me-2 text-primary"></i>Gestion des Activités
                </h5>
                <a href="/admin/activity/create" class="btn btn-primary adm-btn-action">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter une Activité
                </a>
            </div>

            <div class="card-body p-0">
                <!-- Vérification si la liste des activités est vide -->
                <?php if (empty($activites)): ?>
                    <div class="p-5 text-center text-muted">
                        <i class="bi bi-folder-open fa-3x mb-3 opacity-25"></i>
                        <p class="mb-0">Aucune activité trouvée.</p>
                        <a href="/admin/activity/create" class="small text-primary">Créer la première activité</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table adm-table mb-0">
                            <thead>
                                <tr>
                                    <th># ID</th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Calories</th>
                                    <th>Durée</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Boucle sur les activités -->
                                <?php foreach ($activites as $activite): ?>
                                    <tr>
                                        <td><span class="fw-bold text-muted"><?= $activite['id'] ?></span></td>
                                        <td><span class="fw-bold"><?= htmlspecialchars($activite['nom']) ?></span></td>
                                        <td style="max-width: 200px;">
                                            <small class="text-muted">
                                                <?= strlen($activite['description']) > 50
                                                    ? htmlspecialchars(substr($activite['description'], 0, 50)) . '...'
                                                    : htmlspecialchars($activite['description']) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info adm-badge">
                                                <?= $activite['calories'] ?> kcal
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning bg-opacity-10 text-warning adm-badge">
                                                <i class="bi bi-clock me-1"></i><?= $activite['duree'] ?> min
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Bouton Voir -->
                                                <a href="/admin/activity/<?= $activite['id'] ?>/view"
                                                    class="btn btn-light btn-sm adm-btn-action border" title="Voir">
                                                    <i class="bi bi-eye text-info"></i>
                                                </a>
                                                <!-- Bouton Modifier -->
                                                <a href="/admin/activity/<?= $activite['id'] ?>/edit"
                                                    class="btn btn-light btn-sm adm-btn-action border" title="Modifier">
                                                    <i class="bi bi-brush text-warning"></i>
                                                </a>
                                                <!-- Formulaire Supprimer -->

                                                <a href="/admin/activity/<?= $activite['id'] ?>/delete" class="btn "
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

                <div class="d-flex justify -content-center mt-4">
                    <nav>
                        <?= $pager->links('default', 'bootstrap_full') ?>
                    </nav>
                </div>
            </div>
        </div>



    </div>

    <!-- Deuxième rangée de stats -->

</div><?= $this->endSection() ?>