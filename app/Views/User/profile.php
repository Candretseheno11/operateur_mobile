<?= $this->extend('Inc/layout/main') ?>

<?= $this->section('content') ?>

<div class="row g-4">

    <!-- SECTION IMC  -->
    <div class="col-lg-5">
        <div class="card card-custom p-4 h-100">
            <ul class="nav nav-tabs nav-tabs-custom border-0 mb-4" id="imcTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold border-0 bg-transparent text-dark" id="view-imc-tab"
                        data-bs-toggle="tab" data-bs-target="#view-imc">Indicateur IMC</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold border-0 bg-transparent text-muted" id="edit-imc-tab"
                        data-bs-toggle="tab" data-bs-target="#edit-imc">Mettre à jour</button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="view-imc">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0 text-muted small text-uppercase">Statut actuel</h6>
                        <?php
                        $bgColorStatus = 'bg-secondary';
                        $textColorStatus = 'text-secondary';
                        $value = 'Inconnu';

                        if ($info['imc'] < 18.5) {
                            $bgColorStatus = 'bg-primary';
                            $textColorStatus = 'text-primary';
                            $value = 'Maigre';
                        } elseif ($info['imc'] < 25) {
                            $bgColorStatus = 'bg-success';
                            $textColorStatus = 'text-success';
                            $value = 'Normal';
                        } elseif ($info['imc'] < 30) {
                            $bgColorStatus = 'bg-warning';
                            $textColorStatus = 'text-warning';
                            $value = 'Surpoids';
                        } else {
                            $bgColorStatus = 'bg-danger';
                            $textColorStatus = 'text-danger';
                            $value = 'Obésité';
                        }
                        ?>
                        <span
                            class="badge <?= $bgColorStatus ?> bg-opacity-10 <?= $textColorStatus ?> rounded-pill px-3 py-2 fw-bold"><?= $value ?></span>
                    </div>

                    <div class="imc-display-box mb-4">
                        <div class="imc-number"><?= number_format($info['imc'], 1) ?><span class="imc-unit">kg/m²</span>
                        </div>
                        <p class="text-muted small mt-1">Votre Indice de Masse Corporelle</p>
                    </div>

                    <div class="row g-2 mb-4 text-center">
                        <div class="col-6">
                            <div class="p-2 border rounded-3">
                                <small class="text-muted d-block small-label">POIDS</small>
                                <strong class="fs-5">
                                    <?= $info['poids'] ?> kg
                                </strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded-3">
                                <small class="text-muted d-block small-label">TAILLE</small>
                                <strong class="fs-5"><?= round($info['taille'] / 100, 2) ?> m</strong>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-dark w-100 rounded-pill py-2 fw-bold"
                        onclick=" document.getElementById('edit-imc-tab').click();">
                        <i class="bi bi-pencil-square me-2"></i>Modifier mes données
                    </button>
                </div>

                <div class="tab-pane fade" id="edit-imc">
                    <form action="/imc/calculate" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nouveau poids (kg)</label>
                            <input type="number" step="0.1" class="form-control rounded-3" placeholder="ex: 70"
                                name="poids" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Taille (cm)</label>
                            <input type="number" class="form-control rounded-3" placeholder="ex: 175" name="taille"
                                required>
                        </div>
                        <button type="submit"
                            class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">Recalculer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION OBJECTIF -->
    <div class="col-lg-7">
        <div class="card card-custom p-4 h-100">
            <ul class="nav nav-tabs border-0 mb-4" id="objTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold border-0 bg-transparent text-dark" data-bs-toggle="tab"
                        data-bs-target="#view-obj">Objectif Actuel</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold border-0 bg-transparent text-muted" data-bs-toggle="tab"
                        data-bs-target="#edit-obj">Modifier</button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="view-obj">
                    <?php if (!empty($objectif)): ?>
                        <?php foreach ($objectif as $obj): ?>
                            <?php
                            $statusColor = match ((int) $obj['id']) {
                                1 => ['success', 'bi-graph-up-arrow'],
                                2 => ['danger', 'bi-graph-down-arrow'],
                                3 => ['primary', 'bi-bullseye'],
                                default => ['secondary', 'bi-flag']
                            };
                            ?>
                            <div
                                class="p-4 border-start border-4 border-<?= $statusColor[0] ?> bg-<?= $statusColor[0] ?> bg-opacity-10 rounded-end mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi <?= $statusColor[1] ?> fs-4 text-
                            <?= $statusColor[0] ?> me-3"></i>
                                    <h5 class="fw-bold mb-0 text-<?= $statusColor[0] ?>">
                                        <?= $obj['libelle'] ?>
                                    </h5>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-4 border-start border-4 border-secondary bg-light rounded-3
                            text-center">
                            <p class="text-muted fw-bold mb-0">Aucun objectif sélectionné</p>
                        </div>
                    <?php endif; ?>

                    <div class="mt-4 p-3 bg-light rounded-3 border border-dashed">
                        <p class="small mb-0 text-muted text-center italic">
                            "L'objectif influence vos recommandations de repas et de sport."
                        </p>
                    </div>
                </div>

                <div class="tab-pane fade" id="edit-obj">
                    <form action="/objectifs/save" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="user_id" value="<?= session()->get('user')['id']; ?>">
                        <div class="mb-4">
                            <label class=" form-label small fw-bold">Choisir un nouvel objectif</label>
                            <select name="objectif_id" class="form-select rounded-3 p-2" required>
                                <?php foreach ($liste_objectifs as $obj): ?>
                                    <option value="<?= $obj['id'] ?>"><?= $obj['libelle'] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Confirmer le
                            changement</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION SUGGESTIONS -->
    <div class="col-12 mt-2">
        <div class="d-flex justify-content-between align-items-center mb-4 px-2">
            <div>
                <h4 class="fw-bold mb-1">Recommandations du jour</h4>
                <p class="text-muted small mb-0">Basé sur votre IMC et votre objectif.</p>
            </div>
            <form action="/suggestions/generate" method="POST">
                <?= csrf_field() ?>
                <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" type="submit">
                    <i class="bi bi-stars me-2 "></i>Generer
                </button>
            </form>
        </div>

        <?php if (empty($suggestions)): ?>
            <div class="card card-custom border-dashed text-center py-5">
                <i class="bi bi-clipboard2-pulse fs-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3">Aucune suggestion disponible. Cliquez sur actualiser.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($suggestions as $suggestion): ?>
                    <div class="col-lg-6">
                        <div class="suggestion-card-modern">

                            <!-- PARTIE HAUT : RÉGIME -->
                            <div class="diet-segment">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">

                                        <div>
                                            <span class="segment-label">Régime suggéré</span>
                                            <h6 class="fw-bold mb-0 text-dark">
                                                <?= esc($suggestion['regime_nom']) ?>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="price-display">

                                            <?= number_format($suggestion['regime_prix'], 0, '.', ' ') ?> <small
                                                class="text-muted" style="font-size: 0.6em;">AR</small>
                                        </div>
                                        <?php if (session()->get('user')['is_gold']): ?>
                                            <span class="badge-gold-promo">MEMBRE GOLD -15%</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="bi bi-calendar3 me-2"></i> Programme de <?= $suggestion['regime_duree'] ?> jours
                                </div>
                            </div>

                            <!-- PARTIE BAS : ACTIVITÉ -->
                            <div class="activity-segment">
                                <div class="d-flex align-items-center mb-3">

                                    <div>
                                        <span class="segment-label">Activite conseillé</span>
                                        <h6 class="fw-bold mb-0 text-dark">
                                            <?= esc($suggestion['activite_nom']) ?>
                                        </h6>
                                    </div>
                                </div>

                                <div class="d-flex gap-4 mb-3">
                                    <div class="small fw-medium text-muted">
                                        <i class="bi bi-clock me-1 text-primary"></i>
                                        <?= $suggestion['activite_duree'] ?> min
                                    </div>
                                    <div class="small fw-medium text-muted">
                                        <i class="bi bi-fire me-1 text-danger"></i>
                                        <?= $suggestion['activite_calories'] ?> kcal
                                    </div>
                                </div>

                                <a href="/suggestions/<?= $suggestion['suggestion_id'] ?>" class="btn btn-outline-dark w-100
                        rounded-pill py-2 fw-bold small">
                                    Voir le programme détaillé <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>