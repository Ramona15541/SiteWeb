<?php include('../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>SunSip - Connexion</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>


<?php if (isset($_GET['erreur']) && $_GET['erreur'] === 'compte_bloque'): ?>
    <div>
         Votre compte a été bloqué par l'administrateur. Accès refusé.
    </div>
<?php endif; ?>
<section class="formsection">
    <div class="formcontainer">
        <h2 class="titlepink">Se connecter</h2>
        
        <?php if (isset($_GET['erreur'])): ?>
    <p>
        <?php 
            if($_GET['erreur'] == 'password') echo "oupsi, mot de passe incorrect..?";
            if($_GET['erreur'] == 'introuvable') echo "oupsi, mauvais email..?";
        ?>
    </p>
<?php endif; ?>


        <form action="../bin/login.php" method="POST">
            <div class="inputwrapper">
                <div class="inputwrapper">
                <label>Email</label>
                <input type="text" name="mail" placeholder="fatimamimi@smoothie.com">
    
                <label>ou Pseudo</label>
                <input type="text" name="login" placeholder="MonPseudo">
</div>
            </div>
            <div style="position:relative">
                
        <input type="password" id="password" name="password" placeholder="Mot de passe" maxlength="32" required>
        <span id="toggle-password" style="position: absolute; right: 20px; top: 12px; cursor: pointer; z-index: 10;">👁️</span>
    </div>
            <p class="passwordoversight"><a href="#">Mot de passe oublié ?</a></p>
            <button type="submit" class="btninscription">Aller chercher mon smoothie !</button>
        </form>
        <p class="linkconnection">Pas encore de compte ? <a href="inscription.php">Inscris-toi ici</a></p>
    </div>
</section>

<?php include('../includes/footer.php'); ?>
<script src="../js/validation.js"></script>
</body>
</html>
