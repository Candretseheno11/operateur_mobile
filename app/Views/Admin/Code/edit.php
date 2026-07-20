<?= $this->extend('Inc/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container mt-4">

    <div class="card">
        <div class="card-body">

            <h2 class="mb-4">Modifier le code</h2>

            <form action="/admin/code/update/<?= $codeData['id'] ?>" method="POST">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <label>Code</label>

                    <input type="text" name="code" class="form-control" value="<?= $codeData['code'] ?>" required>
                </div>

                <div class="mb-3">
                    <label>Montant</label>

                    <input type="number" name="montant" class="form-control" value="<?= $codeData['montant'] ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label>Status</label>

                    <select name="is_used" class="form-control">

                        <option value="0" <?= !$codeData['is_used'] ? 'selected' : '' ?>>
                            Disponible
                        </option>

                        <option value="1" <?= $codeData['is_used'] ? 'selected' : '' ?>>
                            Utilisé
                        </option>

                    </select>
                </div>

                <button type="submit" class="btn btn-warning">
                    Modifier
                </button>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>