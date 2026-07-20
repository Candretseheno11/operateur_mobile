<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 2 | DietHealth</title>
    <!-- Bootstrap et  CSS -->
    <link rel="stylesheet" href="/asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/asset/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/asset/css/health.css">

</head>

<body>

    <div class="card card-custom">
        <!-- En-tête -->
        <div class="header-section text-center text-sm-start">
            <h2 class="fw-bold mb-1">Créer un compte</h2>
            <p class="opacity-75 mb-0">Informations de profil (2/2)</p>

            <div class="d-flex justify-content-between mt-4 mb-1">
                <small class="fw-bold text-uppercase" style="font-size: 0.7rem;">Progression</small>
                <small class="fw-bold" style="font-size: 0.7rem;">100%</small>
            </div>
            <div class="progress progress-custom">
                <div class="progress-bar progress-bar-custom" role="progressbar"></div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="form-section">
            <form action="/register/health/save" method="POST">
                <?= csrf_field() ?>
                <!-- Poids -->
                <div class="mb-3">
                    <label class="form-label">Poids</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-weight"></i></span>
                        <input type="text" class="form-control shadow-none" placeholder="70 kg" required name="poids">

                        <input type="hidden" value="<?= session()->get('temp')['id'] ?>" name="user_id">
                    </div>
                </div>

                <!-- Taille -->
                <div class="mb-3">
                    <label class="form-label">Taille</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-ruler-vertical"></i></span>
                        <input type="text" class="form-control shadow-none" placeholder="175 " required name="taille">
                    </div>
                </div>





                <!-- Bouton Inscription -->
                <button type="submit" class="btn btn-primary w-100 btn-next">
                    S' inscrire <i class="fas fa-arrow-right ms-2"></i>
                </button>

            </form>

            <div class="text-center mt-4">
                <p class="text-muted small">Déjà un compte ? <a href="/login" class="login-link">Se connecter</a></p>
            </div>
        </div>
    </div>

    <script src="/asset/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>