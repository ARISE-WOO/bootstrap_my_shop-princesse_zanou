<?php
session_start(); // On démarre la session pour pouvoir stocker l'utilisateur une fois connecté

// Affichage des erreurs PHP (très utile pendant le développement)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Message qui s'affichera en cas d'erreur
$message = "";

// Si le formulaire est soumis via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // On récupère les champs Email et Password (en respectant bien le name="Email" et "Password")
    $email = trim($_POST["Email"] ?? '');
    $password = trim($_POST["Password"] ?? '');

    // Si les deux champs sont remplis
    if (!empty($email) && !empty($password)) {
        try {
            // Connexion à la base SQLite existante
            $db = new PDO("sqlite:../users.db");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // On cherche l'utilisateur correspondant à cet email
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si l'utilisateur existe et que le mot de passe est correct
            if ($user && password_verify($password, $user["password"])) {
                // On enregistre l'utilisateur dans la session (connexion)
                $_SESSION["user"] = [
                    "id" => $user["id"],
                    "name" => $user["name"],
                    "email" => $user["email"]
                ];

                //  Redirection vers la page d'accueil
                header("Location: index.php");
                exit();
            } else {
                //  Si email ou mot de passe incorrect
                $message = "Invalid credentials.";
            }

        } catch (Exception $e) {
            //  Si la base n'est pas accessible ou autre erreur
            $message = "Database error.";
        }

    } else {
        //  Si un champ est vide
        $message = "Please fill in both fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Login</h2>

    <!-- Message d'erreur si besoin -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Formulaire de connexion -->
    <form method="post">
        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email*</label>
            <input type="email" name="Email" id="email" class="form-control" required>
        </div>

        <!-- Mot de passe -->
        <div class="mb-3">
            <label for="password" class="form-label">Password*</label>
            <input type="password" name="Password" id="password" class="form-control" required>
        </div>

        <!-- Bouton submit -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</body>
</html>
