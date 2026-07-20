<?= $this->extend('Inc/layout/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card card-custom p-4 h-100">
            <h5 class="fw-bold mb-3">Detail de la suggestion</h5>
            <div class="mb-4">
                <h6 class="fw-bold text-uppercase text-muted small">Regime alimentaire</h6>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-bold fs-5 mb-1"><?= $suggestion['regime_nom'] ?></div>
                        <?php if ($purchase): ?>
                            <div class="text-muted small mb-2"><?= $suggestion['regime_description'] ?></div>
                        <?php else: ?>
                            <div class="text-muted small mb-2">Description disponible apres achat.</div>
                        <?php endif; ?>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold"><?= number_format($pricing['final_price'], 0, '.', ' ') ?> Ar</div>
                        <?php if ($pricing['discount_rate'] > 0): ?>
                            <small class="text-muted" style="font-size: 0.7rem;">
                                Prix standard: <?= number_format($pricing['base_price'], 0, '.', ' ') ?> Ar
                            </small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="small text-muted">Duree: <?= $suggestion['regime_duree'] ?> jours</div>
            </div>

            <div class="border-top pt-3">
                <h6 class="fw-bold text-uppercase text-muted small">Activite sportive</h6>
                <div class="fw-bold fs-5 mb-1"><?= $suggestion['activite_nom'] ?></div>
                <?php if ($purchase): ?>
                    <div class="text-muted small mb-2"><?= $suggestion['activite_description'] ?></div>
                <?php else: ?>
                    <div class="text-muted small mb-2">Description disponible apres achat.</div>
                <?php endif; ?>
                <div class="small text-muted">Duree: <?= $suggestion['activite_duree'] ?> min |
                    <?= $suggestion['activite_calories'] ?> kcal
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card card-custom p-4">
            <h6 class="fw-bold mb-3">Achat</h6>
            <?php if ($purchase): ?>
                <div class="alert alert-success small">Suggestion deja achetee.</div>
                <a class="btn btn-dark w-100" href="/suggestions/<?= $suggestion['suggestion_id'] ?>/export">
                    <i class="bi bi-file-pdf me-2"></i> Exporter en PDF
                </a>
            <?php else: ?>
                <div class="small text-muted mb-3">
                    Achetez pour acceder aux details complets et a l'export PDF.
                </div>
                <div class="p-3 border rounded-3 bg-light mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="small text-muted">Prix a payer</span>
                        <span class="fw-bold"><?= number_format($pricing['final_price'], 0, '.', ' ') ?> Ar</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small text-muted">Solde actuel</span>
                        <span class="fw-bold">
                            <?= number_format($wallet['solde'] ?? 0, 0, '.', ' ') ?> Ar
                        </span>
                    </div>
                </div>
                <form action="/suggestions/<?= $suggestion['suggestion_id'] ?>/buy" method="POST">
                    <?= csrf_field() ?>
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-bag-check me-2"></i> Acheter
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>