<?php 
include('../includes/header.php'); 

$plats_json = json_decode(file_get_contents('../data/plat.json'), true);
$menus_json = json_decode(file_get_contents('../data/menu.json'), true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SunSip - Menu & Commande</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body class="tablecloth">

<section>
    <h2 class="title">Recherche de gourmandises</h2>
    <div class="zone"> 
        <input type="text" id="search-input" placeholder="Trouver un smoothie ou un dessert..." autocomplete="off">
        <button type="button">🔍</button>
        
        <div id="search-results-show" class="search-show"></div>
    </div>
</section>


<section class="formsection">
    <div class="formcontainer"> 
        <h2 class="menutitle">Carte SunSip</h2>
        <div class="menucontainer">
            <ul class="menulist">
                <li class="menuitem"><a href="#sectionmenus" class="btninscription menulinkbutton">Nos Menus</a></li>
                <li class="menuitem"><a href="#sectionsmoothies" class="btninscription menulinkbutton">Smoothies</a></li>
            </ul>
            <ul class="menulist">
                <li class="menuitem"><a href="#sectiondesserts" class="btninscription menulinkbutton">Desserts</a></li>
            </ul>
        </div> 
    </div>
</section>

<br/><br/>


<section id="sectionmenus">
    <h2 class="title">Nos Formules Menus</h2>
    <div>
        <?php foreach ($menus_json as $menu): ?>
            <div class="product">
                <div class="badgestar">MENU</div>
                <h3><?php echo $menu['nom']; ?></h3>
                <p class="textpresentation"><?php echo $menu['description']; ?></p>
                <span class="prix"><?php echo number_format($menu['prix'], 2); ?>€</span>
                <br><br>
                <a href="ajouter_panier.php?id=<?php echo $menu['id_menu']; ?>&type=menu">
                    <button class="btninscription">Ajouter le Menu </button>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<br/><br/>


<section id="sectionsmoothies">
    <h2 class="title">Nos Smoothies Frais</h2>
    <div>
        <?php foreach ($plats_json as $plat): ?>
            <?php if ($plat['categorie'] === 'Smoothie'): ?>
                <div class="product">
                
                    <img src="../images/<?php echo $plat['id']; ?>.png" alt="<?php echo $plat['nom']; ?>" onerror="this.src='../images/default_smoothie.png'">
                    <h3><?php echo $plat['nom']; ?></h3>
                    <p class="textpresentation"><?php echo $plat['description']; ?></p>
                    <span class="prix"><?php echo number_format($plat['prix'], 2); ?>€</span>
                    <br><br>
                    <a href="ajouter_panier.php?id=<?php echo $plat['id']; ?>&type=plat">
                        <button class="btninscription">Ajouter au panier 🛒</button>
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<br/><br/>


<section id="sectiondesserts">
    <h2 class="title">Nos Desserts</h2>
    <div>
        <?php foreach ($plats_json as $plat): ?>
            <?php if ($plat['categorie'] == 'Dessert'): ?>
                <div class="product">
                    <img src="../images/<?php echo $plat['id']; ?>.png" alt="<?php echo $plat['nom']; ?>" onerror="this.src='../images/default_dessert.png'">
                    <h3><?php echo $plat['nom']; ?></h3>
                    <p class="textpresentation"><?php echo $plat['description']; ?></p>
                    <span class="prix"><?php echo number_format($plat['prix'], 2); ?>€</span>
                    <br><br>
                    <a href="ajouter_panier.php?id=<?php echo $plat['id']; ?>&type=plat">
                        <button class="btninscription">Ajouter au panier 🛒</button>
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<?php include('../includes/footer.php'); ?>
<script src="../js/search.js"></script>
</body>
</html>
