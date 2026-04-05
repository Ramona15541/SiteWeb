<?php 
session_start();
include('../includes/header.php'); 


if (!isset($_SESSION['user_id'])) {
    header('Location: ../bin/login.php');
    exit();
}


$id_cmd = $_GET['id'] ?? null;
?>

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
        
     
        <p class="ratingorder">Commande #<?php echo htmlspecialchars($id_cmd); ?></p>
        
        <form action="traiter_notation.php" method="POST">
          
            <input type="hidden" name="id_commande" value="<?php echo htmlspecialchars($id_cmd); ?>">

            
            <div class="grade">
                <label class="gradestyle">Qualité des produits :</label>
                <select name="note_produit" class="formselect">
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>
            </div>

            
            <div class="comment">
                <textarea name="avis" class="smalltext" placeholder="Votre avis nous intéresse..."></textarea>
            </div>

           
            <button type="submit" class="btninscription">Envoyer l'avis</button>
        </form>
        
        <p style="margin-top: 15px;">
            <a href="profil.php" style="text-decoration: none; color: #666; font-size: 0.8em;">Retour au profil</a>
        </p>
    </div>
</section>

<?php include('../includes/footer.php'); ?>

</body>
</html>
