<?php
header('Content-Type: application/json');
session_start();

// 1. Vérification de sécurité admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['statut' => 'erreur', 'message' => 'Action non autorisée.']);
    exit();
}

// 2. Récupération des données envoyées par le JavaScript
$id_recu = isset($_POST['id_utilisateur']) ? (string)$_POST['id_utilisateur'] : null;
$action = $_POST['action'] ?? '';

if (!$id_recu) {
    echo json_encode(['statut' => 'erreur', 'message' => 'ID utilisateur manquant.']);
    exit();
}

$chemin_fichier = '../data/utilisateur.json';
$liste_utilisateurs = json_decode(file_get_contents($chemin_fichier), true);
$trouve = false;

// 3. Traitement de l'action par index
foreach ($liste_utilisateurs as $index => $utilisateur) {
    if ((string)$utilisateur['id_user'] === $id_recu) {
        
        if ($action === 'bloquer') {
            $liste_utilisateurs[$index]['statut'] = 'bloque';
            $trouve = true;
        }
        elseif ($action === 'vip') {
            $liste_utilisateurs[$index]['statut'] = 'vip';
            $trouve = true;
        }
        elseif ($action === 'premium') {
            $liste_utilisateurs[$index]['statut'] = 'premium';
            $trouve = true;
        }
        break; // Utilisateur trouvé, on arrête la boucle
    }
}

// 4. Sauvegarde définitive dans le fichier JSON
if ($trouve) {
    $json_force = json_encode($liste_utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
    if (file_put_contents($chemin_fichier, $json_force) !== false) {
        echo json_encode(['statut' => 'ok']);
    } else {
        echo json_encode(['statut' => 'erreur', 'message' => 'Impossible d\'écrire dans le fichier JSON.']);
    }
} else {
    echo json_encode(['statut' => 'erreur', 'message' => 'Utilisateur introuvable.']);
}
exit();