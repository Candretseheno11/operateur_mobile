<?= $this->extend('Inc/layout/admin') ?>

<!-- Lien vers le fichier CSS dédié -->
<link rel="stylesheet" href="<?= base_url('css/admin_style.css') ?>">

<?= $this->section('content') ?>

<div class="container adm-dashboard-container">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="adm-main-title">➕ Créer une Activité</h1>
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
                    <h5 class="adm-card-title text-primary">
                        <i class="bi bi-edit me-2"></i>Informations de l'activité
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="/admin/activity/save" method="POST" id="activityForm">
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
                                    id="nom" name="nom" placeholder="Ex: Course à pied" value="<?= old('nom') ?>"
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
                                id="description" name="description" rows="5"
                                placeholder="Expliquez en quoi consiste cette activité..."
                                required><?= old('description') ?></textarea>
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
                                            value="<?= old('calories') ?>" step="0.01" required>
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
                                        Durée estimée (minutes) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                                class="bi bi-clock"></i></span>
                                        <input type="number"
                                            class="form-control border-start-0 ps-0 shadow-none <?= session('errors.duree') ? 'is-invalid' : '' ?>"
                                            id="duree" name="duree" placeholder="Ex: 30" value="<?= old('duree') ?>"
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
                            <button type="submit" class="btn btn-primary adm-btn-action px-4">
                                <i class="bi bi-save me-2"></i>Créer l'activité
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Section Aide latérale -->
        <div class="col-lg-4">
            <div class="card adm-card bg-white h-100">
                <div class="adm-card-header">
                    <h5 class="adm-card-title"><i class="bi bi-lightbulb me-2 text-warning"></i>Guide de création</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-4">
                        <div class="me-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2"
                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">1</span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Identité</h6>
                            <p class="text-muted small mb-0">Choisissez un nom court et explicite (ex: Yoga matinal).
                            </p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="me-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2"
                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">2</span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Détails techniques</h6>
                            <p class="text-muted small mb-0">Indiquez les calories brûlées pour une séance type afin
                                d'aider les utilisateurs dans leur suivi.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle p-2"
                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">3</span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Impact</h6>
                            <p class="text-muted small mb-0">Une bonne description motive davantage l'utilisateur à
                                essayer l'activité.</p>
                        </div>
                    </div>

                    <div class="mt-5 p-3 rounded-3 bg-light">
                        <p class="small text-muted mb-0 italic text-center">
                            <i class="bi bi-info-circle me-1"></i> Tous les champs marqués d'une étoile (*) sont
                            obligatoires.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>