<?php
$HOSTNAME = "localhost";
$DBNAME = "gestion_stage";
$USER = "root";
$PASSWD = "";

try {
    $connexion = new PDO("mysql:host=$HOSTNAME;dbname=$DBNAME;charset=utf8", $USER, $PASSWD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT id, nom, prenom, email, grade FROM utilisateurs ORDER BY id DESC";

    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $success = true;
} catch (Exception $e) {
    $success = false;
    $error_message = "❌ Erreur de connexion/base: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 1200px; 
            margin: 50px auto; 
            padding: 20px;
            background: #f5f5f5;
        }
        h1 { color: #333; text-align: center; }
        .error { color: red; padding: 20px; background: #fee; border-radius: 5px; margin-bottom: 20px; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th, td { 
            padding: 12px; 
            text-align: left; 
            border-bottom: 1px solid #ddd; 
        }
        th { background: #007cba; color: white; }
        tr:hover { background: #f0f8ff; }
        tr:nth-child(even) { background: #f9f9f9; }
        .btn { 
            background: #28a745; 
            color: white; 
            padding: 10px 20px; 
            text-decoration: none; 
            border-radius: 5px; 
            display: inline-block; 
            margin-top: 20px;
        }
        .btn:hover { background: #218838; }
        .stats { 
            background: #e9ecef; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            text-align: center;
        }
        .count { font-size: 1.5em; font-weight: bold; color: #007cba; }
        .empty { text-align: center; padding: 50px; color: #666; }
        .grade-etudiant { background-color: #d4edda; }
        .grade-admin { background-color: #fff3cd; }
        .grade-prof { background-color: #d1ecf1; }
        .grade-badge { padding: 4px 8px; border-radius: 12px; font-size: 0.8em; font-weight: bold; }
    </style>
</head>
<body>
    <h1>📊 Liste des Stages</h1>
    
    <?php if (isset($error_message)): ?>
        <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php else: ?>
        <div class="stats">
            <span class="count"><?php echo count($stages); ?></span> stage(s) disponible(s)
        </div>
        
        <?php if (empty($stages)): ?>
            <div class="empty">
                <h3>Aucun stage enregistré</h3>
                <p>Créez d'abord des utilisateurs et entreprises via phpMyAdmin avec migration.sql</p>
                <a href="Inscription utilisateur.html" class="btn">➕ Ajouter un utilisateur</a>
            </div>
        <?php else: ?>
            <table>
                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Grade</th>
                    </tr>

                </thead>
                <tbody>
                    <?php foreach ($stages as $row): ?>
                    <tr class="grade-<?php echo htmlspecialchars($row['grade']); ?>">
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><strong><?php echo htmlspecialchars($row['titre']); ?></strong><br>
                            <small><?php echo htmlspecialchars($row['description'] ?? ''); ?></small></td>
                        <td><?php echo htmlspecialchars($row['prenom']) . ' ' . htmlspecialchars($row['nom']); ?></td>
                        <td><span class="grade-badge"><?php echo htmlspecialchars(ucfirst($row['grade'])); ?></span></td>
                        <td><?php echo htmlspecialchars($row['entreprise_nom'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['date_debut'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['duree_mois'] ?? ''); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="Inscription utilisateur.html" class="btn">➕ Nouvelle inscription utilisateur</a>
            <a href="Enregistrement stage.html" class="btn">➕ Nouveau stage</a>
            <a href="Inscription entreprise.html" class="btn">➕ Nouvelle entreprise</a>
            <a href="liste stage.php" class="btn">📋 Voir les stages</a>
        </div>
    <?php endif; ?>
</body>
</html>