<?php
// inscription.php

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    // Vérifier que les mots de passe correspondent
    if ($password !== $password_confirmation) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } else {
        $success_message = "User created";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Formulaire d'inscription</h2>

    <?php if ($success_message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form action="inscription.php" method="POST">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" placeholder="Entrez votre nom" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="email" name="email" id="email" placeholder="Entrez votre email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="Mot de passe" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmation du mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmez le mot de passe" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>
</body>
</html>
