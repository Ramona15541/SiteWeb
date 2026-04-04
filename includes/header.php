<?php session_start(); ?>

<header class="headersun">
    <div class="titlegroup">
        <h1 class="titlepink">SunSip</h1>
        <p class="slogan">"Frais et délicieux : Le smoothie qui défie le soleil !"</p>
    </div>
    <img src="../images/logo.jpeg" alt="Logo SunSip" class="removebg">
</header>

<nav class="navsimple">
    <a href="../views/acceuil.php">Accueil</a>
    <a href="../views/presentation.php">Carte</a>

       
        
    <?php if (isset($_SESSION['user_id'])): ?>
        
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="admin.php" style="color: gold;">Panel Admin</a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'client'): ?>
            <a href="profil.php">Mon Profil</a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'livreur'): ?>
            <a href="livraison.php"> Courses à faire</a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'restaurateur'): ?>
            <a href="commande.php">Commandes reçues</a>
        <?php endif; ?>

        <a href="../bin/logout.php" style="color: red;">Déconnexion</a>

    <?php else: ?>
        <a href="inscription.php">S'inscrire</a>
        <a href="connexion.php">Connexion</a>
    <?php endif; ?>
</nav>