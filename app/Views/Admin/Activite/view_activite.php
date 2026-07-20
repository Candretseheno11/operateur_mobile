<?= $this->extend('Inc/layout/admin') ?>

<!-- Lien vers le fichier CSS dédié -->
<link rel="stylesheet" href="<?= base_url('css/admin_style.css') ?>">

<?= $this->section('content') ?>

<div class="container adm-dashboard-container">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="adm-main-title">👁️ Détails de l'Activité</h1>
        <a href="/admin" class="btn btn-light shadow-sm adm-btn-action border">
            <i class="bi bi-arrow-left me-2"></i>Retour au panneau
        </a>
    </div>

    <div class="row g-4">
        <!-- Carte principale des détails -->
        <div class="col-lg-8">
            <div class="card adm-card shadow-sm h-100">
                <div class="adm-card-header bg-light bg-opacity-50">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="adm-card-title text-primary mb-0">
                            <i class="bi bi-info-circle me-2"></i>Fiche descriptive
                        </h5>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                            ID #<?= $activite['id'] ?>
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Titre de l'activité -->
                    <h2 class="fw-bold text-dark mb-4"><?= htmlspecialchars($activite['nom']) ?></h2>

                    <!-- Description -->
                    <div class="mb-5">
                        <label class="adm-stat-label d-block mb-2">Description</label>
                        <div
                            class="p-3 rounded-3 bg-light text-muted border-start border-4 border-primary border-opacity-25">
                            <?= nl2br(htmlspecialchars($activite['description'])) ?>
                        </div>
                    </div>

                    <!-- Métriques principales -->
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 border text-center bg-white shadow-sm">
                                <label class="adm-stat-label d-block mb-2">Dépense énergétique</label>
                                <div class="h3 fw-bold text-success mb-0">
                                    <i class="bi bi-fire me-2"></i><?= $activite['calories'] ?> <small
                                        class="fs-6">kcal</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 border text-center bg-white shadow-sm">
                                <label class="adm-stat-label d-block mb-2">Temps de référence</label>
                                <div class="h3 fw-bold text-warning mb-0">
                                    <i class="far fa-clock me-2"></i><?= $activite['duree'] ?> <small
                                        class="fs-6">min</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ratio PHP -->
                    <div class="p-3 rounded-3 bg-info bg-opacity-10 border border-info border-opacity-25 mb-5">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="adm-stat-label text-info-emphasis mb-0">Ratio d'intensité</span>
                            <span class="h5 fw-bold text-info mb-0">
                                <?= round($activite['calories'] / $activite['duree'], 2) ?> <small>kcal / min</small>
                            </span>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex justify-content-start gap-3 pt-3 border-top">
                        <a href="/admin/activity/<?= $activite['id'] ?>/edit"
                            class="btn btn-warning adm-btn-action text-white">
                            <i class="bi bi-edit me-2"></i>Modifier l'activité
                        </a>
                        <form method="POST" action="/admin/activity/<?= $activite['id'] ?>/delete"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-outline-danger adm-btn-action">
                                <i class="bi bi-trash me-2"></i>Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Statistiques et Infos -->
        <div class="col-lg-4">
            <!-- Bloc Projections -->
            <div class="card adm-card mb-4 shadow-sm">
                <div class="adm-card-header">
                    <h5 class="adm-card-title"><i class="bi bi-chart-pie me-2 text-primary"></i>Projections</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="adm-stat-label d-block mb-2">En 30 minutes</label>
                        <div class="d-flex align-items-baseline">
                            <span
                                class="h4 fw-bold text-dark mb-0"><?= round(($activite['calories'] / $activite['duree']) * 30, 0) ?></span>
                            <span class="ms-2 text-muted small">kcal brûlées</span>
                        </div>
                    </div>
                    <div>
                        <label class="adm-stat-label d-block mb-2">En 1 heure (60 min)</label>
                        <div class="d-flex align-items-baseline">
                            <span
                                class="h4 fw-bold text-primary mb-0"><?= round(($activite['calories'] / $activite['duree']) * 60, 0) ?></span>
                            <span class="ms-2 text-muted small">kcal brûlées</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bloc Infos Système -->
            <div class="card adm-card shadow-sm">
                <div class="adm-card-header">
                    <h5 class="adm-card-title"><i class="bi bi-database me-2 text-muted"></i>Informations</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="adm-stat-label d-block mb-1">Créée le</label>
                        <div class="text-muted small">
                            <i class="bi bi-calendar-plus me-1"></i>
                            <?= isset($activite['created_at']) ? $activite['created_at'] : 'Non renseignée' ?>
                        </div>
                    </div>
                    <div class="">
                        <label class="adm-stat-label d-block mb-1">Dernière modification</label>
                        <div class="text-muted small">
                            <i class="bi bi-history me-1"></i>
                            <?= isset($activite['updated_at']) ? $activite['updated_at'] : 'Aucune modif.' ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message info -->
            <div class="mt-4 p-3 rounded-3 bg-light text-center">
                <p class="small text-muted mb-0">
                    <i class="bi bi-mobile-alt me-2"></i>Aperçu de la fiche telle qu'elle apparaît pour les
                    utilisateurs.
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>