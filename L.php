<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "users");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupération des données du formulaire
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Sécurisation

// Vérification de l'email
$check = $conn->prepare("SELECT id FROM utilisateur WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "Cet email est déjà utilisé.";
} else {
    // Insertion
    $stmt = $conn->prepare("INSERT INTO utilisateur (prenom, nom, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $prenom, $nom, $email, $password);

    if ($stmt->execute()) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$check->close();
$conn->close();
