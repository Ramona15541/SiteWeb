<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>SunSip - Profil</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>


<?php include('../includes/header.php'); ?>

<section class="formsectionn">
    <div class="formcontainerr">
        <h2 class="titlepink">Mon profil</h2>
        <div class="formgroupcolumn">
            <p><strong>Nom :</strong> Moi <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
            <p><strong>Prénom :</strong> Kakki <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
            <p><strong>Email :</strong> moikakki@email.com <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
            <p><strong>Téléphone :</strong> 06 67 67 67 67 <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
            <p><strong>Adresse :</strong> 6 rue de la république, Paris <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
        </div>
    </div>
</section>

<section class="formsectionn">
    <div class="formcontainerr">
        <h2 class="titlepink">Mon compte fidélité</h2>
        <div class="formgroupcolumn">
            <p><strong>Points actuels :</strong> 120 points</p>
            <p class="loyaltyemessage">
                Encore 30 points pour un smoothie offert !
            </p>
        </div>
    </div>
</section>

<section class="formsectionn">
    <div class="formcontainerr">
        <h2 class="titlepink">Mes anciennes commandes</h2>
        
        <div class="orderitem">
            <p><strong>Commande #101</strong></p>
            <p>Date : 10/02/2026</p>
            <p>Statut : <span style="color: green;">Livrée</span></p>
            <a href="notation.html">
                <button class="btninscription">Noter la commande</button>
            </a>
        </div>

        <div class="orderitem">
            <p><strong>Commande #95</strong></p>
            <p>Date : 28/01/2026</p>
            <p>Statut : <span style="color: green;">Livrée</span></p>
            <button class="btninscription">Voir détails</button>
        </div>
    </div>
</section>
<footer>
    <div class="footersimple">
        <p>📍 12 rue du Smoothie, Sunsippy | mail: hello@sunsip.fr</p>
        <p class="instapote">Suivez-nous sur Insta : <strong>@SunSip_Fresh</strong> </p>
        <hr class="minibar">
        <p>SunSip &copy; 2026 - Fait avec amour 🍓</p>
    </div>
</footer>

</body>
</html>
