<?php
require_once 'auth_check.php';
requireLogin(); // Redirige vers login si non connecté

$user = getUserInfo();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
</head>

<body>
    <h1>Bienvenue, <?= htmlspecialchars($user['prenom']) ?> !</h1>
    <p>Identifiant : <?= htmlspecialchars($user['email']); ?></p>

    <a href="logout.php">Se déconnecter</a>
</body>

</html>