<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>

    <link rel="stylesheet" href="/asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/asset/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/asset/css/register.css">
</head>

<body>

    <div class="card card-custom">


        <div class="header-section text-center text-sm-start">
            <h2 class="fw-bold mb-1">Se connecter à un compte</h2>
        </div>

        <!--  MESSAGES FLASH-->
        <div class="container mt-2">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- FORM -->
        <div class="form-section">

            <form action="/login" method="POST">

                <?= csrf_field() ?>

                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label">Adresse Email</label>
                    <div class="input-group">
                        <span class="input-group-text"> <i class="bi bi-envelope"></i> </span>
                        <input type="email" name="email" class="form-control shadow-none" placeholder="jean@exemple.com"
                            required>
                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control shadow-none"
                            placeholder="••••••••" required>

                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- BOUTON -->
                <button type="submit" class="btn btn-primary w-100">
                    Se connecter
                </button>

            </form>

            <div class="text-center mt-4">
                <p class="text-muted small">
                    Pas de compte ?
                    <a href="/register">S'inscrire</a>
                </p>
            </div>

        </div>
    </div>

    <script src="/asset/js/login.js"></script>
    <script src="/asset/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>