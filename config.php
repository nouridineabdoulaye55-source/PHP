
<?php
// config.php - Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'users');
define('DB_USER', 'root');  // Souvent 'root' en local
define('DB_PASS', '');      // Souvent vide en local avec XAMPP/WAMP

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
