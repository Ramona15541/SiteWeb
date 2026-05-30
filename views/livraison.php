<?php 
include('../includes/header.php'); 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'livreur') {
    header('Location: connexion.php');
    exit();
}

$id_livreur = $_SESSION['user_id'];

$commandes = json_decode(file_get_contents('../data/commandes.json'), true) ?? [];
$utilisateurs = json_decode(file_get_contents('../data/utilisateur.json'), true) ?? [];

function ClientInfo($id, $users) {
    foreach ($users as $u) {
        if ($u['id_user'] == $id) return $u;
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SunSip : Livraisons</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body class="bodydeliveryperson">

<header class="headerdeliveryperson">
    <a href="accueil.php" class="backlink">⬅ Retour</a>
    <h2>Mes livraisons en cours</h2>
</header>

<main class="containermobile">
    <?php 
    $a_des_livraisons = false;
    foreach ($commandes as $commande): 
        if (isset($commande['id_livreur']) && $commande['id_livreur'] == $id_livreur && $commande['statut_commande'] !== 'livree'): 
            $a_des_livraisons = true;
            $client = ClientInfo($commande['id_user'], $utilisateurs);
    ?>
        <section class="carddelivery" id="carte-<?= $commande['id_commande']; ?>" style="margin-bottom: 20px; transition: all 0.4s ease;">
            <div class="clientinfo">
                <h1 class="nameclient"><?php echo $client['prenom'] . " " . $client['nom']; ?></h1>
                <p>Commande #<?php echo $commande['id_commande']; ?></p>
                <?php if (!empty($client['telephone'])): ?>
                    <a href="tel:<?php echo $client['telephone']; ?>" class="btntel">📞 Appeler le client</a>
                <?php endif; ?>
            </div>
            
            <hr class="separatordeliveryperson">
            
            <div class="detailbloc">
                <h3>Adresse de livraison :</h3>
                <p class="adresstext"><?php echo $commande['adresse']; ?></p>
                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($commande['adresse']); ?>" target="_blank" class="btnmaps">
                    Ouvrir dans Maps / Waze
                </a>
            </div>

            <div class="detailbloc">
                <h3>Info d'accès</h3>
                <div class="grilleaccess">
                    <div class="itemaccess"><strong>Étage :</strong> <?php echo $client['etage'] ?? 'N/A'; ?></div>
                    <div class="itemaccess"><strong>Code :</strong> <?php echo $client['code_interphone'] ?? 'N/A'; ?></div>
                </div>
            </div>

            <div class="detailbloc">
                <h3>Instructions</h3>
                <p class="commdeliveryperson"><?php echo $client['instructions'] ?? 'Aucune instruction particulière.'; ?></p>
            </div>

            <form onsubmit="validerLivraison(event, '<?php echo $commande['id_commande']; ?>')">
                <button type="submit" class="btnvalidatedelivery">Marquer comme LIVRÉ</button>
            </form>
        </section>
    <?php 
        endif; 
    endforeach; 
    ?>

    <p id="msg-vide" style="text-align: center; margin-top: 50px; display: <?= !$a_des_livraisons ? 'block' : 'none' ?>;">
         Aucune livraison à effectuer pour le moment !
    </p>
</main>

<footer>
    <div class="footersimple">
        <p>SunSip © 2026 - Espace Livreur </p>
    </div>
</footer>

<script>
function validerLivraison(event, idCommande) {
    event.preventDefault();

    const formData = new FormData();
    formData.append('id_commande', idCommande);
    formData.append('nouveau_statut', 'livree');

    fetch('../bin/update_commande.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.statut === 'ok') {
            const carte = document.getElementById('carte-' + idCommande);
            if (carte) {
                carte.style.opacity = '0';
                carte.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    carte.remove();
                    
                    const cartesRestantes = document.querySelectorAll('.carddelivery');
                    if (cartesRestantes.length === 0) {
                        document.getElementById('msg-vide').style.display = 'block';
                    }
                }, 400);
            }
        } else {
            alert('Erreur lors de la mise à jour : ' + (data.message || 'Inconnue'));
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur de connexion au serveur.');
    });
}
</script>

</body>
</html>