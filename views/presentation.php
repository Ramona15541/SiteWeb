<?php
session_start();
include('../includes/header.php');

$fichier_plats = '../data/plat.json';
$fichier_menus = '../data/menu.json';

$plats = file_exists($fichier_plats) ? json_decode(file_get_contents($fichier_plats), true) : [];
$menus = file_exists($fichier_menus) ? json_decode(file_get_contents($fichier_menus), true) : [];

$panier_details = [];
$total_general = 0;
$ancien_total = isset($_SESSION['ancien_total']) ? (float)$_SESSION['ancien_total'] : 0.0;

if (!empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $cle => $quantite) {
        $parts = explode('_', $cle);
        if (count($parts) < 2) {
            continue;
        }

        list($type, $id) = $parts;
        $source = ($type === 'plat') ? $plats : $menus;
        $produit_trouve = null;

        foreach ($source as $item) {
            $cle_id = ($type === 'plat') ? 'id' : 'id_menu';
            if (isset($item[$cle_id]) && $item[$cle_id] == $id) {
                $produit_trouve = $item;
                break;
            }
        }

        if ($produit_trouve) {
            $prix_unitaire = (float)$produit_trouve['prix'];
            $sous_total = $prix_unitaire * $quantite;
            $total_general += $sous_total;

            $panier_details[] = [
                'cle' => $cle,
                'id' => $id,
                'type' => $type,
                'nom' => $produit_trouve['nom'],
                'prix' => $prix_unitaire,
                'quantite' => $quantite,
                'sous_total' => $sous_total,
                'popularite' => isset($produit_trouve['popularite']) ? (int)$produit_trouve['popularite'] : 0,
                'image' => ($type === 'plat') ? $id . ".png" : "menu_icon.jpg"
            ];
        }
    }
}

$_SESSION['total_general'] = $total_general;
$difference = $total_general - $ancien_total;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier - SunSip</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body class="tablecloth">

<section class="formsectionn">
    <div class="formcontainerr">
        <h2 class="titlepink">Votre Panier </h2>

        <?php if (empty($panier_details)): ?>
            <p class="panier-vide-texte">Votre panier est vide.</p>
            <div class="panier-vide-alignement">
                <a href="presentation.php" class="btninscription">Découvrir nos gourmandises</a>
            </div>
        <?php else: ?>
            <table class="tableau-panier">
                <thead>
                    <tr class="tableau-panier-entete">
                        <th class="tableau-panier-cellule-produit">Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($panier_details as $item): ?>
                        <tr class="tableau-panier-ligne">
                            <td class="tableau-panier-detail-produit">
                                <strong><?php echo htmlspecialchars($item['nom']); ?></strong>
                                <?php if ($item['popularite'] >= 90): ?>
                                    <br><span class="badge-populaire">⭐ Populaire</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo number_format($item['prix'], 2); ?> €</td>
                            <td><?php echo (int)$item['quantite']; ?></td>
                            <td><?php echo number_format($item['sous_total'], 2); ?> €</td>
                            <td>
                                <a href="ajouter_panier.php?id=<?php echo $item['id']; ?>&type=<?php echo $item['type']; ?>" class="bouton-action-panier-espace">➕</a>
                                <a href="supprimer_panier.php?id=<?php echo $item['id']; ?>&type=<?php echo $item['type']; ?>&action=diminuer" class="bouton-action-panier-espace">➖</a>
                                <a href="supprimer_panier.php?id=<?php echo $item['id']; ?>&type=<?php echo $item['type']; ?>&action=supprimer">❌</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="panier-facturation-bloc">
                <h3>Total Final : <span class="panier-total-prix"><?php echo number_format($total_general, 2); ?> €</span></h3>
                
                <?php if ($ancien_total > 0): ?>
                    <div class="panier-ajustement-encadre">
                        <p>Ancien total : <?php echo number_format($ancien_total, 2); ?> €</p>
                        <?php if ($difference > 0): ?>
                            <p class="panier-difference-supplement">Supplément à payer : +<?php echo number_format($difference, 2); ?> €</p>
                        <?php elseif ($difference < 0): ?>
                            <p class="panier-difference-reduction">Réduction obtenue : <?php echo number_format(abs($difference), 2); ?> €</p>
                        <?php else: ?>
                            <p>Aucun changement de prix.</p>
                        <?php endif; ?>
                    </div>
                    <br>
                <?php endif; ?>

                <br>
                <a href="presentation.php" class="btnview bouton-continuer-panier">Continuer</a>
                <a href="page_paiement.php" class="btninscription">Payer </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="panier-suggestions-zone">
    <h2 class="title panier-suggestions-titre">Suggestions populaires : les stralettes du moment ! </h2>
    <div class="panier-suggestions-grille">
        <?php 
        $compteur = 0;
        foreach ($plats as $p) {
            if (isset($p['popularite']) && $p['popularite'] >= 85 && $compteur < 3) {
                $cle_verif = 'plat_' . $p['id'];
                if (!isset($_SESSION['panier'][$cle_verif])) {
                    $compteur++;
                    ?>
                    <div class="product carte-suggestion-panier">
                        <img src="../images/<?php echo $p['id']; ?>.png" class="image-suggestion-panier" >
                        <h4><?php echo htmlspecialchars($p['nom']); ?></h4>
                        <p><?php echo number_format($p['prix'], 2); ?> €</p>
                        <a href="ajouter_panier.php?id=<?php echo $p['id']; ?>&type=plat" class="btninscription bouton-suggestion-panier">Ajouter </a>
                    </div>
                    <?php
                }
            }
        }
        if ($compteur === 0) {
            echo "<p class='panier-suggestions-vide'>Aucune suggestion pour le moment.</p>";
        }
        ?>
    </div>
</section>

</body>
</html>