<div class="content-wrapper">

    <nav class="navbar navbar-expand-lg navbar-custom py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/profile">Regime</a>
            <div class="ms-auto d-flex align-items-center">
                <a href="/wallet" class="wallet-display d-none d-md-flex" title="Voir mon historique de transactions">
                    <div class="wallet-icon">
                        <i class="bi bi-wallet"></i>
                    </div>
                    <span class="wallet-amount"><?= number_format($wallet['solde'], 0, ',', ' ') ?> Ar</span>

                </a>
                <!-- Ici si c'est un Utilisateur gold donc on affiche Membre gold -->

                <?php if (session()->get('user')['is_gold']): ?>
                    <span class="badge badge-gold me-3 p-2 d-none d-sm-inline"><i class="bi bi-crown"></i> Membre
                        Gold</span>
                <?php endif; ?>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                        data-bs-toggle="dropdown">

                        <!-- Ici si c'est un homme donc ca afiiche un icone d'homme sinon du sexe inverse -->
                        <?php if (session()->get('user')['genre'] === 'homme') {
                            echo '<img src="/asset/images/avatar_homme.jpg" class="rounded-circle me-2" width="35">';
                        } else {
                            echo '<img src="/asset/images/avatar_femme.jpg" class="rounded-circle me-2" width="35">';
                        } ?>
                        <span class="fw-medium"> <?= session()->get('user')['nom'] ?> </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2">
                        <li><a class="dropdown-item" href="/wallet"><i class="bi bi-wallet me-2"></i>
                                Portefeuille</a> </li>
                        <li>
                            <hr class="dropdown-divider">
                            <a class="dropdown-item" href="/viewprofile"><i class="bi bi-person me-2"></i> Profile</a>
                        <li></li>
                        <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="/logout"><i
                                    class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="container">
        <?= $this->renderSection('content') ?>
    </main>