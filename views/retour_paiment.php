<?php
session_start();
require('getapikey.php');

$statut = $_GET['status'] ?? 'declined';
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
    $statut . "#"
);

if ($control_recu !== $control_attendu) {
    die("Erreur : contrôle de sécurité invalide !");
}

if ($statut === 'accepted') {

    $chemin_paiement = '../data/paiement.json';
    $paiements = file_exists($chemin_paiement) ? json_decode(file_get_contents($chemin_paiement), true) : [];

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
    file_put_contents($chemin_paiement, json_encode($paiements, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    $chemin_commandes = '../data/commandes.json';
    $commandes = file_exists($chemin_commandes) ? json_decode(file_get_contents($chemin_commandes), true) : [];
    $id_cible = $_SESSION['derniere_commande'] ?? 0;

    foreach ($commandes as &$commande) {
        if ((int)$commande['id_commande'] === (int)$id_cible) {
            $commande['statut_paiement'] = 'paye';
            $commande['statut_commande'] = 'a_preparer';
            break;
        }
    }
    file_put_contents($chemin_commandes, json_encode($commandes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    unset($_SESSION['panier']);
    unset($_SESSION['total_general']);

    $message_affichage = "Paiement réussi ! Bonne dégustation !";
    $classe_couleur = "retour-paiement-succes";
} else {
    $message_affichage = "Le paiement a été refusé par la banque.";
    $classe_couleur = "retour-paiement-echec";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SunSip - Retour paiement</title>
    <link class="lien-style" rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>

<section class="formsection">
    <div class="formcontainer conteneur-retour-paiement">
        <h2 class="<?php echo $classe_couleur; ?>"><?php echo $message_affichage; ?></h2>
        <p>Montant : <strong><?php echo $montant; ?> €</strong></p>
        <p>Transaction : <strong><?php echo $transaction; ?></strong></p>
        <br>
        <a href="accueil.php" class="btninscription">Retour à l'accueil</a>
        <a href="profil.php" class="btnview">Voir mes commandes</a>
    </div>
</section>

<?php include('../includes/footer.php'); ?>

</body>
</html>