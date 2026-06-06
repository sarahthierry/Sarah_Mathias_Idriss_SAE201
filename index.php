<?php
session_start();

require_once __DIR__ . "/includes/db.php";

$pdo = db();

/* =========================
   STATS INDEX
========================= */

// Offres de stage
$stmt = $pdo->query("SELECT COUNT(*) FROM offre_stage");
$nbOffres = (int)$stmt->fetchColumn();

// Entreprises
$stmt = $pdo->query("SELECT COUNT(*) FROM entreprise");
$nbEntreprises = (int)$stmt->fetchColumn();

// Étudiants
$stmt = $pdo->query("SELECT COUNT(*) FROM etudiant");
$nbEtudiants = (int)$stmt->fetchColumn();


/* =========================
   DERNIÈRES OFFRES
========================= */

$stmt = $pdo->query("
    SELECT *
    FROM offre_stage
    WHERE date_debut >= CURDATE()
    ORDER BY date_debut ASC
    LIMIT 3
");

$dernieresOffres = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';

    $stmt = $pdo->prepare("
        SELECT *
        FROM etudiant
        WHERE adresse_email = ?
        LIMIT 1
    ");

    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "<script>
            alert('Utilisateur introuvable');
            window.location.href = '../index.php';
        </script>";
        exit;
    }

    if (!password_verify($password, $user["mot_de_passe"])) {
        echo "<script>
            alert('Mot de passe incorrect');
            window.location.href = '../index.php';
        </script>";
        exit;
    }

    // SESSION OK
    $_SESSION["id_etudiant"] = $user["id_etudiant"];
    $_SESSION["nom"] = $user["nom"];

    echo "<script>
        alert('Connexion réussie');
        window.location.href = '../etudiant_espace.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>StageConnect - Plateforme de stages</title>
    <link rel="icon" type="image/png" href="logo.png">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="CSS SAE 201 203.css">

</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg py-3">

        <div class="container">

            <a class="navbar-brand" href="#">
                StageConnect
            </a>

            <div class="ms-auto d-flex align-items-center gap-3">

                <a href="#" class="nav-link" id="nav-accueil">
                    Accueil
                </a>

                <a href="#" class="nav-link" id="nav-inscription">
                    Inscription
                </a>

                <a href="#" class="nav-link" id="nav-connexion">
                    Connexion
                </a>

                <a href="offre_de_stage.html" class="btn btn-primary px-4">
                    Offres de stage
                </a>


            </div>

        </div>

    </nav>

    <!-- PAGE ACCUEIL -->

    <section id="page-accueil" class="hero-section">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <span class="badge bg-primary px-3 py-2 mb-4">
                        Plateforme de gestion des stages
                    </span>

                    <h1 class="hero-title mb-4">
                        Trouvez le stage parfait pour votre avenir
                    </h1>

                    <p class="hero-text mb-5">
                        Consultez des centaines d’offres de stages,
                        postulez en ligne et suivez vos candidatures.
                    </p>

                    <div class="search-box">

                        <div class="row g-3">

                            <div class="col-md-5">
                                <input type="text"
                                    class="form-control form-control-lg"
                                    placeholder="Métier">
                            </div>

                            <div class="col-md-4">
                                <input type="text"
                                    class="form-control form-control-lg"
                                    placeholder="Ville">
                            </div>

                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary w-100 btn-lg">
                                    Rechercher
                                </button>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6 text-center mt-5 mt-lg-0">

                    <img src="photo.png"
                        alt="Image accueil"
                        class="img-fluid hero-image">

                </div>

            </div>

            <!-- STATS -->

            <div class="row mt-5 g-4">

                <div class="col-md-4">

                    <div class="stats-box">

                        <div class="stats-number">
                            <?= $nbOffres ?>
                        </div>

                        <p>
                            Offres de stages
                        </p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="stats-box">

                        <div class="stats-number">
                            <?= $nbEntreprises ?>
                        </div>

                        <p>
                            Entreprises partenaires
                        </p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="stats-box">

                        <div class="stats-number">
                            <?= $nbEtudiants ?>
                        </div>

                        <p>
                            Étudiants inscrits
                        </p>

                    </div>

                </div>

            </div>

            <!-- OFFRES -->

<div class="mt-5">

    <h2 class="section-title mb-4">
        Dernières offres de stage
    </h2>

    <div class="row g-4">

        <?php if (!empty($dernieresOffres)) : ?>

            <?php foreach ($dernieresOffres as $offre) : ?>

                <div class="col-md-4">

                    <div class="offer-card">

                        <h4>
                            <?= htmlspecialchars($offre["intitule"]) ?>
                        </h4>

                        <p class="offer-location">
                            <?= htmlspecialchars($offre["lieu"]) ?>
                            •
                            <?= htmlspecialchars($offre["duree"]) ?>
                        </p>

                        <p>
                            <?= htmlspecialchars(mb_strimwidth($offre["description"], 0, 100, "...")) ?>
                        </p>

                        <a href="offre_detail.php?id=<?= $offre["id_offre"] ?>"
                           class="btn btn-outline-primary">
                            Voir l'offre
                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else : ?>

            <div class="col-12">
                <p class="text-muted">Aucune offre disponible.</p>
            </div>

        <?php endif; ?>

    </div>

</div>

                

        </div>

    </section>

    <!-- PAGE INSCRIPTION -->

<section class="form-section d-none" id="page-inscription">

<div class="container">
<div class="row justify-content-center">

<div class="col-lg-7">

<div class="form-card">

<h2 class="text-center mb-4">Inscription Étudiant</h2>

<form action="actions/register.php" method="POST">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Promotion</label>
            <input type="text" name="promotion" class="form-control">
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 mt-3">
        S'inscrire
    </button>

</form>

</div>

</div>
</div>
</div>

</section>

    <!-- PAGE CONNEXION -->

<section class="form-section d-none" id="page-connexion">

<div class="container">
<div class="row justify-content-center">

<div class="col-lg-5">

<div class="form-card">

<h2 class="text-center mb-4">Connexion</h2>

<form action="actions/login.php" method="POST">

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100 mt-3">
        Se connecter
    </button>

    <div class="text-center mt-3">
        <a href="connexion_professeur.html" class="text-decoration-none">
            Connexion professeur
        </a>
    </div>

</form>

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

                    <h4>
                        StageConnect
                    </h4>

                    <p>
                        Plateforme de gestion des stages
                        pour étudiants et entreprises.
                    </p>

                </div>

                <div class="col-md-4">

                    <h5>
                        Navigation
                    </h5>

                    <a href="#" class="footer-link">
                        Accueil
                    </a>

                    <a href="#" class="footer-link">
                        Offres
                    </a>

                    <a href="#" class="footer-link">
                        Connexion
                    </a>

                </div>

                <div class="col-md-4">

                    <h5>
                        Informations
                    </h5>

                    <a href="#" class="footer-link">
                        Mentions légales
                    </a>

                    <a href="#" class="footer-link">
                        Politique de confidentialité
                    </a>

                    <a href="#" class="footer-link">
                        Contact
                    </a>

                </div>

            </div>

        </div>

    </footer>

    <!-- SCRIPT -->

    <script>

        (function () {

            const accueil = document.getElementById('page-accueil');
            const inscription = document.getElementById('page-inscription');
            const connexion = document.getElementById('page-connexion');

            function show(page) {

                accueil.classList.add('d-none');
                inscription.classList.add('d-none');
                connexion.classList.add('d-none');

                if (page === 'accueil') {
                    accueil.classList.remove('d-none');
                }

                if (page === 'inscription') {
                    inscription.classList.remove('d-none');
                }

                if (page === 'connexion') {
                    connexion.classList.remove('d-none');
                }

            }

            document.getElementById('nav-accueil')
                .addEventListener('click', function (e) {

                    e.preventDefault();
                    show('accueil');

                });

            document.getElementById('nav-inscription')
                .addEventListener('click', function (e) {

                    e.preventDefault();
                    show('inscription');

                });

            document.getElementById('nav-connexion')
                .addEventListener('click', function (e) {

                    e.preventDefault();
                    show('connexion');

                });

        })();

    </script>

    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

