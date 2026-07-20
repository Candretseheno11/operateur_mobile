<?= $this->extend('Inc/layout/main') ?>

<?= $this->section('content') ?>
<div class="card card-custom p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Vos suggestions</h5>
        <form action="/suggestions/generate" method="POST">
            <?= csrf_field() ?>
            <button class="btn btn-dark btn-sm rounded-pill px-3" type="submit">
                <i class="bi bi-stars me-2"></i> Generer
            </button>
        </form>
    </div>

    <?php if (empty($suggestions)): ?>
        <div class="p-3 bg-light rounded-3 border text-center">
            <p class="small text-muted mb-0">
                Aucune suggestion disponible. Choisissez un objectif puis generez vos recommandations.
            </p>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($suggestions as $suggestion): ?>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-white h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold small text-uppercase text-muted mb-1">Regime suggere</h6>
                                <span class="fw-medium">
                                    <i class="bi bi-utensils text-success me-2"></i>
                                    <?= $suggestion['regime_nom'] ?>
                                </span>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold d-block"><?= number_format($suggestion['regime_prix'], 0, '.', ' ') ?>
                                    Ar</span>
                                <?php if (session()->get('user')['is_gold']): ?>
                                    <small class="text-muted" style="font-size: 0.7rem;">-15% avec Gold</small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="small text-muted mb-3">
                            Duree: <?= $suggestion['regime_duree'] ?> jours
                        </div>
                        <div class="border-top pt-2">
                            <h6 class="fw-bold small text-uppercase text-muted mb-1">Activite conseillee</h6>
                            <span class="fw-medium">
                                <i class="bi bi-heartbeat text-primary me-2"></i>
                                <?= $suggestion['activite_nom'] ?>
                            </span>
                            <div class="small text-muted">
                                Duree: <?= $suggestion['activite_duree'] ?> min | <?= $suggestion['activite_calories'] ?> kcal
                            </div>
                        </div>
                        <div class="mt-3">
                            <a class="btn btn-outline-primary btn-sm" href="/suggestions/<?= $suggestion['suggestion_id'] ?>">
                                Voir details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>