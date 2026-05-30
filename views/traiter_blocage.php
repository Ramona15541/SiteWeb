<?php

header('Content-Type: application/json');

session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['statut' => 'erreur', 'message' => 'Non autorisé']);
    exit();
}


$id_recu = $_POST['id_cherche'];
$chemin_fichier = '../data/utilisateur.json';
$donnees_json = file_get_contents($chemin_fichier);
$liste_utilisateurs = json_decode($donnees_json, true);

$trouve = false;

//parcourt  liste pour trouver le bon utilisateur
foreach ($liste_utilisateurs as &$utilisateur) {
    if ($utilisateur['id_user'] == $id_recu) {
        // On lui ajoute ou modifie sa ligne dictionnaire 'statut'
        $utilisateur['statut'] = 'bloque';
        $trouve = true;
        break;
    }
}

if ($trouve) {
    file_put_contents($chemin_fichier, json_encode($liste_utilisateurs, JSON_PRETTY_PRINT));
    // On répond avec un dictionnaire de succès
    echo json_encode(['statut' => 'ok']);
} else {
    echo json_encode(['statut' => 'erreur', 'message' => 'Utilisateur introuvable']);
}
exit();