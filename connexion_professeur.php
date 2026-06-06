<?php
session_start();

$err = $_SESSION['prof_auth_error'] ?? '';
$ok = $_SESSION['prof_auth_success'] ?? '';

unset($_SESSION['prof_auth_error'], $_SESSION['prof_auth_success']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="logo.png">
</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <h2 class="text-center mb-4">Connexion professeur</h2>

            <?php if ($err): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
            <?php endif; ?>

            <?php if ($ok): ?>
                <div class="alert alert-success"><?= htmlspecialchars($ok) ?></div>
            <?php endif; ?>

            <!-- IMPORTANT : POST vers le bon fichier -->
            <form action="login.php" method="POST">

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Se connecter
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
?>
