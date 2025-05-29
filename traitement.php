<?php

$host = 'localhost';
$dbname = 'portfolio_db';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}


$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    
    $to = "TADRESSE@EMAIL.com"; 
    $subject = "Nouveau message depuis ton portfolio";
    $body = "Nom: $name\nEmail: $email\nMessage:\n$message";
    $headers = "From: portfolio@tonsite.com";

    if (mail($to, $subject, $body, $headers)) {
        echo "Message envoyé avec succès et e-mail de notification envoyé.";
    } else {
        echo "Message enregistré, mais l'e-mail n'a pas pu être envoyé.";
    }
} else {
    echo "Erreur lors de l'envoi du message : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
