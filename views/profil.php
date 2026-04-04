<?php 
include('../includes/header.php'); 

if (isset($_GET['id'])) {
    $id_a_afficher = $_GET['id'];
} else {
    $id_a_afficher = $_SESSION['user_id'] ?? null;
}

// 2. RÉCUPÉRATION de l'utilisateur actuel dans le JSON
$users_data = json_decode(file_get_contents('../data/utilisateur.json'), true);
$currentUser = null;
foreach ($users_data as $u) {
    if ($u['id_user'] == $id_a_afficher) {
        $currentUser = $u;
        break;
    }
}

// 3. RÉCUPÉRATION des commandes de cet utilisateur
$orders_data = json_decode(file_get_contents('../data/commandes.json'), true);
$my_orders = [];
foreach ($orders_data as $o) {
    if ($o['id_user'] == $id_a_afficher) {
        $my_orders[] = $o;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>SunSip - Profil de <?php echo $currentUser['prenom']; ?></title>
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
            <?php foreach ($my_orders as $commande): ?>
                <div class="orderitem">
                    <p><strong>Commande #<?php echo $commande['id_commande']; ?></strong></p>
                    <p>Date : <?php echo $commande['Date et heure']; ?></p>
                    <p>Lieu : <?php echo $commande['adresse / sur place']; ?></p>
                    <p>Statut : 
                        <span style="color: <?php echo ($commande['Statut de la commande'] === 'livré') ? 'green' : 'orange'; ?>;">
                            <?php echo $commande['Statut de la commande']; ?>
                        </span>
                    </p>
                    <button class="btninscription">Voir détails</button>
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