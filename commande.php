<?php 
include('../includes/header.php'); 

$commandes = json_decode(file_get_contents('../data/commandes.json'), true) ?? [];
$users = json_decode(file_get_contents('../data/utilisateur.json'), true) ?? [];
$produits = json_decode(file_get_contents('../data/plat.json'), true) ?? [];

$livreurs = [];
if ($users) {
    foreach ($users as $user) {
        if (isset($user['role']) && $user['role'] == 'livreur') { 
            $livreurs[] = $user; 
        }
    }
}

function getName($id, $list) {
    if (empty($list) || empty($id)) {
        return "Inconnu";
    }
    foreach ($list as $u) {
        if ($u['id_user'] == $id) {
            return $u['prenom'] . " " . $u['nom'];
        }
    }
    return "Utilisateur introuvable";
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
    if (empty($liste)) {
        return "Articles non trouvés";
    } else {
        return implode(", ", $liste);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>SunSip - Interface Restaurateur</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body class="body_restaurateur">

<header class="headersun">
    <h1 class="titlepink">Gestion des Commandes</h1>
</header>

<main class="dashboardorders">
    
    <section class="columnorderprep">
        <h2 class="titleprep"> À préparer / En cours</h2>
        
        <?php foreach ($commandes as $commande): ?>
            <?php if (isset($commande['statut_commande']) && $commande['statut_commande'] !== 'livree' && $commande['statut_commande'] !== 'en_route'): ?>
                
                <div class="ordercard" id="carte-<?= $commande['id_commande'] ?>">
                    <div class="orderheader">
                        <span class="idorder">#<?= $commande['id_commande'] ?></span>
                        <span class="hour">Reçue à <?= isset($commande['date_heure']) ? explode(' ', $commande['date_heure'])[1] : '--:--' ?></span>
                    </div>

                    <div class="order-content" style="background: #fff5f5; padding: 10px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #ff6b6b;">
                        <p style="color: #ff6b6b; font-weight: bold; margin-bottom: 5px; font-size: 0.9em;"> COMMANDE :</p>
                        <p style="font-size: 0.95em; color: #333;">
                            <?php 
                                $items = $commande['id_plats'] ?? $commande['id_menus'] ?? [];
                                echo getDetailsCommande($items, $produits); 
                            ?>
                        </p>
                    </div>

                    <p><strong>Client :</strong> <?= getName($commande['id_user'] ?? null, $users) ?></p>
                    <p><strong>Adresse :</strong> <?= $commande['adresse'] ?? 'Non spécifiée' ?></p>

                    <hr>
                    
                    <div class="actions-demo">
                        <label>Statut :</label>
                        <select class="select-statut">
                            <option value="a_preparer" <?= ($commande['statut_commande'] === 'a_preparer') ? 'selected' : '' ?>>À préparer</option>
                            <option value="en_preparation" <?= ($commande['statut_commande'] === 'en_preparation') ? 'selected' : '' ?>>En préparation</option>
                            <option value="en_route" <?= ($commande['statut_commande'] === 'en_route') ? 'selected' : '' ?>>Prête (Envoyer en livraison)</option>
                        </select>

                        <br><br>

                        <label>Livreur :</label>
                        <select class="select-livreur">
                            <option value="">-- Choisir --</option>
                            <?php foreach ($livreurs as $l): ?>
                                <option value="<?= $l['id_user'] ?>" <?= (isset($commande['id_livreur']) && $commande['id_livreur'] == $l['id_user']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($l['prenom'] . " " . $l['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="button" class="btnactionprep" style="margin-top:10px;" onclick="enregistrerCommande('<?= $commande['id_commande'] ?>')">Enregistrer</button>
                    </div>
                </div>

            <?php endif; ?>
        <?php endforeach; ?>
    </section>

    <section class="columnorderdel">
        <h2 class="titledel"> En livraison</h2>
        <?php foreach ($commandes as $commande): ?>
            <?php if (isset($commande['statut_commande']) && $commande['statut_commande'] === 'en_route'): ?>
                <div class="ordercard ontheway">
                    <div class="orderheader">
                        <span class="idorder">#<?= $commande['id_commande'] ?></span>
                    </div>
                    <p><strong>Client :</strong> <?= getName($commande['id_user'] ?? null, $users) ?></p>
                    <p><strong>Livreur :</strong> <?= isset($commande['id_livreur']) ? getName($commande['id_livreur'], $users) : 'Non assigné' ?></p>
                    <span class="badgedelivery">Livraison en cours...</span>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>

</main>

<script src="restaurateur.js"></script>
</body>
</html>