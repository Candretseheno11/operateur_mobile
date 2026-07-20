<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Suggestion achetee</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 18px; margin-bottom: 10px; }
        h2 { font-size: 14px; margin: 16px 0 6px; }
        .section { margin-bottom: 12px; }
        .muted { color: #666; font-size: 11px; }
        .row { margin-bottom: 6px; }
        .price { font-weight: bold; }
    </style>
</head>

<body>
    <h1>Suggestion achetee</h1>
    <div class="muted">Date d'achat: <?= $purchase['achat_date'] ?></div>

    <div class="section">
        <h2>Regime alimentaire</h2>
        <div class="row"><strong><?= $purchase['regime_nom'] ?></strong></div>
        <div class="row"><?= $purchase['regime_description'] ?></div>
        <div class="row">Duree: <?= $purchase['regime_duree'] ?> jours</div>
        <div class="row price">Prix: <?= number_format($purchase['prix_total'], 0, '.', ' ') ?> Ar</div>
    </div>

    <div class="section">
        <h2>Activite sportive</h2>
        <div class="row"><strong><?= $purchase['activite_nom'] ?></strong></div>
        <div class="row"><?= $purchase['activite_description'] ?></div>
        <div class="row">Duree: <?= $purchase['activite_duree'] ?> min</div>
        <div class="row">Calories: <?= $purchase['activite_calories'] ?> kcal</div>
    </div>
</body>

</html>
