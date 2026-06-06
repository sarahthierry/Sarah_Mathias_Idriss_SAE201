<?php
// Page : offre_detail.php
// Affiche tous les détails d’une offre à partir de id_offre

require_once __DIR__ . '/includes/db.php';

$id_offre = isset($_GET['id_offre']) ? (int)$_GET['id_offre'] : 0;

$conn = db();

$sql = "
  SELECT 
    o.*, 
    e.nom AS nom_entreprise
  FROM offre_stage o
  LEFT JOIN entreprise e ON e.id_entreprise = o.id_entreprise
  WHERE o.id_offre = ?
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_offre]);
$offre = $stmt->fetch() ?: null;

function h(?string $v): string {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

function formatMoney($v): string {
    if ($v === null || $v === '') return '—';
    return number_format((float)$v, 2, ',', ' ') . ' €';
}

function formatDate($d): string {
    if (!$d) return '—';
    return h($d);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StageConnect - Détail offre</title>
  <link rel="icon" type="image/png" href="logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS SAE 201 203.css">

  <style>
    .hero-title {
      color: #7e6f6c;
      font-weight: 900;
    }

    .detail-card {
      background: white;
      border-radius: 20px;
      padding: 26px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, .04);
    }

    .section-subtitle {
      color: #7d7d7d;
    }

    .competences {
      white-space: pre-wrap;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg py-3">
    <div class="container">
      <a class="navbar-brand" href="index.php">StageConnect</a>
      <div class="ms-auto d-flex align-items-center gap-3">
        <a href="offre_de_stage.php" class="nav-link">← Retour aux offres</a>
      </div>
    </div>
  </nav>

  <section class="hero-section">
    <div class="container">
      <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
          <span class="badge bg-primary px-3 py-2 mb-3">Détail offre</span>
          <h1 class="hero-title mb-2"><?= h($offre ? $offre['intitule'] : 'Offre introuvable') ?></h1>
          <p class="hero-text mb-0">Données récupérées depuis <b>gestion_stages</b>.</p>
        </div>
      </div>

      <?php if (!$offre): ?>
        <div class="alert alert-warning">Offre introuvable (id_offre invalide).</div>
      <?php else: ?>
        <div class="detail-card">
          <div class="row g-4">
            <div class="col-lg-8">
              <h3 class="mb-3">Détail du stage</h3>
              <p class="text-muted mb-4"><?= h($offre['description'] ?? '') ?></p>

              <h4 class="section-subtitle mb-2">Compétences</h4>
              <div class="p-3 bg-light rounded-3 competences">
                <?= h($offre['competences'] ?? '') ?>
              </div>
            </div>

            <div class="col-lg-4">
              <h3 class="mb-3">Informations</h3>
              <ul class="list-group">
                <li class="list-group-item"><b>Nom entreprise :</b> <?= h($offre['nom_entreprise'] ?? '') ?></li>
                <li class="list-group-item"><b>Temps de réalisation :</b> <?= h($offre['duree'] ?? '') ?></li>
                <li class="list-group-item"><b>Niveau d’étude :</b> <?= h($offre['promotion'] ?? '') ?></li>
                <li class="list-group-item"><b>Lieu :</b> <?= h($offre['lieu'] ?? '') ?></li>
                <li class="list-group-item"><b>Période :</b> <?= formatDate($offre['date_debut'] ?? null) ?> → <?= formatDate($offre['date_fin'] ?? null) ?></li>
                <li class="list-group-item"><b>Rémunération :</b> <?= formatMoney($offre['remuneration'] ?? null) ?></li>
              </ul>
            </div>
          </div>

          <div class="alert alert-info mt-4 mb-0">
            Pour postuler : relier cette page à ton bouton/flux de postulation (table <b>postuler</b>).
          </div>
        </div>
      <?php endif; ?>
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

