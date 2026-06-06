<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pdo = db();

// si pas connecté
if (!isset($_SESSION["id_etudiant"])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION["id_etudiant"];

// récupérer infos étudiant
$stmt = $pdo->prepare("SELECT nom, prenom FROM etudiant WHERE id_etudiant = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch();

$nomComplet = $etudiant ? $etudiant["prenom"] . " " . $etudiant["nom"] : "Étudiant";

// =======================
// STATS DASHBOARD
// =======================

// Candidatures
$stmt = $pdo->prepare("SELECT COUNT(*) FROM postuler WHERE id_etudiant = ?");
$stmt->execute([$id]);
$nbCandidatures = (int) $stmt->fetchColumn();

// Offres consultées (pas encore de table → placeholder)
$stmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM consulter_offre
    WHERE id_etudiant = ?
");
$stmt->execute([$id]);
$nbOffresConsultees = $stmt->fetchColumn();

// STATUT SUIVI
$anneeActuelle = (int) date('Y');

$stmt = $pdo->prepare("
    SELECT annee_de_suivi
    FROM suivre
    WHERE id_etudiant = ?
    ORDER BY annee_de_suivi DESC
    LIMIT 1
");

$stmt->execute([$id]);
$suivi = $stmt->fetchColumn();

if (!$suivi) {
    $statutSuivi = "Non suivi";
} else {
    if ((int)$suivi == $anneeActuelle) {
        $statutSuivi = "En cours";
    } elseif ((int)$suivi < $anneeActuelle) {
        $statutSuivi = "Ancien";
    } else {
        $statutSuivi = "Planifié";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StageConnect - Espace Étudiant</title>
  <link rel="icon" type="image/png" href="logo.png">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="CSS SAE 201 203.css">

  <style>
    .dashboard-card {
      background: white;
      border-radius: 20px;
      padding: 26px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, .04);
      height: 100%;
    }

    .dashboard-title {
      color: #7e6f6c;
      font-weight: 800;
      font-size: 1.2rem;
    }

    .quick-link {
      text-decoration: none;
    }

    .quick-link:hover {
      opacity: .95;
    }
  </style>
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
        <a href="soutenances_stage.php" class="nav-link">Soutenance</a>
      </div>
    </div>
  </nav>

  <section class="hero-section" id="page-etudiant-dashboard">
    <div class="container">

      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
          <span class="badge bg-primary px-3 py-2 mb-3">Espace Étudiant</span>

          <!-- NOM + PRENOM -->
          <h1 class="hero-title mb-2">
            Bonjour 👋 <?= htmlspecialchars($nomComplet) ?>
          </h1>

          <p class="hero-text mb-0">
            Ton tableau de bord pour postuler, suivre, recevoir des conseils et gérer les étapes du stage.
          </p>
        </div>
      </div>

      <!-- STATS RAPIDES -->
      <div class="row g-4 mb-5">

        <div class="col-md-4">
          <div class="stats-box">
            <div class="stats-number"><?= $nbCandidatures ?></div>
            <p>Candidatures</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="stats-box">
            <div class="stats-number",id="stat-offres-consultees"><?= $nbOffresConsultees ?></div>
            <p>Offres consultées</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="stats-box">
            <div class="stats-number"><?= htmlspecialchars($statutSuivi) ?></div>
            <p>Suivi</p>
          </div>
        </div>

      </div>

      <!-- CARTES -->
      <div class="row g-4">

        <div class="col-lg-4">
          <div class="dashboard-card">
            <div class="dashboard-title mb-2">1) Trouver une offre</div>
            <p class="text-muted mb-4">Consulte les offres et postule en quelques clics.</p>
            <a href="offre_de_stage.php" class="btn btn-primary w-100">Voir les offres</a>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="dashboard-card">
            <div class="dashboard-title mb-2">2) Gérer tes candidatures</div>
            <p class="text-muted mb-4">Suivi des statuts et accès aux détails.</p>
            <a href="mes_candidatures.php" class="btn btn-outline-primary w-100">Mes candidatures</a>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="dashboard-card">
            <div class="dashboard-title mb-2">3) Prochaines étapes</div>
            <p class="text-muted mb-4">Conseils, soutenances, et progression globale.</p>
            <div class="d-grid gap-2">
              <a href="conseil_et_demande.php" class="btn btn-outline-primary">Conseils</a>
              <a href="soutenances_stage.php" class="btn btn-outline-primary">Soutenances</a>
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

        <div class="col-md-4">
          <h5>Navigation</h5>
          <a href="index.php" class="footer-link">Accueil</a>
          <a href="offre_de_stage.php" class="footer-link">Offres</a>
          <a href="mes_candidatures.php" class="footer-link">Mes candidatures</a>
          <a href="suivi_stage.php" class="footer-link">Suivi</a>
        </div>

        <div class="col-md-4">
          <h5>Informations</h5>
          <a href="#" class="footer-link">Mentions légales</a>
          <a href="#" class="footer-link">Politique de confidentialité</a>
          <a href="#" class="footer-link">Contact</a>
        </div>

      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>