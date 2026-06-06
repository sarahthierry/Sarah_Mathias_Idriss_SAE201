<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pdo = db();

/* =========================
   SECURITÉ : connexion
========================= */
if (!isset($_SESSION['id_etudiant'])) {
    header("Location: index.php");
    exit;
}

$id_etudiant = $_SESSION['id_etudiant'];

/* =========================
   RÉCUPÉRATION CANDIDATURES
========================= */

$stmt = $pdo->prepare("
    SELECT 
        p.date_postulation,
        o.id_offre,
        o.intitule,
        o.lieu,
        o.description,
        o.id_entreprise,
        e.nom AS entreprise_nom
    FROM postuler p
    JOIN offre_stage o ON o.id_offre = p.id_offre
    LEFT JOIN entreprise e ON e.id_entreprise = o.id_entreprise
    WHERE p.id_etudiant = ?
    ORDER BY p.date_postulation DESC
");

$stmt->execute([$id_etudiant]);
$candidatures = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StageConnect - Mes candidatures</title>
    <link rel="icon" type="image/png" href="logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS SAE 201 203.css">

    <style>
        .actions-col { width: 220px; }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg py-3">
    <div class="container">
        <a class="navbar-brand" href="index.php">StageConnect</a>

        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="etudiant_espace.php" class="nav-link">Accueil</a>
            <a href="offre_de_stage.php" class="nav-link">Offres</a>
            <a href="mes_candidatures.php" class="nav-link">Mes candidatures</a>
            <a href="suivi_stage.php" class="nav-link">Suivi</a>
            <a href="conseil_et_demande.php" class="nav-link">Conseils</a>
            <a href="soutenances_stage.php" class="nav-link">Soutenances</a>
        </div>
    </div>
</nav>

<section class="hero-section">

<div class="container">

<div class="mb-4">
    <span class="badge bg-primary px-3 py-2 mb-3">Mes candidatures</span>
    <h1 class="hero-title">Suivi de vos candidatures</h1>
    <p class="hero-text">Liste réelle depuis la base de données</p>
</div>

<div class="form-card">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title mb-0">Candidatures</h2>
    <a href="offre_de_stage.php" class="btn btn-outline-primary">Ajouter une candidature</a>
</div>

<div class="table-responsive">

<table class="table align-middle">

<thead>
<tr>
    <th>Entreprise</th>
    <th>Offre</th>
    <th>Date</th>
    <th>Statut</th>
    <th class="actions-col">Actions</th>
</tr>
</thead>

<tbody>

<?php if (empty($candidatures)) : ?>

<tr>
    <td colspan="5" class="text-center text-muted">
        Aucune candidature pour le moment
    </td>
</tr>

<?php else : ?>

<?php foreach ($candidatures as $c) : ?>

<tr>
    <td><?= htmlspecialchars($c['entreprise_nom'] ?? 'Entreprise') ?></td>

    <td><?= htmlspecialchars($c['intitule']) ?></td>

    <td><?= htmlspecialchars($c['date_postulation']) ?></td>

    <td>
        <span class="badge bg-secondary">En attente</span>
    </td>

    <td>
        <div class="d-flex gap-2">

            <a href="offre_de_stage.php?id=<?= $c['id_offre'] ?>" 
               class="btn btn-outline-primary btn-sm">
                Voir l’offre
            </a>

            <button class="btn btn-primary btn-sm" type="button">
                Détails
            </button>

        </div>
    </td>
</tr>

<?php endforeach; ?>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

</section>

<footer>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h4>StageConnect</h4>
            <p>Plateforme de gestion des stages pour étudiants et entreprises.</p>
        </div>
    </div>
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>