<?= $this->extend('Inc/layout/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid p-0">

    <!-- Messages Flash de Notification -->
    <?php if (session('success')): ?>
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div><?= session('success') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Tableau de bord</h4>
            <p class="text-muted small mb-0">Bienvenue dans votre espace d'administration.</p>
        </div>
    </div>

    <!-- SECTION 1 : STATISTIQUES GÉNÉRALES -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="adm-stat-card adm-border-primary">
                <i class="bi bi-people adm-stat-icon-bg icon-users"></i>
                <div class="adm-stat-label">Utilisateurs</div>
                <div class="adm-stat-value"><?= $stats['totalUsers'] ?? 0 ?></div>
                <div class="mt-2 small">
                    <span class="text-primary fw-bold"><?= $stats['totalUtilisateurs'] ?? 0 ?></span> clients
                    inscrits
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="adm-stat-card adm-border-info">
                <i class="bi bi-journal-check adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Régimes Actifs</div>
                <div class="adm-stat-value"><?= $stats['totalRegimes'] ?? 0 ?></div>
                <div class="mt-2 small text-muted">
                    Moyenne : <span class="fw-bold"><?= number_format(($stats['avgRegimePrix'] ?? 0), 0, ',', ' ') ?>
                        Ar</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="adm-stat-card adm-border-success">
                <i class="bi bi-lightning-charge adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Objectif Calories</div>
                <div class="adm-stat-value"><?= $stats['caloriesAverage'] ?? 0 ?> <small class="fs-6">kcal</small></div>
                <div class="mt-2 small text-muted">Moyenne par séance</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="adm-stat-card adm-border-warning">
                <i class="bi bi-activity adm-stat-icon-bg"></i>
                <div class="adm-stat-label">Activités</div>
                <div class="adm-stat-value"><?= $stats['totalActivites'] ?? 0 ?></div>
                <div class="mt-2 small text-muted">Types d'exercices dispo.</div>
            </div>
        </div>
    </div>

    <!-- SECTION 2 : GRAPHIQUE ET FINANCES -->
    <div class="row g-4">

        <!-- Graphique d'évolution -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold m-0"><i class="bi bi-graph-up me-2 text-primary"></i>Activité
                            Hebdomadaire
                        </h6>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="height: 300px; position: relative;">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques des Transactions (Wallet) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h6 class="fw-bold m-0"><i class="bi bi-wallet2 me-2 text-primary"></i>Flux Wallet</h6>
                </div>
                <div class="card-body p-4">
                    <div
                        class="mb-4 text-center p-4 bg-primary bg-opacity-10 rounded-4 border border-primary border-opacity-10">
                        <div class="text-primary small fw-bold text-uppercase mb-1">Montant Total Validé</div>
                        <div class="h2 fw-black text-primary mb-0">
                            <?= number_format(($stats['totalTransactionsMontant'] ?? 0), 0, ',', ' ') ?>
                            <span class="fs-5">Ar</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between p-3 border rounded-3 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px;">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <div class="fw-bold small">Validées</div>
                            </div>
                            <div class="fw-bold text-success"><?= $stats['totalApproved'] ?? 0 ?></div>
                        </div>

                        <div
                            class="d-flex align-items-center justify-content-between p-3 border rounded-3 mb-2 bg-light">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px;">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <div class="fw-bold small">En attente</div>
                            </div>
                            <div class="fw-bold text-warning"><?= $stats['totalPending'] ?? 0 ?></div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-3 border rounded-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px;">
                                    <i class="bi bi-x-lg"></i>
                                </div>
                                <div class="fw-bold small">Rejetées</div>
                            </div>
                            <div class="fw-bold text-danger"><?= $stats['totalRejected'] ?? 0 ?></div>
                        </div>
                    </div>

                    <a href="/admin/wallet-requests" class="btn btn-primary w-100 py-2 rounded-3 shadow-sm">
                        Gérer les demandes <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS : PASSAGE DES DONNÉES PHP À JS -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('performanceChart').getContext('2d');

        /**
         * ÉTAPE CRUCIALE : On récupère les données PHP et on les transforme en JSON
         * Note : Remplacez par vos vraies variables issues du contrôleur
         */
        const chartLabels = <?= json_encode(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']) ?>;

        // Exemple : On imagine que le contrôleur envoie $stats['chartData']
        const chartDataValues = <?= json_encode($stats['chartData'] ?? [12, 19, 15, 25, 22, 30, 28]) ?>;

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Activités complétées',
                    data: chartDataValues,
                    borderColor: '#2563eb',
                    borderWidth: 3,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#2563eb',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>