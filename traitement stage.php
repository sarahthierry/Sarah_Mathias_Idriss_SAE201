<?php
$HOSTNAME = "localhost";
$DBNAME = "gestion_stage";
$USER = "root";
$PASSWD = "";

try {
    $connexion = new PDO("mysql:host=$HOSTNAME;dbname=$DBNAME;charset=utf8", $USER, $PASSWD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $utilisateur_id = (int)($_POST['utilisateur_id'] ?? 0);
    $entreprise_id = (int)($_POST['entreprise_id'] ?? 0);
    $sujet = trim($_POST['sujet'] ?? '');
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';

    if ($utilisateur_id <= 0 || $entreprise_id <= 0 || empty($sujet) || empty($date_debut) || empty($date_fin)) {
        throw new Exception("Tous les champs sont obligatoires et IDs > 0");
    }

    $check = $connexion->prepare("SELECT COUNT(*) FROM utilisateurs WHERE id = :id");
    $check->execute(['id' => $utilisateur_id]);
    if ($check->fetchColumn() == 0) {
        throw new Exception("❌ ID Utilisateur $utilisateur_id n'existe pas ! Créez d'abord l'utilisateur.");
    }

    $check = $connexion->prepare("SELECT COUNT(*) FROM entreprises WHERE id = :id");
    $check->execute(['id' => $entreprise_id]);
    if ($check->fetchColumn() == 0) {
        throw new Exception("❌ ID Entreprise $entreprise_id n'existe pas ! Créez d'abord l'entreprise.");
    }

    $sql = "INSERT INTO stages (id_utilisateur, id_entreprise, sujet, date_debut, date_fin) VALUES (:id_utilisateur, :id_entreprise, :sujet, :date_debut, :date_fin)";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([
        'id_utilisateur' => $utilisateur_id,
        'id_entreprise' => $entreprise_id,
        'sujet' => $sujet,
        'date_debut' => $date_debut,
        'date_fin' => $date_fin
    ]);

    $success = true;
    $message = "✅ Stage ajouté avec succès ! ID: " . $connexion->lastInsertId();
} catch (Exception $e) {
    $success = false;
    $message = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Traitement - Résultat</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        h1 { color: #333; text-align: center; }
        .success { color: #28a745; padding: 20px; background: #d4edda; border-radius: 5px; margin-bottom: 20px; }
        .error { color: #dc3545; padding: 20px; background: #f8d7da; border-radius: 5px; margin-bottom: 20px; }
        .btn { 
            background: #007cba; color: white; padding: 12px 24px; text-decoration: none; 
            border-radius: 5px; display: inline-block; margin: 10px 10px 10px 0;
        }
        .btn:hover { background: #005a87; }
        .btn-list { background: #28a745; }
        .btn-list:hover { background: #218838; }
        .container { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $success ? '🎉 Succès' : '❌ Erreur'; ?></h1>
        <div class="<?php echo $success ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <a href="Enregistrement stage.html" class="btn">🔄 Nouveau stage</a>
        <a href="liste stage.php" class="btn btn-list">📋 Voir la liste</a>
    </div>
</body>
</html>
