<?php
require_once __DIR__ . '/../includes/db.php';

$pdo = db();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $phone = $_POST["phone"];
    $promotion = $_POST["promotion"];

    $check = $pdo->prepare("SELECT id_etudiant FROM etudiant WHERE adresse_email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        echo "<script>alert('Email déjà utilisé');window.location.href='../index.php';</script>";
        exit;
    }

    $matricule = "ETU" . date("Y") . rand(1000, 9999);

    $stmt = $pdo->prepare("
        INSERT INTO etudiant
        (matricule, nom, prenom, telephone, adresse_email, mot_de_passe, promotion)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $matricule,
        $nom,
        $prenom,
        $phone,
        $email,
        $password,
        $promotion
    ]);

    echo "<script>
        alert('Inscription réussie');
        window.location.href = '../etudiant_espace.php';
    </script>";
}