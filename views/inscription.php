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
        <form id="form-inscription" action="../bin/scinscriptions.php" method="POST">
    
    <div class="formgroup">
        <div>
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>
            <span id="error-prenom" class="error-message"></span>
        </div>
        <div>
            <input type="text" id="nom" name="nom" placeholder="Nom" required>
            <span id="error-nom" class="error-message"></span>
        </div>
    </div>

    <input type="email" id="email" name="email" placeholder="Email" required>
    <span id="error-email" class="error-message"></span>

    <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone" required>
    <span id="error-telephone" class="error-message"></span>

    <div style="position: relative;">
        <input type="password" id="password" name="password" placeholder="Mot de passe" maxlength="32" required>
        <span id="toggle-password" style="position: absolute; right: 15px; top: 12px; cursor: pointer; z-index: 10;">👁️</span>
    </div>
    <div>
        <span id="error-password" class="error-message" style="color: red; font-size: 13px; display: none;"></span>
        <span id="password-counter" class="char-counter" style="font-size: 12px; color: #888;">32 caractères restants</span>
    </div>
 

    <hr class="separator">
    
    <h3>Adresse de livraison</h3>
    <input type="text" id="adresse" name="adresse" placeholder="Adresse complète (N°, rue...)" required>
    <span id="error-adresse" class="error-message"></span>

    <div class="formgroup">
        <div>
            <input type="text" id="code_postal" name="code_postal" placeholder="Code Postal" required>
            <span id="error-code_postal" class="error-message"></span>
        </div>
        <div>
            <input type="text" id="ville" name="ville" placeholder="Ville" required>
            <span id="error-ville" class="error-message"></span>
        </div>
    </div>

    <h3>Accès livreur</h3>
    <div class="formgroup">
        <input type="text" id="etage" name="etage" placeholder="Étage">
        <input type="text" id="code_interphone" name="code_interphone" placeholder="Code Interphone">
    </div>
    <textarea id="instructions" name="instructions" placeholder="Instructions pour le livreur..."></textarea>
    
    <button type="submit" class="btninscription">M'inscrire et commander !</button>
</form>
        <p class="linkconnection">Déjà membre ? <a href="connexion.php">Connecte-toi ici</a></p>
    </div>
</section>

<?php include('../includes/footer.php'); ?>
<script src="../js/validation.js"></script>

</body>
</html>
