<?= $this->extend('Inc/layout/admin') ?>

<!-- Lien vers le fichier CSS dédié -->
<link rel="stylesheet" href="<?= base_url('css/admin_style.css') ?>">

<?= $this->section('content') ?>

<div class="container adm-dashboard-container">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="adm-main-title">✏️ Modifier l'Activité</h1>
        <a href="/admin" class="btn btn-light shadow-sm adm-btn-action border">
            <i class="bi bi-arrow-left me-2"></i>Retour au panneau
        </a>
    </div>

    <!-- Afficher les erreurs de validation -->
    <?php if (session('errors')): ?>
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex">
                <i class="bi bi-exclamation-circle fa-lg me-3 mt-1"></i>
                <div>
                    <h6 class="fw-bold mb-1">Erreurs de validation :</h6>
                    <ul class="mb-0 small">
                        <?php foreach (session('errors') as $field => $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Formulaire principal -->
        <div class="col-lg-8">
            <div class="card adm-card shadow-sm">
                <div class="adm-card-header">
                    <h5 class="adm-card-title text-warning">
                        <i class="bi bi-pencil-alt me-2"></i>Édition des informations
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="/admin/activity/<?= $activite['id'] ?>/update" method="POST" id="activityForm">
                        <?= csrf_field() ?>

                        <!-- Nom -->
                        <div class="mb-4">
                            <label for="nom" class="adm-stat-label mb-2 d-block">
                                Nom de l'activité <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i
                                        class="bi bi-tag"></i></span>
                                <input type="text"
                                    class="form-control border-start-0 ps-0 shadow-none <?= session('errors.nom') ? 'is-invalid' : '' ?>"
                                    id="nom" name="nom" placeholder="Ex: Course à pied"
                                    value="<?= isset($activite) ? htmlspecialchars($activite['nom']) : old('nom') ?>"
                                    required>
                            </div>
                            <?php if (session('errors.nom')): ?>
                                <div class="text-danger small mt-1"><?= session('errors.nom') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="adm-stat-label mb-2 d-block">
                                Description détaillée <span class="text-danger">*</span>
                            </label>
                            <textarea
                                class="form-control shadow-none <?= session('errors.description') ? 'is-invalid' : '' ?>"
                                id="description" name="description" rows="5" placeholder="Décrivez l'activité..."
                                required><?= isset($activite) ? htmlspecialchars($activite['description']) : old('description') ?></textarea>
                            <?php if (session('errors.description')): ?>
                                <div class="text-danger small mt-1"><?= session('errors.description') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-4">
                            <!-- Calories -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="calories" class="adm-stat-label mb-2 d-block">
                                        Calories (kcal) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                                class="bi bi-fire"></i></span>
                                        <input type="number"
                                            class="form-control border-start-0 ps-0 shadow-none <?= session('errors.calories') ? 'is-invalid' : '' ?>"
                                            id="calories" name="calories" placeholder="Ex: 300"
                                            value="<?= isset($activite) ? $activite['calories'] : old('calories') ?>"
                                            step="0.01" required>
                                    </div>
                                    <?php if (session('errors.calories')): ?>
                                        <div class="text-danger small mt-1"><?= session('errors.calories') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Durée -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="duree" class="adm-stat-label mb-2 d-block">
                                        Durée (minutes) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                                class="bi bi-clock"></i></span>
                                        <input type="number"
                                            class="form-control border-start-0 ps-0 shadow-none <?= session('errors.duree') ? 'is-invalid' : '' ?>"
                                            id="duree" name="duree" placeholder="Ex: 30"
                                            value="<?= isset($activite) ? $activite['duree'] : old('duree') ?>"
                                            step="0.01" required>
                                    </div>
                                    <?php if (session('errors.duree')): ?>
                                        <div class="text-danger small mt-1"><?= session('errors.duree') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-end gap-3 mt-3">
                            <a href="/admin" class="btn btn-light adm-btn-action border px-4">Annuler</a>
                            <button type="submit" class="btn btn-warning adm-btn-action text-white px-4">
                                <i class="bi bi-sync-alt me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Section Informations de traçabilité -->
        <div class="col-lg-4">
            <div class="card adm-card bg-white h-100">
                <div class="adm-card-header">
                    <h5 class="adm-card-title"><i class="bi bi-info-circle me-2 text-info"></i>Informations système
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 pb-3 border-bottom">
                        <label class="adm-stat-label d-block mb-1">Identifiant unique</label>
                        <div class="fw-bold text-dark"># <?= $activite['id'] ?></div>
                    </div>

                    <div class="mb-4 pb-3 border-bottom">
                        <label class="adm-stat-label d-block mb-1">Date de création</label>
                        <div class="text-muted small">
                            <i class="far fa-calendar-alt me-1"></i>
                            <?= isset($activite['created_at']) ? $activite['created_at'] : 'N/A' ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="adm-stat-label d-block mb-1">Dernière modification</label>
                        <div class="text-muted small">
                            <i class="bi bi-history me-1"></i>
                            <?= isset($activite['updated_at']) ? $activite['updated_at'] : 'N/A' ?>
                        </div>
                    </div>

                    <div class="mt-5 p-3 rounded-3 bg-warning bg-opacity-10 border border-warning border-opacity-25">
                        <p class="small text-warning-emphasis mb-0 italic">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Les modifications apportées seront appliquées immédiatement sur l'application mobile.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>