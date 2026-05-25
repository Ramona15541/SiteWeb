<?php
session_start();

$fichier_commandes = '../data/commandes.json';
$commandes = file_exists($fichier_commandes) ? json_decode(file_get_contents($fichier_commandes), true) : [];
$produits = json_decode(file_get_contents('../data/plat.json'), true) ?? [];

$id_client = $_SESSION['user_id'] ?? $_SESSION['id_user'] ?? null;

$commandes_client = [];
if ($id_client) {
    foreach ($commandes as $cmd) {
        if ((int)($cmd['id_user'] ?? 0) === (int)$id_client) {
            $commandes_client[] = $cmd;
        }
    }
}

function getDetailsCommande($ids_items, $catalogue) {
    if (empty($ids_items) || empty($catalogue)) {
        return "Aucun article";
    }
    $liste = [];
    $ids = is_array($ids_items) ? $ids_items : [$ids_items];
    foreach ($ids as $id) {
        foreach ($catalogue as $p) {
            if ($p['id'] == $id) {
                $liste[] = $p['nom'];
            }
        }
    }
    return empty($liste) ? "Articles non trouvés" : implode(", ", $liste);
}

function getStatutBadge($statut) {
    switch ($statut) {
        case 'en_attente': return ['label' => 'En attente de paiement', 'color' => 'gray'];
        case 'a_preparer': return ['label' => 'En attente de préparation', 'color' => 'orange'];
        case 'en_preparation': return ['label' => 'En préparation', 'color' => 'blue'];
        case 'en_route': return ['label' => 'En cours de livraison', 'color' => 'purple'];
        case 'livree': return ['label' => 'Livrée', 'color' => 'green'];
        default: return ['label' => 'Inconnu', 'color' => 'black'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SunSip - Mon Profil</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>

<main class="formsection">
    <div class="formcontainer" style="max-width: 800px;">
        <h2 class="titlepink">Mes anciennes commandes</h2>

        <?php if (empty($commandes_client)): ?>
            <p>Vous n'avez pas encore passé de commande.</p>
        <?php else: ?>
            <div class="liste-commandes" style="margin-top: 20px; text-align: left;">
                <?php foreach (array_reverse($commandes_client) as $commande): 
                    $id_cmd = $commande['id_commande'] ?? 0;
                    $date_cmd = $commande['date_heure'] ?? '--/--/---- --:--';
                    $statut_brut = $commande['statut_commande'] ?? 'en_attente';
                    $badge = getStatutBadge($statut_brut);
                ?>
                    <div class="ordercard" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #fff;">
                        <div class="orderheader" style="display: flex; justify-content: space-between; font-weight: bold;">
                            <span class="idorder" style="color: #ff6b6b;">Commande #<?= $id_cmd ?></span>
                            <span class="hour" style="font-size: 0.9em; color: #666;">Date : <?= htmlspecialchars($date_cmd) ?></span>
                        </div>
                        
                        <div style="margin: 10px 0;">
                            <strong>Statut : </strong>
                            <span style="color: <?= $badge['color'] ?>; font-weight: bold;"><?= $badge['label'] ?></span>
                        </div>

                        <div class="order-content" style="background: #f9f9f9; padding: 10px; border-radius: 5px; margin: 10px 0;">
                            <strong>Articles :</strong>
                            <p style="margin: 5px 0 0 0; color: #555;">
                                <?php 
                                    $items = $commande['id_plats'] ?? $commande['id_menus'] ?? [];
                                    echo getDetailsCommande($items, $produits); 
                                ?>
                            </p>
                        </div>

                        <div class="note-section" style="margin-top: 10px; font-size: 0.9em; color: #888;">
                            <?php if ($statut_brut === 'livree'): ?>
                                <span style="color: green; font-weight: bold;">✓ Commande reçue ! Merci pour votre confiance.</span>
                            <?php else: ?>
                                <span>Note disponible après livraison</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include('../includes/footer.php'); ?>

</body>
</html>