<?php
session_start();

$HOSTNAME = "localhost";
$DBNAME = "gestion_stage";
$USER = "root";
$PASSWD = "";

$success = false;
$message = "";

if ($_POST['action'] ?? '' === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $message = "Email et mot de passe requis";
    } else {
        try {
            $connexion = new PDO("mysql:host=$HOSTNAME;dbname=$DBNAME;charset=utf8", $USER, $PASSWD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // TODO: Add password column to DB: ALTER TABLE utilisateurs ADD COLUMN password VARCHAR(255);
            // For now, use email as temp password (change after adding real passwords)
            $sql = "SELECT id, nom, prenom, email, grade, mot_de_passe FROM utilisateurs WHERE email = :email AND mot_de_passe IS NOT NULL LIMIT 1";
            $stmt = $connexion->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_grade'] = $user['grade'];
                $_SESSION['user_nom'] = $user['nom'] . ' ' . $user['prenom'];
                
                header("Location: liste utilisateur.php?msg=success&text=" . urlencode("Bienvenue {$_SESSION['user_nom']} !"));
                exit;
            } else {
                $message = "Email ou mot de passe incorrect";
            }
        } catch (Exception $e) {
            $message = "Erreur base: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Résultat</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 600px; margin: 50px auto; 
            padding: 20px; background: #f5f5f5;
        }
        h1 { color: #333; text-align: center; }
        .success { 
            color: #28a745; padding: 20px; background: #d4edda; 
            border-radius: 5px; margin-bottom: 20px; text-align: center;
        }
        .error { 
            color: #dc3545; padding: 20px; background: #f8d7da; 
            border-radius: 5px; margin-bottom: 20px; text-align: center;
        }
        .btn { 
            background: #007cba; color: white; padding: 12px 24px; 
            text-decoration: none; border-radius: 5px; display: inline-block; 
            margin: 10px;
        }
        .btn:hover { background: #005a87; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .container { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $success ? '🎉 Succès' : '❌ Erreur'; ?></h1>
        <?php if ($message): ?>
            <div class="<?php echo $success ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <a href="Connexion utilisateur.html" class="btn">🔄 Réessayer</a>
        <a href="liste utilisateur.php" class="btn btn-success">📋 Dashboard</a>
        <a href="Inscription utilisateur.html" class="btn">👤 S'inscrire</a>
    </div>
</body>
</html>
