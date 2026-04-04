<?php include('../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>SunSip - Inscription</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>


<section class="formsection">
    <div class="formcontainer">
        <h2 class="titlepink">Crée ton compte</h2>
        <form action="../bin/scinscription.php" method="POST">
            <div class="formgroup">
                <input type="text" name="prenom" placeholder="Prénom" required>
                <input type="text" name="nom" placeholder="Nom" required>
            </div>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="telephone" placeholder="Numéro de téléphone" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <hr class="separator">
            <h3>Adresse de livraison</h3>
            <input type="text" name="adresse" placeholder="Adresse complète (N°, rue...)" required>
            <div class="formgroup">
                <input type="text" name="code_postal" placeholder="Code Postal" required>
                <input type="text" name="ville" placeholder="Ville" required>
            </div>
            <h3>Accès livreur</h3>
            <div class="formgroup">
                <input type="text" name="etage" placeholder="Étage">
                <input type="text" name="code_interphone" placeholder="Code Interphone">
            </div>
            <textarea name="instructions" placeholder="Instructions pour le livreur..."></textarea>
            <button type="submit" class="btninscription">M'inscrire et commander !</button>
        </form>
        <p class="linkconnection">Déjà membre ? <a href="connexion.php">Connecte-toi ici</a></p>
    </div>
</section>

<?php include('../includes/footer.php'); ?>

</body>
</html>
