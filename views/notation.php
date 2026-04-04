<?php include('../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SunSip - Notation</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>



<section class="formsection">
    <div class="formcontainer">
        <h2 class="titlepink">Noter ma commande</h2>
        <p class="ratingorder">Commande #101</p>
        <form action="#">
            <div class="grade">
                <label class="gradestyle">Qualité des produits :</label>
                <select class="formselect">
                    <option>⭐⭐⭐⭐⭐</option>
                    <option>⭐⭐⭐⭐</option>
                    <option>⭐⭐⭐</option>
                    <option>⭐⭐</option>
                    <option>⭐</option>
                </select>
            </div>
            <div class="grade">
                <label class="gradestyle">Livraison :</label>
                <select class="formselect">
                    <option>⭐⭐⭐⭐⭐</option>
                    <option>⭐⭐⭐⭐</option>
                    <option>⭐⭐⭐</option>
                    <option>⭐⭐</option>
                    <option>⭐</option>
                </select>
            </div>
            <div class="comment">
                <textarea class="smalltext" placeholder="Votre avis nous intéresse..."></textarea>
            </div>
            <button type="submit" class="btninscription">Envoyer l'avis</button>
        </form>
    </div>
</section>

<?php include('../includes/footer.php'); ?>

</body>
</html>
