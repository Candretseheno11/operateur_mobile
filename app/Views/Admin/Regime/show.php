<?= $this->extend('Inc/layout/admin') ?>

<link rel="stylesheet" href="<?= base_url('css/admin_style.css') ?>">

<?= $this->section('content') ?>

<div class="container adm-dashboard-container">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="adm-main-title">👁️ Détails du Régime</h1>

        <a href="/admin/regime" class="btn btn-light shadow-sm adm-btn-action border">
            Retour
        </a>
    </div>

    <div class="card adm-card shadow-sm">
        <div class="card-body p-5">

            <h2 class="fw-bold mb-4">
                <?= $regime['nom'] ?>
            </h2>

            <div class="mb-5">
                <?= nl2br($regime['description']) ?>
            </div>

            <div class="row">

                <div class="col-md-4 mb-4">
                    <div class="border rounded p-3 text-center">
                        <h5>Prix</h5>

                        <div class="fw-bold text-primary">
                            <?= $regime['prix'] ?> Ar
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="border rounded p-3 text-center">
                        <h5>Durée</h5>

                        <div class="fw-bold text-success">
                            <?= $regime['duree'] ?> jours
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="border rounded p-3 text-center">
                        <h5>Variation</h5>

                        <div class="fw-bold text-danger">
                            <?= $regime['variation_poids'] ?> kg
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-5">

                <h4 class="mb-4">Composition</h4>

                <ul class="list-group">

                    <li class="list-group-item">
                        Viande :
                        <?= $regime['pourcentage_viande'] ?>%
                    </li>

                    <li class="list-group-item">
                        Poisson :
                        <?= $regime['pourcentage_poisson'] ?>%
                    </li>

                    <li class="list-group-item">
                        Volaille :
                        <?= $regime['pourcentage_volaille'] ?>%
                    </li>

                </ul>

            </div>

            <div class="mt-5 d-flex gap-3">

                <a href="/admin/regime/edit/<?= $regime['id'] ?>" class="btn btn-warning text-white">
                    Modifier
                </a>

                <a href="/admin/regime/delete/<?= $regime['id'] ?>" class="btn btn-danger"
                    onclick="return confirm('Supprimer ce régime ?')">
                    Supprimer
                </a>

            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>