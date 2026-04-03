<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SunSip - Livraison en cours</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body class="bodydeliveryperson">

<header class="headerdeliveryperson">
    <a href="acceuil.php" class="backlink">⬅ Retour</a>
    <h2>Livraison #450</h2>
</header>

<main class="containermobile">
    <section class="carddelivery">
        <div class="clientinfo">
            <h1 class="nameclient">Julie Sun</h1>
            <a href="tel:0601020304" class="btntel">📞 Appeler le client</a>
        </div>
        <hr class="separatordeliveryperson">
        <div class="detailbloc">
            <h3>Adresse de livraison :</h3>
            <p class="adresstext">12 rue du Smoothie, 75000 Paris</p>
            <a href="https://www.google.com/maps/search/?api=1&query=12+rue+du+Smoothie+75000+Paris" target="_blank" class="btnmaps">
                Ouvrir dans Maps / Waze
            </a>
        </div>
        <div class="detailbloc">
            <h3>Info d'accès</h3>
            <div class="grilleaccess">
                <div class="itemaccess"><strong>Étage :</strong> 4ème</div>
                <div class="itemaccess"><strong>Code :</strong> 25A8</div>
            </div>
        </div>
        <div class="detailbloc">
            <h3>Instructions</h3>
            <p class="commdeliveryperson">Bâtiment est au fond à gauche</p>
        </div>
        <button class="btnvalidatedelivery">Marquer comme LIVRÉ</button>
    </section>
</main>

<?php include('../includes/footer.php'); ?>

</body>
</html>
