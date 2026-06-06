<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$pdo = db(); // <<< OBLIGATOIRE sinon $pdo = NULL

$id_etudiant = $_SESSION['id_etudiant'] ?? 0;

// TRACK VUE OFFRE (si ouverture modal demandée)
if (isset($_GET['view'])) {

    if (isset($_SESSION['id_etudiant'])) {

        $id_offre = (int) $_GET['view'];
        $id_etudiant = $_SESSION['id_etudiant'];

        $check = $pdo->prepare("
            SELECT 1 FROM consulter_offre
            WHERE id_etudiant = ? AND id_offre = ?
        ");
        $check->execute([$id_etudiant, $id_offre]);

        if (!$check->fetch()) {
            $ins = $pdo->prepare("
                INSERT INTO consulter_offre (id_etudiant, id_offre)
                VALUES (?, ?)
            ");
            $ins->execute([$id_etudiant, $id_offre]);
        }
    }
}

/* ==========================
   POSTULER
========================== */

if(isset($_POST['postuler']))
{
    if(!isset($_SESSION['id_etudiant']))
    {
        echo "
        <script>
            alert('Vous ne pouvez pas postuler, vous n\\'êtes pas connecté !');
        </script>";
    }
    else
    {
        $id_offre = $_POST['id_offre'];

        $verif = $pdo->prepare("
            SELECT *
            FROM postuler
            WHERE id_etudiant = ?
            AND id_offre = ?
        ");

        $verif->execute([
            $_SESSION['id_etudiant'],
            $id_offre
        ]);

        if($verif->rowCount() > 0)
        {
            echo "
            <script>
                alert('Vous avez déjà postulé à cette offre.');
            </script>";
        }
        else
        {
            $requete = $pdo->prepare("
                INSERT INTO postuler
                (id_etudiant,id_offre,date_postulation)
                VALUES (?,?,NOW())
            ");

            $requete->execute([
                $_SESSION['id_etudiant'],
                $id_offre
            ]);

            echo "
            <script>
                alert('Vous avez bien postulé à l\\'offre !');
            </script>";
        }
    }
}

/* ==========================
   FILTRES
========================== */

$metier = $_GET['metier'] ?? '';
$ville = $_GET['ville'] ?? '';
$promotion = $_GET['promotion'] ?? '';

$sql = "SELECT * FROM offre_stage WHERE 1=1";

$params = [];

if(!empty($metier))
{
    $sql .= " AND intitule LIKE ?";
    $params[] = "%".$metier."%";
}

if(!empty($ville))
{
    $sql .= " AND lieu LIKE ?";
    $params[] = "%".$ville."%";
}

if(!empty($promotion))
{
    $sql .= " AND promotion LIKE ?";
    $params[] = "%".$promotion."%";
}

$stmt = db()->prepare($sql);
$stmt->execute($params);

$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>StageConnect - Offres de stage</title>
    <link rel="icon" type="image/png" href="logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="CSS SAE 201 203.css">

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg py-3">

    <div class="container">

        <a class="navbar-brand" href="index.php">
            StageConnect
        </a>

        <div class="ms-auto d-flex align-items-center gap-3">

            <a href="etudiant_espace.php" class="nav-link">
                Accueil
            </a>

            <a href="offre_de_stage.php" class="nav-link">
                Offres
            </a>

            <a href="mes_candidatures.php" class="nav-link">
                Mes candidatures
            </a>

            <a href="suivi_stage.php" class="nav-link">
                Suivi
            </a>

            <a href="conseil_et_demande.php" class="nav-link">
                Conseils
            </a>

            <a href="soutenances_stage.php" class="nav-link">
                Soutenances
            </a>

        </div>

    </div>

</nav>

<!-- PAGE -->

<section class="hero-section">

<div class="container">

<div class="mb-4">

    <span class="badge bg-primary px-3 py-2 mb-3">
        Offres de stage
    </span>

    <h1 class="hero-title">
        Trouvez et postulez
    </h1>

    <p class="hero-text">
        Consultez les offres disponibles et envoyez votre candidature.
    </p>

</div>

<!-- RECHERCHE -->

<div class="search-box mb-5">

<form method="GET">

<div class="row g-3">

<div class="col-md-4">

<label class="form-label">
    Métier
</label>

<input
type="text"
class="form-control form-control-lg"
name="metier"
value="<?= htmlspecialchars($metier) ?>"
placeholder="Ex : Développeur">

</div>

<div class="col-md-4">

<label class="form-label">
    Ville
</label>

<input
type="text"
class="form-control form-control-lg"
name="ville"
value="<?= htmlspecialchars($ville) ?>"
placeholder="Ex : Paris">

</div>

<div class="col-md-4">

<label class="form-label">
    Promotion
</label>

<input
type="text"
class="form-control form-control-lg"
name="promotion"
value="<?= htmlspecialchars($promotion) ?>"
placeholder="Ex : BUT3">

</div>

<div class="col-md-3">

<button
type="submit"
class="btn btn-primary w-100 btn-lg mt-4">

Rechercher

</button>

</div>

<div class="col-md-3">

<a
href="offre_de_stage.php"
class="btn btn-outline-primary w-100 btn-lg mt-4">

Réinitialiser

</a>

</div>

</div>

</form>

</div>

<!-- OFFRES -->

<h2 class="section-title mb-4">
    Dernières offres
</h2>

<div class="row g-4">

<?php foreach($offres as $offre): ?>

<div class="col-md-4">

<div class="offer-card h-100">

<h4>
    <?= htmlspecialchars($offre['intitule']) ?>
</h4>

<p class="offer-location">

    <?= htmlspecialchars($offre['lieu']) ?>

    •

    <?= htmlspecialchars($offre['duree']) ?>

</p>

<p class="mb-3">

<?= nl2br(htmlspecialchars($offre['description'])) ?>

</p>

<div class="d-flex flex-column gap-2">

<a href="?view=<?= $offre['id_offre'] ?>#offre<?= $offre['id_offre'] ?>"
   class="btn btn-outline-primary"
   data-bs-toggle="modal"
   data-bs-target="#offre<?= $offre['id_offre'] ?>">
   Voir l'offre
</a>

<form method="POST">

<input
type="hidden"
name="id_offre"
value="<?= $offre['id_offre'] ?>">

<button
type="submit"
name="postuler"
class="btn btn-primary w-100">

Postuler

</button>

</form>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

</section>

<!-- MODALS -->

<?php foreach($offres as $offre): ?>

<div
class="modal fade"
id="offre<?= $offre['id_offre'] ?>"
tabindex="-1">

<div class="modal-dialog modal-lg modal-dialog-centered">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">

<?= htmlspecialchars($offre['intitule']) ?>

</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<p>
<strong>Ville :</strong>
<?= htmlspecialchars($offre['lieu']) ?>
</p>

<p>
<strong>Durée :</strong>
<?= htmlspecialchars($offre['duree']) ?>
</p>

<p>
<strong>Promotion :</strong>
<?= htmlspecialchars($offre['promotion']) ?>
</p>

<p>
<strong>Description :</strong><br>

<?= nl2br(htmlspecialchars($offre['description'])) ?>

</p>

</div>

<div class="modal-footer">

<form method="POST">

<input
type="hidden"
name="id_offre"
value="<?= $offre['id_offre'] ?>">

<button
type="submit"
name="postuler"
class="btn btn-primary">

Postuler

</button>

</form>

</div>

</div>

</div>

</div>

<?php endforeach; ?>

<!-- FOOTER -->

<footer>

<div class="container">

<div class="row">

<div class="col-md-4">

<h4>StageConnect</h4>

<p>
Plateforme de gestion des stages
pour étudiants et entreprises.
</p>

</div>

</div>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>