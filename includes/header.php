<?php //////////////////////////////////////////
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

// Expulsion utilisateur bloqué
if (isset($_SESSION['user_id'])) {
      
    $liste_utilisateurs = json_decode(file_get_contents('../data/utilisateur.json'), true);
    
    foreach ($liste_utilisateurs as $utilisateur) {
        if ($utilisateur['id_user'] == $_SESSION['user_id']) {
            if (isset($utilisateur['statut']) && $utilisateur['statut'] === 'bloque') {
                session_destroy();
                header('Location: connexion.php?erreur=compte_bloque');
                exit();
            }
        }
    }
}

// Calcul du nombre d'articles total dans le panier
$nb_articles = 0;
if (isset($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $quantite) {
        $nb_articles += $quantite;
    }
}
?>

<header class="headersun">
    <div class="titlegroup">
        <h1 class="titlepink">SunSip</h1>
        <p class="slogan">"Frais et délicieux : Le smoothie qui défie le soleil !"</p>
    </div>
    <img src="../images/logo.jpeg" alt="Logo SunSip" class="removebg">
    
</header>

<nav class="navsimple">
    <button id="theme-toggle" style="background: none; border: none; cursor: pointer; font-size: 20px;">🌓</button>
    <a href="../views/acceuil.php">Accueil</a>
    <a href="../views/presentation.php">Carte</a>
    <a href="avis.php">Avis Clients</a>

    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] === 'client'): ?>
        <a href="panier.php" style="position: relative; font-weight: bold; color: #ff6b6b;">
            🛒 Panier 
            <?php if ($nb_articles > 0): ?>
                <span style="background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.8em; position: absolute; top: -10px; right: -15px;">
                    <?= $nb_articles ?>
                </span>
            <?php endif; ?>
        </a>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="admin.php" style="color: gold;">Panel Admin</a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'client'): ?>
            <a href="profil.php">Mon Profil</a>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'livreur'): ?>
            <a href="livraison.php">Courses à faire</a>
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

<script src="../js/theme.js" defer></script>
