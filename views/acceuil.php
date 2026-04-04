<?php include('../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>SunSip - Accueil</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>



<section>
    <h2 class="title">Recherche de desserts</h2>
    <div class="zone">
        <input type="text" placeholder="Trouver un smoothie...">
        <button>🔍</button>
    </div>
</section>

<section class="ourstory">
    <div class="storycontainer">
        <h2 class="titlepink">L'aventure SunSip !</h2>
        <div class="textpresentation">
            <p>
                Tout a commencé avec trois copines, une passion démesurée pour les fruits 
                (limite obsessionnelle, on vous l'avoue) et un mixeur qui a beaucoup trop souffert. 
                Notre truc à nous ? Créer des mélanges de saveurs uniques, pour le bonheur de nos papilles !
            </p>
            <p>
                Mais on a vite réalisé un problème : en plein été, la fraîcheur d'un smoothie 
                s'envole en quelques minutes sous le soleil. C'est de cette frustration qu'est né <strong>SunSip</strong>.
            </p>
            <p>
                Notre défi ? Créer une bouchée de soleil frais qui résiste à la chaleur. 
                Grâce à nos recettes uniques et un savoir-faire particulier, nos smoothies sont 
                prêts à défier le soleil pour vous accompagner tout l'été.
            </p>
        </div>
        <span class="signature">L'équipe SunSip</span>
        <img src="../images/logo.jpeg" alt="Logo SunSip" class="removebb">
    </div>
</section>

<section class="sectionpresentation">
    <div class="contentflex">
        <img src="../images/frutmarche.jpg" alt="Fruits du marché" class="imgzoom">
        <div class="textpresentation">
            <h2 class="titlepink">Des fruits qualitatifs !</h2>
            <p>Nos fruits sont cueillis avec <strong>amour</strong> sur les meilleurs étals 
            pour vous garantir un goût authentique et une explosion de saveurs en bouche.</p>
        </div>
    </div>
</section>

<section class="section-presentation inverse">
    <div class="contentflex">
        <img src="../images/fruitaufrais.jpg" alt="Fruits au frais" class="imgzoom">
        <div class="textpresentation">
            <h2 class="titlepink">Toujours au frais !</h2>
            <p>Des fruits au frais rien que pour votre palais ! Nos préparations restent 
            <strong>glacées</strong> jusqu'à la dégustation, même quand le thermomètre s'affole.</p>
        </div>
    </div>
</section>

<section class="bestsellerunique">
    <h2 class="titlepink">Notre Best-Seller</h2>
    <div class="product star">
        <div class="badgestar">LE DRAGON CRUSH</div>
        <img src="../images/ssexo2.png" alt="Dragon Crush">
        <h3>Dragon Crush</h3>
        <p class="textpresentation">L'explosion exotique du fruit du dragon et de la fraise.</p>
        <span class="prix">7.50€</span>
        <br><br>
        <a href="presentation.php">
            <button class="btninscription">Commander maintenant</button>
        </a>
    </div>
</section>

<?php include('../includes/footer.php'); ?>

</body>
</html>
