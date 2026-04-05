<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_commande'])) {
    $idc = $_POST['id_commande'];
    $nouveau_statut = $_POST['nouveau_statut'];

    // 1. Lire le fichier
    $file = '../data/commandes.json';
    $commandes = json_decode(file_get_contents($file), true);

    // 2. Modifier le statut dans le tableau
    foreach ($commandes as &$commande) {
        if ($commande['id_commande'] == $idc) {
            $commande['statut_commande'] = $nouveau_statut;
            break; 
        }
    }

    // 3. Sauvegarder les changements
    file_put_contents($file, json_encode($commandes, JSON_PRETTY_PRINT));

    // 4. Retourner sur la page de livraison
    header('Location: ../views/livraison.php?success=1');
    exit();
}