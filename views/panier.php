<?php
session_start();

$fichier_plats = '../data/plat.json'; 
$fichier_menus = '../data/menu.json';

$plats = file_exists($fichier_plats) ? json_decode(file_get_contents($fichier_plats), true) : [];
$menus = file_exists($fichier_menus) ? json_decode(file_get_contents($fichier_menus), true) : [];

$panier_details = [];
$total_general = 0;

if (!empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $cle => $quantite) {

        $parts = explode('_', $cle);
        if (count($parts) < 2) continue; 

        list($type, $id) = $parts;
        
        $source = ($type === 'plat') ? $plats : $menus;
        $produit_trouve = null;

        if (!empty($source)) {
            foreach ($source as $item) {
                $cle_id = ($type === 'plat') ? 'id' : 'id_menu';
                if ($type === 'plat' && !isset($item[$cle_id]) && isset($item['id_plat'])) {
                    $cle_id = 'id_plat';
                }
                if (isset($item[$cle_id]) && (string)$item[$cle_id] === (string)$id) {
                    $produit_trouve = $item;
                    break;
                }
            }
        }

        if ($produit_trouve) {
            $prix_unitaire = isset($produit_trouve['prix']) ? (float)$produit_trouve['prix'] : 0;
            $sous_total = $prix_unitaire * $quantite;
            $total_general += $sous_total;
            
            $panier_details[] = [
                'cle' => $cle,
                'nom' => $produit_trouve['nom'] ?? 'Produit sans nom',
                'prix' => $prix_unitaire,
                'quantite' => $quantite,
                'sous_total' => $sous_total,
                'image' => ($type === 'plat') ? $id . ".png" : "menu_icon.png"
            ];
        }
    }
}
$_SESSION['total_general'] = $total_general;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier : SunSip</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <section class="formsectionn">
        <div class="formcontainerr">
            <h2 class="titlepink">Votre Panier </h2>

            <?php if (empty($panier_details)): ?>
                <p>Votre panier est vide. <a href="presentation.php">Découvrir nos gourmandises</a></p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($panier_details as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nom']) ?></td>
                            <td><?= number_format($item['prix'], 2) ?> €</td>
                            <td><?= $item['quantite'] ?></td>
                            <td><?= number_format($item['sous_total'], 2) ?> €</td>
                            <td>
                                <a href="supprimer_panier.php?cle=<?= $item['cle'] ?>">❌</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div style="text-align: right; margin-top: 30px;">
                    <h3>Total Final : <span style="color:#ff6b6b;"><?= number_format($total_general, 2) ?> €</span></h3>
                    <br>
                    <a href="presentation.php" class="btnview">Continuer</a>
                    <a href="page_paiement.php" class="btninscription">Payer </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
