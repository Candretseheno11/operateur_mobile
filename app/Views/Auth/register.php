<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 1 | UserInfo</title>
    <!-- Bootstrap et  CSS -->
    <link rel="stylesheet" href="/asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/asset/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="asset/css/register.css">

</head>

<body>

    <div class="card card-custom">
        <!-- En-tête -->
        <div class="header-section text-center text-sm-start">
            <h2 class="fw-bold mb-1">Créer un compte</h2>
            <p class="opacity-75 mb-0">Informations de profil (1/2)</p>

            <div class="d-flex justify-content-between mt-4 mb-1">
                <small class="fw-bold text-uppercase" style="font-size: 0.7rem;">Progression</small>
                <small class="fw-bold" style="font-size: 0.7rem;">50%</small>
            </div>
            <div class="progress progress-custom">
                <div class="progress-bar progress-bar-custom" role="progressbar"></div>
            </div>
        </div>

        <!-- MESSAGES FLASH -->
        <div class="container">

            <?php if (isset($success)): ?>
                <div class="alert alert-danger">
                    <?php print_r($success); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php print_r($error); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Formulaire -->
        <div class="form-section">
            <form action="/register/save" method="POST">
                <?= csrf_field() ?>
                <!-- Nom -->
                <div class="mb-3">
                    <label class="form-label">Nom complet</label>
                    <div class="input-group">
                        <span class="input-group-text"> <i class="bi bi-person"></i> </span>
                        <input type="text" class="form-control shadow-none" placeholder="Jean Dupont" required
                            name="nom">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Adresse Email</label>
                    <div class="input-group">
                        <span class="input-group-text"> <i class="bi bi-envelope"></i> </span>
                        <input type="email" name="email" class="form-control shadow-none" placeholder="jean@exemple.com"
                            required>
                    </div>
                </div>

                <!-- Genre -->
                <div class="mb-3">

                    <label class="form-label d-block">Genre</label>

                    <div class="d-flex gap-3">

                        <input type="radio" class="btn-check" name="genre" id="homme" value="homme" autocomplete="off"
                            checked>
                        <label class="btn btn-outline-primary" for="homme">
                            Homme
                        </label>

                        <input type="radio" class="btn-check" name="genre" id="femme" value="femme" autocomplete="off">

                        <label class="btn btn-outline-primary" for="femme">
                            Femme
                        </label>

                    </div>
                </div>


                <!-- Mot de passe -->
                <div class="mb-4">
                    <label class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span> <input type="password"
                            id="password" name="password" class="form-control shadow-none" placeholder="••••••••"
                            required>

                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirmation -->
                <div class="mb-4">
                    <label class="form-label">Confirmer le mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="confirmPassword" class="form-control shadow-none"
                            placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordConfirm()">
                            <i class="bi bi-eye" id="eyeIcon1"></i>
                        </button>
                    </div>
                    <small id="message" class="text-danger"></small>
                </div>

                <!-- Bouton Suivant -->
                <button type="submit" id="submitBtn" class="btn btn-primary w-100 btn-next" disabled>
                    Suivant <i class="fas fa-arrow-right ms-2"></i>
                </button>
        </div>

        </form>

        <div class="text-center mt-4">
            <p class="text-muted small">Déjà un compte ? <a href="/login" class="login-link">Se connecter</a></p>
        </div>
    </div>
    </div>

    <script src="/asset/bootstrap/js/bootstrap.min.js"></script>

</body>

<script src="/asset/js/register.js"></script>

</html>