<?php
session_start();

if (!isset($_SESSION['user_id'])) { 
   header('Location: connexion.php'); 
   exit(); 
}
$id_commande = $_GET['id_commande'] ?? null;
if (!$id_commande) {
    die("Aucune commande spécifiée.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Noter ma commande</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <main class="formsection">
        <div class="formcontainer">
            <h2>Donnez votre avis sur la commande #<?= htmlspecialchars($id_commande) ?></h2>
            
            <form action="traiter_notation.php" method="POST">
                
                <input type="hidden" name="id_commande" value="<?= htmlspecialchars($id_commande) ?>">

                <p>
                    <label>Votre note (de 1 à 5) :</label><br>
                    <input type="number" name="note_produit" min="1" max="5" required>
                </p>

                <p>
                    <label>Votre commentaire :</label><br>
                    <textarea name="avis" rows="5" required></textarea>
                </p>

                <button type="submit">Envoyer mon avis ⭐</button>
            </form>
        </div>
    </main>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
