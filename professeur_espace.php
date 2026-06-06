<?php
require_once __DIR__ . '/includes/db.php';
session_start();

if (!isset($_SESSION['prof_user'])) {
    header('Location: connexion_professeur.html');
    exit;
}

$conn = db();
$profId = $_SESSION['prof_user']['id_professeurs'];

$stmt = $conn->prepare("SELECT nom, prenom, email FROM professeurs WHERE id_professeurs = ?");
$stmt->execute([$profId]);
$prof = $stmt->fetch();

$countOffres = (int)$conn->query("SELECT COUNT(*) FROM offre_stage")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Espace Professeur</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="CSS SAE 201 203.css">
<link rel="icon" type="image/png" href="logo.png">
</head>
<body>
<nav class="navbar navbar-expand-lg py-3">
<div class="container">
<a class="navbar-brand" href="index.php">StageConnect</a>
<div class="ms-auto d-flex gap-3 align-items-center">
<span class="fw-bold">Bonjour <?= htmlspecialchars(($prof['prenom'] ?? '') . ' ' . ($prof['nom'] ?? '')) ?></span>
<a href="professeur_offres_stage.php" class="nav-link">Offres</a>
</div>
</div>
</nav>

<section class="hero-section">
<div class="container">
<div class="form-card">
<h1 class="hero-title">Bienvenue <?= htmlspecialchars($prof['prenom'] ?? 'Professeur') ?></h1>
<p class="hero-text">Email : <?= htmlspecialchars($prof['email'] ?? '') ?></p>

<div class="row mt-4">
<div class="col-md-4">
<div class="card p-4 text-center">
<h2><?= $countOffres ?></h2>
<p>Offres disponibles</p>
</div>
</div>
</div>

<div class="mt-4 d-flex gap-3">
<a href="professeur_offres_stage.php" class="btn btn-primary">Gérer les offres</a>
<a href="offre_de_stage.php" class="btn btn-outline-primary">Voir les offres étudiantes</a>
</div>
</div>
</div>
</section>
</body>
</html>