<?php
//  PAGE PROTÉGÉE : SEULS LES CONNECTÉS Y ONT ACCÈS
session_start(); // On démarre la session pour pouvoir vérifier si l'utilisateur est connecté

// Si l'utilisateur n'est pas connecté (pas dans $_SESSION), on le redirige vers login.php
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Récupération du nom de l'utilisateur depuis la session
$name = htmlspecialchars($_SESSION["user"]["name"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <!-- Message de bienvenue -->
    <div class="alert alert-success">
        Hello <?= $name ?> Welcome to your dashboard!
    </div>
</body>
</html>
