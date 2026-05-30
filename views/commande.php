<?php
session_start();
include('../includes/header.php'); 

$fichier_commandes = '../data/commande.json';
$fichier_users = '../data/utilisateurs.json';
$fichier_plats = '../data/plat.json';

$commandes = file_exists($fichier_commandes) ? json_decode(file_get_contents($fichier_commandes), true) : [];
$users = file_exists($fichier_users) ? json_decode(file_get_contents($fichier_users), true) : [];
$produits = file_exists($fichier_plats) ? json_decode(file_get_contents($fichier_plats), true) : [];

$livreurs = [];
if ($users) {
    foreach ($users as $user) {
        if (isset($user['role']) && $user['role'] === 'livreur') { 
            $livreurs[] = $user; 
        }
    }
}

function getName($id, $list) {
    if (empty($list) || empty($id)) return "Inconnu";
    foreach ($list as $u) {
        if (isset($u['id_user']) && $u['id_user'] == $id) {
            return htmlspecialchars($u['prenom'] . " " . $u['nom']);
        }
    }
    return "Introuvable";
}

// Fonction corrigée pour lire le JSON optimal (avec "plats" et "quantite")
function getDetailsCommande($commande, $catalogue) {
    $liste = [];
    if (!empty($commande['plats'])) {
        foreach ($commande['plats'] as $item_plat) {
            foreach ($catalogue as $p) {
                if ($p['id'] == $item_plat['id_plat']) {
                    $liste[] = htmlspecialchars($p['nom']) . " (x" . $item_plat['quantite'] . ")";
                }
            }
        }
    }
    if (!empty($commande['menus'])) {
        foreach ($commande['menus'] as $item_menu) {
            $liste[] = "Formule Menu (x" . $item_menu['quantite'] . ")";
        }
    }
    return empty($liste) ? "Aucun article" : implode(", ", $liste);
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

<main class="dashboardorders" style="display:flex; gap:20px; padding:20px; max-width:1200px; margin:0 auto;">
    
    <section class="columnorderprep" style="flex:1; background:#fff; padding:20px; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 class="titleprep" style="color:var(--rose); border-bottom:2px solid var(--rose); padding-bottom:10px;">À préparer / En cours</h2>
        <br>
        <?php foreach ($commandes as $commande): ?>
            <?php if (isset($commande['statut_commande']) && $commande['statut_commande'] !== 'livree' && $commande['statut_commande'] !== 'en_route'): ?>
                
                <div class="ordercard" id="carte-<?= $commande['id_commande'] ?>" style="border:1px solid #ddd; padding:15px; border-radius:10px; margin-bottom:15px; background:#fafafa;">
                    <div class="orderheader" style="display:flex; justify-content:space-between; font-weight:bold;">
                        <span class="idorder" style="color:var(--rose);">#<?= $commande['id_commande'] ?></span>
                        <span class="hour" style="font-size:0.9em; color:#666;">Reçue à <?= isset($commande['date_heure']) ? explode(' ', $commande['date_heure'])[1] : '--:--' ?></span>
                    </div>

                    <div class="order-content" style="background: #fff5f5; padding: 10px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #ff6b6b;">
                        <p style="color: #ff6b6b; font-weight: bold; margin-bottom: 5px; font-size: 0.9em;">COMMANDE :</p>
                        <p style="font-size: 0.95em; color: #333;"><?= getDetailsCommande($commande, $produits); ?></p>
                    </div>

                    <p><strong>Client :</strong> <?= getName($commande['id_user'] ?? null, $users) ?></p>
                    <p><strong>Adresse :</strong> <?= htmlspecialchars($commande['adresse'] ?? 'Non spécifiée') ?></p>
                    <hr style="border:0; border-top:1px solid #eee; margin:10px 0;">
                    
                    <div class="actions-demo">
                        <label>Statut :</label>
                        <select class="select-statut" id="statut-<?= $commande['id_commande'] ?>" style="padding:5px; border-radius:5px;">
                            <option value="en_attente" <?= ($commande['statut_commande'] === 'en_attente') ? 'selected' : '' ?>>En attente</option>
                            <option value="confirmee" <?= ($commande['statut_commande'] === 'confirmee') ? 'selected' : '' ?>>Confirmée</option>
                            <option value="preparation" <?= ($commande['statut_commande'] === 'preparation') ? 'selected' : '' ?>>En préparation</option>
                            <option value="prete" <?= ($commande['statut_commande'] === 'prete') ? 'selected' : '' ?>>Prête</option>
                            <option value="en_route" <?= ($commande['statut_commande'] === 'en_route') ? 'selected' : '' ?>>Prête (Envoyer en livraison)</option>
                        </select>

                        <br><br>

                        <label>Livreur :</label>
                        <select class="select-livreur" id="livreur-<?= $commande['id_commande'] ?>" style="padding:5px; border-radius:5px;">
                            <option value="">-- Choisir --</option>
                            <?php foreach ($livreurs as $l): ?>
                                <option value="<?= $l['id_user'] ?>" <?= (isset($commande['id_livreur']) && $commande['id_livreur'] == $l['id_user']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($l['prenom'] . " " . $l['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <br>
                        <button type="button" class="btnactionprep" style="margin-top:10px; background:var(--rose); color:white; border:0; padding:8px 15px; border-radius:20px; cursor:pointer;" onclick="enregistrerCommande('<?= $commande['id_commande'] ?>')">Enregistrer</button>
                    </div>
                </div>

            <?php endif; ?>
        <?php endforeach; ?>
    </section>

    <section class="columnorderdel" style="flex:1; background:#fff; padding:20px; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 class="titledel" style="color:#2ec4b6; border-bottom:2px solid #2ec4b6; padding-bottom:10px;">En livraison</h2>
        <br>
        <?php foreach ($commandes as $commande): ?>
            <?php if (isset($commande['statut_commande']) && $commande['statut_commande'] === 'en_route'): ?>
                <div class="ordercard ontheway" style="border:2px dashed #2ec4b6; padding:15px; border-radius:10px; margin-bottom:15px; background:#f0fdfa;">
                    <div class="orderheader">
                        <span class="idorder" style="color:#2ec4b6;">#<?= $commande['id_commande'] ?></span>
                    </div>
                    <p style="margin-top:10px;"><strong>Client :</strong> <?= getName($commande['id_user'] ?? null, $users) ?></p>
                    <p><strong>Livreur :</strong> <?= isset($commande['id_livreur']) ? getName($commande['id_livreur'], $users) : 'Non assigné' ?></p>
                    <br>
                    <span class="badgedelivery" style="background:#2ec4b6; color:white; padding:4px 8px; border-radius:5px; font-size:0.85em; font-weight:bold;">Livraison en cours...</span>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>

</main>

<script src="restaurateur.js"></script>
</body>
</html>