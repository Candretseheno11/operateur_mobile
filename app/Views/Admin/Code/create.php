<?= $this->extend('Inc/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">➕ Ajouter un code</h2>

            <!-- BOUTON RETOUR -->
            <a href="/admin/code" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>

        <div class="card-body">

            <form action="/admin/code/store" method="POST">

                <?= csrf_field() ?>

                <!-- CODE -->
                <div class="mb-3">
                    <label class="form-label">Code</label>
                    <input type="text" name="code" class="form-control" required>
                </div>

                <!-- MONTANT -->
                <div class="mb-3">
                    <label class="form-label">Montant</label>
                    <input type="number" name="montant" class="form-control" required>
                </div>

                <!-- SUBMIT -->
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Enregistrer
                </button>

            </form>

        </div>

    </div>

</div>

<?= $this->endSection() ?>