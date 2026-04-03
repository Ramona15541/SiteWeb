<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>SunSip - Connexion</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>

<section class="formsection">
    <div class="formcontainer">
        <h2 class="titlepink">Se connecter</h2>
        
        <?php if (isset($_GET['erreur'])): ?>
    <p style="color: red; text-align: center; font-weight: bold;">
        <?php 
            if($_GET['erreur'] == 'password') echo "Mot de passe incorrect !";
            if($_GET['erreur'] == 'introuvable') echo "Email inconnu...";
        ?>
    </p>
<?php endif; ?>


        <form action="../bin/login.php" method="POST">
            <div class="input-wrapper">
                <label>Ton Email</label>
                <input type="email" name="email" placeholder="soleil@exemple.com" required>
            </div>
            <div class="inputwrapper">
                <label>Ton Mot de passe</label>
                <input type="password" name="password" placeholder="********" required>
            </div>
            <p class="passwordoversight"><a href="#">Mot de passe oublié ?</a></p>
            <button type="submit" class="btninscription">Aller chercher mon smoothie !</button>
        </form>
        <p class="linkconnection">Pas encore de compte ? <a href="inscription.php">Inscris-toi ici</a></p>
    </div>
</section>

<?php include('../includes/footer.php'); ?>

</body>
</html>
