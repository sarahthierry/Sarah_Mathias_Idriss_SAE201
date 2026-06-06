<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pdo = db();

if (!isset($_SESSION["id_etudiant"])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION["id_etudiant"];

/* =========================
   ENTREPRISES CONTACTÉES
========================= */
$stmt = $pdo->prepare("
    SELECT COUNT(DISTINCT o.id_entreprise)
    FROM postuler p
    JOIN offre_stage o ON o.id_offre = p.id_offre
    WHERE p.id_etudiant = ?
");
$stmt->execute([$id]);
$nbEntreprises = (int)$stmt->fetchColumn();

/* =========================
   OFFRES CONSULTÉES
   (basé sur les candidatures = ton système actuel)
========================= */
$stmt = $pdo->prepare("
    SELECT COUNT(DISTINCT id_offre)
    FROM postuler
    WHERE id_etudiant = ?
");
$stmt->execute([$id]);
$nbOffresConsultees = (int)$stmt->fetchColumn();

/* =========================
   CANDIDATURES ENVOYÉES
========================= */
$stmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM postuler
    WHERE id_etudiant = ?
");
$stmt->execute([$id]);
$nbCandidatures = (int)$stmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StageConnect - Suivi</title>
    <link rel="icon" type="image/png" href="logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS SAE 201 203.css">
</head>

<body>

<!-- NAVBAR -->
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

<!-- PAGE -->
<section class="hero-section">
    <div class="container">

        <div class="mb-4">
            <span class="badge bg-primary px-3 py-2 mb-3">Suivi de votre recherche</span>
            <h1 class="hero-title">Suivi & progression</h1>
            <p class="hero-text">Résumé réel de vos démarches de stage.</p>
        </div>

        <!-- STATS -->
        <div class="row g-4 mb-5">

            <div class="col-md-4">
                <div class="stats-box">
                    <div class="stats-number"><?= $nbEntreprises ?></div>
                    <p>Entreprises contactées</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stats-box">
                    <div class="stats-number"><?= $nbOffresConsultees ?></div>
                    <p>Offres consultées</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stats-box">
                    <div class="stats-number"><?= $nbCandidatures ?></div>
                    <p>Candidatures envoyées</p>
                </div>
            </div>

        </div>

        <!-- TABLE -->
        <div class="row">

            <div class="col-lg-8">
                <div class="form-card">

                    <h2 class="section-title mb-3">Historique réel</h2>
                    <p class="text-muted mb-4">
                        Données récupérées depuis la base de données.
                    </p>

                    <table class="table align-middle">
                        <tbody>
                            <tr>
                                <td>Entreprises contactées</td>
                                <td><?= $nbEntreprises ?></td>
                            </tr>
                            <tr>
                                <td>Offres consultées</td>
                                <td><?= $nbOffresConsultees ?></td>
                            </tr>
                            <tr>
                                <td>Candidatures envoyées</td>
                                <td><?= $nbCandidatures ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-card">

                    <h2 class="section-title mb-3">Actions</h2>

                    <div class="d-grid gap-2">
                        <a href="offre_de_stage.php" class="btn btn-outline-primary">
                            Consulter des offres
                        </a>
                        <a href="mes_candidatures.php" class="btn btn-primary">
                            Voir mes candidatures
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>

<!-- FOOTER -->
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