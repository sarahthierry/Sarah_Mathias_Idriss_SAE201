<?php
$HOSTNAME = "localhost";
$DBNAME = "gestion_stage";
$USER = "root";
$PASSWD = "";

try {
    $connexion = new PDO("mysql:host=$HOSTNAME;dbname=$DBNAME;charset=utf8", $USER, $PASSWD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $action = $_POST['action'] ?? 'user';

    if ($action === 'user') {
        $id = (int)($_POST['id'] ?? 0);
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $grade = $_POST['grade'] ?? 'etudiant';

        if (empty($nom) || empty($prenom) || empty($email) || empty($password) || strlen($password) < 6) {
            throw new Exception("Tous les champs requis, mot de passe min 6 caractères");
        }

        // Check if email exists
        $check = $connexion->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = :email");
        $check->execute(['email' => $email]);
        if ($check->fetchColumn() > 0) {
            throw new Exception("Email déjà utilisé");
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateurs (id, nom, prenom, email, mot_de_passe, grade) VALUES (:id, :nom, :prenom, :email, :mot_de_passe, :grade)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'mot_de_passe' => $hashed_password,
            'grade' => $grade
        ]);

        $success = true;
        $message = "✅ Utilisateur enregistré avec succès (Grade: $grade) ! ID: " . $connexion->lastInsertId();


    } elseif ($action === 'stage') {
        $utilisateur_id = (int)($_POST['id_utilisateur'] ?? 0);
        $entreprise_id = (int)($_POST['id_entreprise'] ?? 0);
        $titre = $_POST['titre'] ?? '';
        $date_debut = $_POST['date_debut'] ?? null;
        $duree_mois = (int)($_POST['duree_mois'] ?? 0);
        $description = $_POST['description'] ?? '';

        if ($utilisateur_id <= 0 || $entreprise_id <= 0 || empty($titre)) {
            throw new Exception("Données invalides");
        }

        $sql = "INSERT INTO stages (id_utilisateur, id_entreprise, titre, date_debut, duree_mois, description) 
                VALUES (:id_utilisateur, :id_entreprise, :titre, :date_debut, :duree_mois, :description)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([
            'id_utilisateur' => $utilisateur_id,
            'id_entreprise' => $entreprise_id,
            'titre' => $titre,
            'date_debut' => $date_debut,
            'duree_mois' => $duree_mois,
            'description' => $description
        ]);

        $success = true;
        $message = "✅ Stage enregistré avec succès pour utilisateur ID $utilisateur_id !";
    } else {
        throw new Exception("Action inconnue");
    }
} catch (Exception $e) {
    $success = false;
    $message = "❌ Erreur: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Traitement - Résultat</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .success { color: green; }
        .error { color: red; }
        a { background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        a:hover { background: #005a87; }
    </style>
</head>
<body>
    <h1><?php echo $success ? 'Succès' : 'Erreur'; ?></h1>
    <p><?php echo htmlspecialchars($message); ?></p>
    <a href="Inscription utilisateur.html">🔄 Nouvelle inscription</a> | 
    <a href="liste stage.php">📋 Voir les stages</a>
    <a href="liste utilisateur.php">📋 Voir les utilisateurs</a>
</body>
</html>
