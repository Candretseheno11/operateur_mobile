<?= $this->extend('Inc/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container adm-dashboard-container">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="adm-main-title">✏️ Modifier le Régime</h1>

        <a href="/admin/regime" class="btn btn-light shadow-sm adm-btn-action border">
            Retour
        </a>
    </div>

    <div class="card adm-card shadow-sm">
        <div class="card-body p-4">

            <form action="/admin/regime/update/<?= $regime['id'] ?>" method="POST">

                <?= csrf_field() ?>

                <div class="mb-4">
                    <label>Nom</label>

                    <input type="text" name="nom" class="form-control" value="<?= $regime['nom'] ?>" required>
                </div>

                <div class="mb-4">
                    <label>Description</label>

                    <textarea name="description" class="form-control" rows="4"
                        required><?= $regime['description'] ?></textarea>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-4">
                        <label>Prix</label>

                        <input type="number" step="0.01" name="prix" class="form-control"
                            value="<?= $regime['prix'] ?>">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Durée</label>

                        <input type="number" name="duree" class="form-control" value="<?= $regime['duree'] ?>">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Variation poids</label>

                        <input type="number" step="0.01" name="variation_poids" class="form-control"
                            value="<?= $regime['variation_poids'] ?>">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label>% Viande</label>

                        <input type="number" step="0.01" name="pourcentage_viande" class="form-control"
                            value="<?= $regime['pourcentage_viande'] ?>">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label>% Poisson</label>

                        <input type="number" step="0.01" name="pourcentage_poisson" class="form-control"
                            value="<?= $regime['pourcentage_poisson'] ?>">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label>% Volaille</label>

                        <input type="number" step="0.01" name="pourcentage_volaille" class="form-control"
                            value="<?= $regime['pourcentage_volaille'] ?>">
                    </div>

                </div>

                <button type="submit" class="btn btn-warning text-white">
                    Mettre à jour
                </button>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>