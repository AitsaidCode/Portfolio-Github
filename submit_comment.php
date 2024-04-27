<?php
// Paramètres de connexion à la base de données
$servername = "localhost"; // Adaptez à votre configuration
$dbname = "DatabaseForum"; // Nom de la base de données

// Initialisation de l'objet mysqli
$conn = mysqli_init();
if (!$conn) {
    die('mysqli_init failed');
}

// Spécifier les options pour utiliser SSL
$conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);

// Spécifier les chemins vers les fichiers de certificats et de clés
$conn->ssl_set(
    '/chemin/vers/client-key.pem',   // Chemin vers la clé privée
    '/chemin/vers/client-cert.pem',  // Chemin vers le certificat client
    '/chemin/vers/ca-cert.pem',      // Chemin vers le certificat CA
    NULL,                            // Chemin vers le dossier CA (si nécessaire)
    NULL                             // Liste des algorithmes de chiffrement (si nécessaire)
);

// Établissement de la connexion avec SSL
if (!$conn->real_connect($servername, $username, $password, $dbname, null, null, MYSQLI_CLIENT_SSL)) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

// Récupérer les données du formulaire
$nom = mysqli_real_escape_string($conn, $_POST['nom']);
$prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

// Préparer et exécuter la requête SQL
$sql = "INSERT INTO Messages (nom, prenom, email, message) VALUES ('$nom', '$prenom', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    echo "Nouveau message enregistré avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

// Fermer la connexion
$conn->close();
?>

