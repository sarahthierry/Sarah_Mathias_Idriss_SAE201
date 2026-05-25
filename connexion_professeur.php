<?php
session_start();

$HOSTNAME = "localhost";
$DBNAME = "gestion_stage"; // à adapter si besoin
$USER = "root";
$PASSWD = "";

$error = "";
$successText = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Email et mot de passe requis";
    } else {
        // Tentative simple: si une table existe avec des colonnes mot_de_passe + grade/prof.
        // Si la base n'est pas prête, on évite de casser l'UI et on affiche un message clair.
        try {
            $connexion = new PDO("mysql:host=$HOSTNAME;dbname=$DBNAME;charset=utf8", $USER, $PASSWD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hypothèse: table utilisateurs avec grade='prof' et colonne mot_de_passe (hash)
            $sql = "SELECT id, nom, prenom, email, grade, mot_de_passe FROM utilisateurs WHERE email = :email AND grade = :grade LIMIT 1";
            $stmt = $connexion->prepare($sql);
            $stmt->execute(['email' => $email, 'grade' => 'prof']);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && !empty($user['mot_de_passe']) && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['professeur_id'] = (int)$user['id'];
                $_SESSION['professeur_email'] = $user['email'];
                $_SESSION['professeur_grade'] = $user['grade'];
                $_SESSION['professeur_nom'] = trim(($user['nom'] ?? '') . ' ' . ($user['prenom'] ?? ''));

                $successText = "Connexion professeur réussie. Bonjour " . htmlspecialchars($_SESSION['professeur_nom']);
            } else {
                $error = "Identifiants professeur invalides";
            }
        } catch (Exception $e) {
            $error = "Base non disponible ou schéma non compatible: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Professeur</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 520px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; margin-bottom: 0.5rem; color: #555; font-weight: 600; }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn:hover { transform: translateY(-2px); }
        .links { text-align: center; margin-top: 1.2rem; }
        .links a { color: #667eea; text-decoration: none; margin: 0 8px; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔐 Connexion Professeur</h2>

        <?php if ($successText !== ''): ?>
            <div class="success"><?php echo $successText; ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button class="btn" type="submit">Se connecter</button>
        </form>

        <div class="links">
            <a href="Inscription utilisateur.html">👤 Retour inscription</a>
            <a href="stage_offre.php">📄 Offres de stage</a>
        </div>
    </div>
</body>
</html>

