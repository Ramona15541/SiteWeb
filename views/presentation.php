<?php include('../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SunSip - Presentation</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body class="tablecloth">





<section>
    <h2 class="title">Recherche de desserts</h2>
    <div class="zone">
        <input type="text" placeholder="Trouver un smoothie...">
        <button>🔍</button>
    </div>
</section>

<section class="formsection">
    <div class="formcontainer"> 
        <h2 class="menutitle">Menu</h2>
        
        <div class="menucontainer">
            <ul class="menulist">
                <li class="menuitem">
                    <a href="#sectionsmoothies" class="btninscription menulinkbutton">Smoothies</a>
                </li>
                <li class="menuitemcentered">
                    <a href="#smoothieacidule" class="plus">Acidulés</a>
                </li>
                <li class="menuitemcentered">
                    <a href="#smoothiedoux" class="plus">Doux</a>
                </li>
                <li class="menuitemcentered">
                    <a href="#smoothieexotic" class="plus">Exotique</a>
                </li>
            </ul>

            <ul class="menulist">
                <li class="menuitem">
                    <a href="#sectionsalades" class="btninscription menulinkbutton">Salades de fruits</a>
                </li>
                <li class="menuitemcentered">
                    <a href="#saladeacidule" class="plus">Acidulés</a>
                </li>
                <li class="menuitemcentered">
                    <a href="#saladedouce" class="plus">Doux</a>
                </li>
                <li class="menuitemcentered">
                    <a href="#saladeexotic" class="plus">Exotique</a>
                </li>
            </ul>
        </div> 
    </div>
</section>

<br/><br/>

<section id="sectionsalades">
    <h2 class="title">Nos Salades de fruits</h2>
    
    <div id="saladedouce" class="product">
        <img src="saladedouce1.png" alt="Salade de fruits">
        <p class="textpresentation">Poire mûre<br/> Banane<br/> Pomme douce</p>
        <span class="prix">6.50€</span>
    </div>
    <br/>
    <div id="saladeacidule" class="product">
        <img src="saladeacidulé1.png" alt="Salade de fruits">
        <p class="textpresentation">Pamplemousse rose<br/> Orange, Kiwi<br/> Pomme verte</p>
        <span class="prix">7.90€</span>
    </div>
    <br/>
    <div id="saladeexotic" class="product">
        <img src="saladeexo1.png" alt="Salade de fruits">
        <p class="textpresentation">Mangue bien mûre<br/> Ananas Victoria<br/> Fruit de la Passion<br/> morceaux de Papaye</p>
        <span class="prix">8.50€</span>
    </div>
</section>

<br/><br/>

<section id="sectionsmoothies">
    <h2 class="title">Nos smoothies</h2>

    <div id="smoothieacidule">
        <div class="product">
            <img src="ssacidulé1.png" alt="Smoothie">
            <p class="textpresentation">Orange<br/> Kiwi<br/> Citron vert</p>
            <span class="prix">5.90€</span>
        </div>
        <div class="product">
            <img src="ssacidulé2.png" alt="Smoothie">
            <p class="textpresentation">Framboise<br/> Pamplemousse rose<br/> Pomme verte</p>
            <span class="prix">6.20€</span>
        </div>
        <div class="product">
            <img src="ssacidulé3.png" alt="Smoothie">
            <p class="textpresentation"> Ananas<br/> Passion<br/> Gingembre frais</p>
            <span class="prix">6.50€</span>
        </div>
    </div>

    <br/>

    <div id="smoothiedoux">
        <div class="product">
            <img src="ssdoux1.png" alt="Smoothie">
            <p class="textpresentation"> Banane<br/> Fraise<br/> Lait d'amande</p>
            <span class="prix">5.50€</span>
        </div>
        <div class="product">
            <img src="ssdoux2.png" alt="Smoothie">
            <p class="textpresentation">Poire<br/> Datte<br/> Une touche de vanille</p>
            <span class="prix">5.50€</span>
        </div>
        <div class="product">
            <img src="ssdoux3.png" alt="Smoothie">
            <p class="textpresentation">Myrtille<br/> Banane<br/> Lait d'avoine</p>
            <span class="prix">5.80€</span>
        </div>
    </div>

    <br/>

    <div id="smoothieexotic">
        <div class="product">
            <img src="ssexo1.png" alt="Smoothie">
            <p class="textpresentation">Ananas<br/> Papaye<br/> Jus de citron vert</p>
            <span class="prix">6.90€</span>
        </div>
        <div class="product">
            <img src="ssexo2.png" alt="Smoothie">
            <p class="textpresentation">Goyave<br/> Pitaya (fruit du dragon)<br/> Menthe</p>
            <span class="prix">7.20€</span>
        </div>
        <div class="product">
            <img src="ssexo3.png" alt="Smoothie">
            <p class="textpresentation"> Mangue<br/> Coco (lait ou eau de coco)<br/> Passion</p>
            <span class="prix">7.20€</span>
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
