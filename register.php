<?php
session_start();
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires";
    } elseif ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé";
        } else {
            // Hasher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur
            $stmt = $pdo->prepare("INSERT INTO utilisateur (Nom, prenom, email, password) VALUES (?, ?, ?, ?)");

            if ($stmt->execute([$nom, $prenom, $email, $hashedPassword])) {
                $success = "Inscription réussie ! Vous pouvez vous connecter.";
            } else {
                $error = "Erreur lors de l'inscription";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        form {

            justify-content: center;
            border-radius: 10px;
            border: 2px;
            width: 60px;

        }
    </style>
</head>

<body>
    <h2>Inscription</h2>

    <?php if ($error): ?>
        <div style="color: red;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color: green;"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div>
            <label>Nom :</label>
            <input type="text" name="nom" required>
        </div>

        <div>
            <label>Prénom :</label>
            <input type="text" name="prenom" required>
        </div>

        <div>
            <label>Email :</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>Mot de passe :</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" required>
        </div>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
</body>

</html>