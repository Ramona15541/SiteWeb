<?php 
include('../includes/header.php'); 

if (isset($_GET['id'])) {
    $id_a_afficher = $_GET['id'];
} else {
    $id_a_afficher = $_SESSION['user_id'] ?? null;
}

$users_data = json_decode(file_get_contents('../data/utilisateur.json'), true);
$currentUser = null;
foreach ($users_data as $u) {
    if ($u['id_user'] == $id_a_afficher) {
        $currentUser = $u;
        break;
    }
}

$orders_data = json_decode(file_get_contents('../data/commandes.json'), true);
$my_orders = [];
if ($orders_data) {
    foreach ($orders_data as $o) {
        if ($o['id_user'] == $id_a_afficher) {
            $my_orders[] = $o;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>SunSip - profil de <?php echo $currentUser['prenom']; ?></title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<section class="formsectionn">
    <div class="formcontainerr">
        <h2 class="titlepink">Mon profil</h2>
        <div class="formgroupcolumn">
            <p><strong>Nom :</strong> <?php echo $currentUser['nom']; ?> <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
            <p><strong>Prénom :</strong> <?php echo $currentUser['prenom']; ?> <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
            <p><strong>Email :</strong> <?php echo $currentUser['email']; ?> <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
            <p><strong>Téléphone :</strong> <?php echo $currentUser['telephone'] ?? 'Non renseigné'; ?> <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
            <p><strong>Adresse :</strong> <?php echo ($currentUser['adresse'] ?? 'Non renseignée') . ", " . ($currentUser['ville'] ?? ''); ?> <i class="fas fa-pencil-alt editicon" title="Modifier"></i></p>
        </div>
    </div>
</section>

<section class="formsectionn">
    <div class="formcontainerr">
        <h2 class="titlepink">Mon compte fidélité</h2>
        <div class="formgroupcolumn">
            <p><strong>Points actuels :</strong> <?php echo $currentUser['points'] ?? '0'; ?> points</p>
            <p class="loyaltyemessage">
                Encore quelques smoothies pour un cadeau ! 
            </p>
        </div>
    </div>
</section>

<section class="formsectionn">
    <div class="formcontainerr">
        <h2 class="titlepink">Mes anciennes commandes</h2>
        
        <?php if (empty($my_orders)): ?>
            <p>Vous n'avez pas encore passé de commande.</p>
        <?php else: ?>
            <?php 
            
            $orders_reversed = array_reverse($my_orders); 
            foreach ($orders_reversed as $commande): 
            ?>
                <div class="orderitem" style="border-bottom: 1px solid #eee; padding: 15px 0; margin-bottom: 10px;">
                    <p><strong>Commande #<?php echo $commande['id_commande']; ?></strong></p>
                    <p>Date : <?php echo $commande['Date et heure']; ?></p>
                    <p>Statut : 
                        <span style="color: <?php echo ($commande['Statut de la commande'] === 'livré') ? 'green' : 'orange'; ?>;">
                            <?php echo $commande['Statut de la commande']; ?>
                        </span>
                    </p>
                    
                    <div style="margin-top: 10px;">
                        <?php 
                        
                        if (isset($commande['notation'])): 
                            
                            $valeur_note = $commande['notation']['note_produit'] ?? $commande['notation']['note'] ?? 0;
                        ?>
                            
                            <div style="background: #fff5f7; padding: 10px; border-radius: 8px; border: 1px solid #ffdae0; display: inline-block; min-width: 200px;">
                                <p style="margin: 0; color: #ffb7c5; font-weight: bold; font-size: 0.9em;">Votre avis :</p>
                                <p style="font-size: 1.2em; margin: 5px 0;">
                                    <?php 
                                    
                                    for($i = 0; $i < $valeur_note; $i++) {
                                        echo "⭐";
                                    } 
                                    ?>
                                </p>
                                <?php if(!empty($commande['notation']['commentaire'])): ?>
                                    <p style="font-style: italic; font-size: 0.85em; margin: 0; color: #666;">
                                        "<?php echo htmlspecialchars($commande['notation']['commentaire']); ?>"
                                    </p>
                                <?php endif; ?>
                            </div>

                        <?php 
                        
                        elseif ($commande['Statut de la commande'] === 'livré'): 
                        ?>
                            <a href="notation.php?id=<?php echo $commande['id_commande']; ?>" class="btninscription">
                                Noter cette commande ⭐
                            </a>
                            
                        <?php else: ?>
                            
                            <p style="color: #999; font-size: 0.8em;"><i>Note disponible après livraison</i></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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
