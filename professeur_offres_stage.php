<?php
require_once __DIR__ . '/includes/db.php';
session_start();

if (!isset($_SESSION['prof_user'])) {
    header('Location: connexion_professeur.html');
    exit;
}

$conn = db();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO offre_stage (intitule, description, competences, duree, lieu, date_debut, date_fin, remuneration, promotion, id_entreprise)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['intitule'],
        $_POST['description'],
        $_POST['competences'],
        $_POST['duree'],
        $_POST['lieu'],
        $_POST['date_debut'],
        $_POST['date_fin'],
        $_POST['remuneration'],
        $_POST['promotion'],
        $_POST['id_entreprise']
    ]);
    $message = "Offre ajoutée avec succès.";
}

$entreprises = $conn->query("SELECT id_entreprise, nom FROM entreprise ORDER BY nom")->fetchAll();

$offres = $conn->query("SELECT o.*, e.nom AS entreprise
FROM offre_stage o
LEFT JOIN entreprise e ON e.id_entreprise = o.id_entreprise
ORDER BY o.id_offre DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion Offres</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="CSS SAE 201 203.css">
<link rel="icon" type="image/png" href="logo.png">
</head>
<body>
<div class="container py-5">
<h1 class="mb-4">Ajouter une offre de stage</h1>

<?php if ($message): ?>
<div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" class="row g-3 mb-5">
<div class="col-md-6">
<input type="text" name="intitule" class="form-control" placeholder="Intitulé" required>
</div>
<div class="col-md-6">
<input type="text" name="competences" class="form-control" placeholder="Compétences" required>
</div>
<div class="col-12">
<textarea name="description" class="form-control" placeholder="Description" required></textarea>
</div>
<div class="col-md-4">
<input type="text" name="duree" class="form-control" placeholder="Durée">
</div>
<div class="col-md-4">
<input type="text" name="lieu" class="form-control" placeholder="Lieu">
</div>
<div class="col-md-4">
<input type="text" name="promotion" class="form-control" placeholder="Promotion">
</div>
<div class="col-md-4">
<input type="date" name="date_debut" class="form-control">
</div>
<div class="col-md-4">
<input type="date" name="date_fin" class="form-control">
</div>
<div class="col-md-4">
<input type="text" name="remuneration" class="form-control" placeholder="Rémunération">
</div>
<div class="col-md-12">
<select name="id_entreprise" class="form-select" required>
<option value="">Choisir une entreprise</option>
<?php foreach($entreprises as $entreprise): ?>
<option value="<?= $entreprise['id_entreprise'] ?>"><?= htmlspecialchars($entreprise['nom']) ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="col-12">
<button type="submit" class="btn btn-primary">Ajouter l'offre</button>
</div>
</form>

<h2>Offres publiées</h2>
<table class="table table-bordered">
<tr><th>Intitulé</th><th>Entreprise</th><th>Lieu</th></tr>
<?php foreach($offres as $offre): ?>
<tr>
<td><?= htmlspecialchars($offre['intitule']) ?></td>
<td><?= htmlspecialchars($offre['entreprise']) ?></td>
<td><?= htmlspecialchars($offre['lieu']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="offre_de_stage.php" class="btn btn-outline-primary mt-3">Voir côté étudiant</a>
</div>
</body>
</html>