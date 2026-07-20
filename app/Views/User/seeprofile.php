<?= $this->extend('Inc/layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid p-0">
    <?php if (session('success')): ?>
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center"> <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div><?= session('success') ?></div>
            </div> <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center"> <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div><?= session('error') ?></div>
            </div> <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h3 class="fw-bold text-dark mb-1">👤 Mon Profil</h3>
            <p class="text-muted small mb-0">Gérez vos informations personnelles et votre sécurité.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="profile-header-card text-center mb-4">
                <div class="avatar-placeholder"> <?= strtoupper(substr($user['nom'] ?? 'U', 0, 1)) ?> </div>
                <h3 class="fw-bold mb-1"><?= esc($user['nom'] ?? 'Non défini') ?></h3>
                <p class="opacity-75 small mb-4"><?= esc($user['email'] ?? '') ?></p>

                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    <span
                        class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-25 px-3 py-2 rounded-pill small">
                        <i class="bi bi-shield-lock me-1"></i> <?= ucfirst($user['role'] ?? 'user') ?>
                    </span>
                    <?php if (!empty($user['is_gold']) && $user['is_gold'] == 1): ?>
                        <div class="gold-status-badge"> <i class="bi bi-star-fill me-1"></i> Membre GOLD </div>
                    <?php elseif (!empty($passage) && ($passage['statut'] ?? '') === 'pending'): ?>
                        <span class="badge bg-secondary px-3 py-2 rounded-pill small">
                            <i class="bi bi-hourglass-split me-1"></i> En attente Gold
                        </span>
                    <?php endif; ?>
                </div>

                <div class="pt-4 border-top border-white border-opacity-10 mt-2">
                    <?php if (!empty($user['is_gold']) && $user['is_gold'] == 1): ?>
                        <div class="alert alert-warning border-0 mb-0 py-2 small fw-bold">
                            <i class="bi bi-patch-check-fill me-2"></i>Compte Premium Activé
                        </div>

                    <?php elseif (!empty($passage) && ($passage['statut'] ?? '') === 'pending'): ?>
                        <button class="btn btn-light w-100 py-2 fw-bold rounded-3 shadow-sm border-0 opacity-75" disabled
                            style="cursor: not-allowed;">
                            <i class="bi bi-clock-history me-2"></i>Demande en cours...
                        </button>

                    <?php elseif ($passage && $passage['statut'] === 'rejected'): ?>
                        <form action="/gold/request" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger w-100 py-2 fw-bold rounded-3 shadow-sm border-0">
                                <i class="bi bi-arrow-clockwise me-2"></i>Réessayer (Refusé)
                            </button>
                        </form>

                    <?php else: ?>
                        <form action="/gold/request" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-warning w-100 py-2 fw-bold rounded-3 shadow-sm border-0">
                                <i class="bi bi-stars me-2"></i>Devenir Membre GOLD
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card card-modern bg-light">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-shield-check text-primary fs-2 mb-2 d-block"></i>
                    <h6 class="fw-bold">Compte sécurisé</h6>
                    <p class="text-muted small mb-0">Vos données sont protégées par chiffrement.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-modern shadow-sm mb-4 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h6 class="fw-bold m-0"><i class="bi bi-pencil-square me-2 text-primary"></i>Informations
                        personnelles</h6>
                </div>
                <div class="card-body p-4">
                    <form action="/profile/update" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="info-mini-label">Nom complet</label>
                                <input type="text" name="nom" value="<?= esc($user['nom'] ?? '') ?>"
                                    class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-7">
                                <label class="info-mini-label">Adresse E-mail</label>
                                <input type="email" name="email" value="<?= esc($user['email'] ?? '') ?>"
                                    class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-5">
                                <label class="info-mini-label">Genre</label>
                                <select name="genre" class="form-select form-control-modern">
                                    <option value="homme" <?= ($user['genre'] ?? '') == 'homme' ? 'selected' : '' ?>>
                                        Homme</option>
                                    <option value="femme" <?= ($user['genre'] ?? '') == 'femme' ? 'selected' : '' ?>>
                                        Femme</option>
                                    <option value="autre" <?= ($user['genre'] ?? '') == 'autre' ? 'selected' : '' ?>>
                                        Autre</option>
                                </select>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 shadow-sm">
                                    <i class="bi bi-save me-2"></i>Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-modern shadow-sm overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h6 class="fw-bold m-0"><i class="bi bi-key me-2 text-dark"></i>Sécurité du compte</h6>
                </div>
                <div class="card-body p-4">
                    <form action="/profile/change-password" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="info-mini-label">Ancien mot de passe</label>
                                <input type="password" name="old_password" class="form-control form-control-modern"
                                    placeholder="••••••••" required>
                            </div>
                            <div class="col-md-6">
                                <label class="info-mini-label">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="info-mini-label">Confirmer nouveau mot de passe</label>
                                <input type="password" id="confirmPassword" name="confirmPassword"
                                    class="form-control form-control-modern" required>
                            </div>
                            <div class="col-12"><small id="message"></small></div>
                            <div class="col-12 mt-2">
                                <button type="submit" id="submitBtn" class="btn btn-dark" disabled>
                                    <i class="bi bi-shield-lock me-2"></i>Mettre à jour le mot de passe
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('asset/js/modify.js') ?>"></script>
<?= $this->endSection() ?>