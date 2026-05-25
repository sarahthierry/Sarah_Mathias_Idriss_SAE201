<?php
session_start();

$error = "";
$message = "";

$HOSTNAME = "localhost";
$DBNAME = "gestion_stages"; // à adapter si besoin
$USER = "root";
$PASSWD = "";

$maitres = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $entreprise_id = (int)($_POST['entreprise_id'] ?? 0);

    if ($nom === '' || $prenom === '' || $entreprise_id <= 0) {
        $error = "Nom, prénom et entreprise sont obligatoires";
    } else {
        try {
            $connexion = new PDO("mysql:host=$HOSTNAME;dbname=$DBNAME;charset=utf8", $USER, $PASSWD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hypothèse: table maitre_stage (id, nom, prenom, entreprise_id)
            $sql = "INSERT INTO maitre_stage (nom, prenom, entreprise_id) VALUES (:nom, :prenom, :entreprise_id)";
            $stmt = $connexion->prepare($sql);
            $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'entreprise_id' => $entreprise_id]);
            $message = "✅ Maître de stage enregistré";
        } catch (Exception $e) {
            $error = "Impossible d'enregistrer (table inexistante ou schéma différent). Info: " . $e->getMessage();
        }
    }
}

try {
    $connexion = new PDO("mysql:host=$HOSTNAME;dbname=$DBNAME;charset=utf8", $USER, $PASSWD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id, nom, prenom, entreprise_id FROM maitre_stage ORDER BY id DESC";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $maitres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // UI seulement
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maître de stage</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 40px auto; padding: 20px; background: #f5f5f5; }
        h1 { text-align:center; color:#333; margin-bottom:20px; }
        .grid { display:grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }
        .card { background:white; padding:20px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1); }
        .success { color:#155724; background:#d4edda; padding:12px; border-radius:8px; margin-bottom:12px; }
        .error { color:#721c24; background:#f8d7da; padding:12px; border-radius:8px; margin-bottom:12px; }
        label { display:block; margin:10px 0 6px; font-weight:700; color:#555; }
        input[type="text"], input[type="number"] { width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; font-size:16px; }
        .btn { margin-top: 15px; background:#28a745; color:white; padding:12px 18px; border:none; border-radius:8px; cursor:pointer; font-size:16px; }
        .btn:hover { background:#218838; }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        th, td { padding:12px; border-bottom:1px solid #eee; text-align:left; vertical-align:top; }
        th { background:#007cba; color:white; }
    </style>
</head>
<body>
    <h1>👨‍🏫 Maître de stage</h1>

    <div class="grid">
        <div class="card">
            <h2 style="margin-bottom:10px;">➕ Nouveau maître de stage</h2>
            <?php if ($message !== ''): ?><div class="success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
            <?php if ($error !== ''): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

            <form method="POST">
                <label for="nom">Nom</label>
                <input id="nom" name="nom" type="text" required>

                <label for="prenom">Prénom</label>
                <input id="prenom" name="prenom" type="text" required>

                <label for="entreprise_id">ID Entreprise</label>
                <input id="entreprise_id" name="entreprise_id" type="number" min="1" required>

                <button class="btn" type="submit">✅ Enregistrer</button>
            </form>
        </div>

        <div class="card">
            <h2 style="margin-bottom:10px;">Liste</h2>
            <?php if (empty($maitres)): ?>
                <p style="color:#666;">Aucun maître affiché (table maitre_stage peut ne pas exister).</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Entreprise ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($maitres as $m): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($m['id'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars(($m['prenom'] ?? '') . ' ' . ($m['nom'] ?? '')); ?></td>
                                <td><?php echo htmlspecialchars($m['entreprise_id'] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <div style="margin-top:15px;">
                <a href="entreprise.php" style="display:inline-block;background:#007cba;color:white;padding:10px 16px;text-decoration:none;border-radius:8px;">🏢 Entreprises</a>
            </div>
        </div>
    </div>
</body>
</html>

