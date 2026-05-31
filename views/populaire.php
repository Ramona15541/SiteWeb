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
