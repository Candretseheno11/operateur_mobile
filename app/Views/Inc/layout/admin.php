<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Tableau de bord Utilisateur' ?></title>
    <link rel="stylesheet" href="/asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/asset/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/asset/css/admin_layout.css">
    <link rel="stylesheet" href="/asset/css/admin.css">

</head>

<body>
    <aside class="sidebar" id="sidebar">
        <a href="/admin" class="sidebar-brand">
            <i class="bi bi-shield-check-fill text-primary"></i>
            <span>Regime<span class="text-primary">Admin</span></span>
        </a>

        <div class="nav-menu">
            <div class="menu-label">Principal</div>

            <a href="/admin" class="nav-link-custom <?= current_url(true)->getSegment(2) == '' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2"></i>
                <span>Tableau de bord</span>
            </a>

            <a href="/admin/regime"
                class="nav-link-custom <?= current_url(true)->getSegment(2) == 'regime' ? 'active' : '' ?>">
                <i class="bi bi-egg-fried"></i>
                <span>Régimes</span>
            </a>

            <a href="/admin/activite"
                class="nav-link-custom <?= current_url(true)->getSegment(2) == 'activite' ? 'active' : '' ?>">
                <i class="bi bi-bicycle"></i>
                <span>Activités</span>
            </a>


            <a href="/admin/gold/pending"
                class="nav-link-custom <?= current_url(true)->getSegment(2) == 'gold' ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i>
                <span>Golden User</span>
            </a>
            <div class="menu-label mt-4">Finance</div>

            <a href="/admin/wallet-requests"
                class="nav-link-custom <?= current_url(true)->getSegment(2) == 'wallet-requests' ? 'active' : '' ?>">
                <i class="bi bi-wallet2"></i>
                <span>Demandes Wallet</span>
                <?php if (isset($pending_count) && $pending_count > 0): ?>
                    <span class="badge bg-danger ms-auto rounded-pill"><?= $pending_count ?></span>
                <?php endif; ?>
            </a>

            <a href=" /admin/code"
                class="nav-link-custom <?= current_url(true)->getSegment(2) == 'code' ? 'active' : '' ?>">
                <i class="bi bi-credit-card-2-front"></i>
                <span>Gestion Code</span>
                <?php if (isset($pending_count) && $pending_count > 0): ?>
                    <span class="badge bg-danger ms-auto rounded-pill"><?= $pending_count ?></span>
                <?php endif; ?>
            </a>
            <div class="menu-label mt-4">Système</div>

            <a href="/logout" class="nav-link-custom text-danger">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </aside>

    <div class="main-wrapper">
        <!-- Header -->
        <?= $this->include('Inc/partials/header_admin') ?>

        <!-- Contenu -->
        <main class="container mt-4">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

</body>
<script src="/asset/bootstrap/js/bootstrap.min.js"></script>
<script src="/asset/bootstrap/js/bootstrap.bundle.min.js"></script>

</html>