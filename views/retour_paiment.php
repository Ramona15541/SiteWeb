<?php
session_start();
require('getapikey.php');

$status = $_GET['status'] ?? 'declined';
$montant = $_GET['montant'] ?? 0;
$transaction = $_GET['transaction'] ?? '';
$vendeur = $_GET['vendeur'] ?? '';
$control_recu = $_GET['control'] ?? '';


$mon_groupe = "MI-3_H";
$api_key = getAPIKey($mon_groupe);
$control_attendu = md5(
    $api_key . "#" .
    $transaction . "#" .
    $montant . "#" .
    $vendeur . "#" .
    $status . "#"
);

if ($control_recu !== $control_attendu) {
    die("Erreur : contrôle de sécurité invalide !");
}

if ($status === 'accepted') {

    $json_path = '../data/paiement.json';
    $paiements = file_exists($json_path) ? json_decode(file_get_contents($json_path), true) : [];

    $paiements[] = [
        "id_paiement" => count($paiements) + 1,
        "id_commande" => $_SESSION['derniere_commande'] ?? 0,
        "id_user" => $_SESSION['user_id'] ?? 0,
        "montant" => (float)$montant,
        "methode" => "CB",
        "details_bancaires" => [
            "nom_carte" => "Client SunSip",
            "numero_masque" => "**** **** **** 9000",
            "banque" => "CYBank"
        ],
        "statut_transaction" => "succes",
        "date_transaction" => date("d/m/Y H:i")
    ];
    file_put_contents($json_path, json_encode($paiements, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // 2. Mettre à jour le statut dans commandes.json
    $json_commandes = '../data/commandes.json';
    $commandes = file_exists($json_commandes) ? json_decode(file_get_contents($json_commandes), true) : [];

    foreach ($commandes as &$commande) {
        if ($commande['id_commande'] === ($_SESSION['derniere_commande'] ?? 0)) {
            $commande['statut_paiement'] = 'paye';
            $commande['statut'] = 'en_preparation';
            break;
        }
    }
    file_put_contents($json_commandes, json_encode($commandes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // 3. Vider le panier
    unset($_SESSION['panier']);
    unset($_SESSION['total_general']);

    $msg = "🎉 Paiement réussi ! Bonne dégustation !";
    $couleur = "green";
} else {
    $msg = " Le paiement a été refusé par la banque.";
    $couleur = "red";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SunSip - Retour paiement</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>

<section class="formsection">
    <div class="formcontainer" style="text-align:center;">
        <h2 style="color:<?php echo $couleur; ?>;"><?php echo $msg; ?></h2>
        <p>Montant : <strong><?php echo $montant; ?> €</strong></p>
        <p>Transaction : <strong><?php echo $transaction; ?></strong></p>
        <br>
        <a href="acceuil.php" class="btninscription">Retour à l'accueil</a>
        <a href="profil.php" class="btnview">Voir mes commandes</a>
    </div>
</section>

<?php include('../includes/footer.php'); ?>

</body>
</html>
