<?php
session_start();

if (empty($_SESSION['panier'])) {
    header('Location: presentation.php');
    exit();
}

$fichier_commandes = '../data/commandes.json';
$commandes = file_exists($fichier_commandes) ? json_decode(file_get_contents($fichier_commandes), true) : [];

$id_plats = [];
$id_menus = [];
$nombre_total_articles = 0;

foreach ($_SESSION['panier'] as $cle => $quantite) {
    $parts = explode('_', $cle);
    $type = $parts[0];
    $id = (int)$parts[1];
    
    $nombre_total_articles += $quantite;

    for ($i = 0; $i < $quantite; $i++) {
        if ($type === 'plat') {
            $id_plats[] = $id;
        } else {
            $id_menus[] = $id;
        }
    }
}

$total_de_base = $_SESSION['total_general'] ?? 0;
$message_reduction = "";

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'vip' && $nombre_total_articles >= 2) {
        $total_de_base = $total_de_base - 5.00;
        $message_reduction = "✨ Offre VIP Appliquée : Un smoothie gratuit déduit du total ! ✨";
    }
    elseif ($_SESSION['role'] === 'premium') {
        $reduction = $total_de_base * 0.10;
        $total_de_base = $total_de_base - $reduction;
        $message_reduction = "💎 Avantage Premium Appliqué : 10% de réduction immédiate ! 💎";
    }
}

$montant = number_format($total_de_base, 2, '.', '');

$nouvel_id = 1;
if (!empty($commandes)) {
    $derniere_commande = end($commandes);
    $nouvel_id = ($derniere_commande['id_commande'] ?? 0) + 1;
}

$nouvelle_commande = [
    "id_commande" => $nouvel_id,
    "id_user" => $_SESSION['user_id'] ?? 0,
    "id_plats" => $id_plats,
    "id_menus" => $id_menus,
    "id_livreur" => null,
    "adresse" => $_SESSION['user_adresse'] ?? "A emporter",
    "statut_paiement" => "en_attente",
    "statut_commande" => "en_attente",
    "date_heure" => date("Y-m-d H:i"),
    "montant_paye" => $montant 
];

$commandes[] = $nouvelle_commande;
file_put_contents($fichier_commandes, json_encode($commandes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
$_SESSION['derniere_commande'] = $nouvel_id;

require('getapikey.php');

$mon_groupe = "MI-3_H";
$url_retour = "http://localhost:8080/views/retour_paiment.php";
$transaction = substr(uniqid('SUN'), 0, 15);
$api_key = getAPIKey($mon_groupe);

$control = md5(
    $api_key . "#" .
    $transaction . "#" .
    $montant . "#" .
    $mon_groupe . "#" .
    $url_retour . "#"
);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SunSip - Paiement</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>

<section class="formsection">
    <div class="formcontainer">
        <h2 class="titlepink">Finaliser ma commande</h2>
        
        <?php if (!empty($message_reduction)): ?>
            <p class="texte-reduction-panier"><?php echo $message_reduction; ?></p>
        <?php endif; ?>

        <p>Montant total : <strong class="prix-total-accentue"><?php echo $montant; ?> €</strong></p>
        <p>Vous allez être redirigé vers notre interface de paiement sécurisée.</p>

        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
            <input type="hidden" name="transaction" value="<?php echo $transaction; ?>">
            <input type="hidden" name="montant" value="<?php echo $montant; ?>">
            <input type="hidden" name="vendeur" value="<?php echo $mon_groupe; ?>">
            <input type="hidden" name="retour" value="<?php echo $url_retour; ?>">
            <input type="hidden" name="control" value="<?php echo $control; ?>">
            <button type="submit" class="btninscription">Payer sur CYBank</button>
        </form>

        <br>
        <a href="panier.php" class="btnview">⬅ Retour au panier</a>
    </div>
</section>

<?php include('../includes/footer.php'); ?>

</body>
</html>