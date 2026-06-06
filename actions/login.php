<?php
session_start();
require_once __DIR__ . "/../includes/db.php";

$pdo = db();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

/* =========================
   1. ETUDIANT
========================= */
$stmt = $pdo->prepare("
    SELECT *
    FROM etudiant
    WHERE adresse_email = ?
    LIMIT 1
");
$stmt->execute([$email]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if ($etudiant && password_verify($password, $etudiant['mot_de_passe'])) {

    $_SESSION['id_etudiant'] = $etudiant['id_etudiant'];
    $_SESSION['role'] = 'etudiant';
    $_SESSION['nom'] = $etudiant['nom'];

    header("Location: ../etudiant_espace.php");
    exit; 
}

/* =========================
   2. PROFESSEUR
========================= */
$stmt = $pdo->prepare("
    SELECT id_professeurs, nom, email, mot_de_passe
    FROM professeurs
    WHERE email = ? AND role = 'professeur'
    LIMIT 1
");
$stmt->execute([$email]);
$prof = $stmt->fetch(PDO::FETCH_ASSOC);

if ($prof && ($password === $prof['mot_de_passe'] || password_verify($password, $prof['mot_de_passe']))) {

    $_SESSION['id_professeur'] = $prof['id_professeurs'];
    $_SESSION['role'] = 'professeur';
    $_SESSION['nom'] = $prof['nom'];

    header("Location: ../professeur_espace.php");
    exit;
}

/* =========================
   ECHEC UNIQUE
========================= */
echo "<script>
alert('Email ou mot de passe incorrect');
window.location.href='../index.php';
</script>";
exit;