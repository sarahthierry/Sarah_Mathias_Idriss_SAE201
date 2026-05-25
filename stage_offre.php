<?php
session_start();

$error = "";
$message = "";

// UI simple: formulaire d'offre. On tente insertion si tables existent.
$HOSTNAME = "localhost";
$DBNAME = "gestion_stage"; // à adapter si besoin
$USER = "root";
$PASSWD = "";

$offres = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entreprise = trim($_POST['entreprise'] ?? '');
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($entreprise === '' || $titre === '') {
        $error = "Entreprise et titre sont obligatoires";
    } else {
        try {
            $connexion = new PDO("mysql:host=$HOSTNAME;dbname=$DBNAME;charset=utf8", $USER, $PASSWD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hypothèse: table stage_offres (id, entreprise, titre, description)
            // Si elle n'existe pas, on tombe dans catch.
            $sql = "INSERT INTO stage_offres (entreprise, titre, description) VALUES (:entreprise, :titre, :description)";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([
                'entreprise' => $entreprise,
                'titre' => $titre,
                'description' => $description
            ]);

            $message = "✅ Offre enregistrée";
        } catch (Exception $e) {
            $error = "Impossible d'enregistrer (table inexistante ou schéma différent). Info: " . $e->getMessage();
        }
    }
}

try {
    $connexion = new PDO("mysql:host=$HOSTNAME;dbname=$DBNAME;charset=utf8", $USER, $PASSWD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id, entreprise, titre, description FROM stage_offres ORDER BY id DESC";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Pas bloquant pour la page UI
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offre de stage</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 40px auto; padding: 20px; background: #f5f5f5; }
        h1 { color: #333; text-align: center; margin-bottom: 20px; }
        .grid { display: grid; grid-template-columns: 1fr; gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #155724; background: #d4edda; padding: 12px; border-radius: 8px; margin-bottom: 15px; }
        .error { color: #721c24; background: #f8d7da; padding: 12px; border-radius: 8px; margin-bottom: 15px; }
        label { display:block; margin: 10px 0 6px; font-weight: 700; color:#555; }
        input[type="text"], textarea {
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;
        }
        textarea { min-height: 110px; resize: vertical; }
        .btn {
            margin-top: 15px;
            background: #28a745; color: white; padding: 12px 18px;
            border: none; border-radius: 8px; cursor: pointer; font-size: 16px;
        }
        .btn:hover { background: #218838; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; vertical-align: top; }
        th { background: #007cba; color: white; }
    </style>
</head>
<body>
    <h1>📄 Offres de stage</h1>

    <div class="grid">
        <div class="card">
            <h2 style="margin-bottom: 10px;">➕ Nouvelle offre</h2>

            <?php if ($message !== ''): ?><div class="success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
            <?php if ($error !== ''): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

            <form method="POST">
                <label for="entreprise">Entreprise</label>
                <input id="entreprise" name="entreprise" type="text" required>

                <label for="titre">Titre</label>
                <input id="titre" name="titre" type="text" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Détails de l'offre..."></textarea>

                <button class="btn" type="submit">✅ Enregistrer</button>
            </form>

            <p style="margin-top: 15px; color:#666; font-size: 14px;">
                Si la table <b>stage_offres</b> n'existe pas dans votre base, l'UI reste utilisable et affichera un message d'erreur.
            </p>
        </div>

        <div class="card">
            <h2 style="margin-bottom: 10px;">Liste des offres</h2>
            <?php if (empty($offres)): ?>
                <p style="color:#666;">Aucune offre affichée (table stage_offres peut ne pas exister).</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Entreprise</th>
                            <th>Titre</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($offres as $o): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($o['id'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($o['entreprise'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($o['titre'] ?? ''); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($o['description'] ?? '')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <div style="margin-top: 15px;">
                <a href="connexion_professeur.php" style="display:inline-block; background:#007cba; color:white; padding:10px 16px; text-decoration:none; border-radius:8px;">🔐 Connexion professeur</a>
            </div>
        </div>
    </div>
</body>
</html>

