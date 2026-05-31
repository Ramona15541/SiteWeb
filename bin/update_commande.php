<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'livreur') {
    echo json_encode([
        'statut' => 'erreur',
        'message' => 'Accès interdit. Vous devez être connecté en tant que livreur.'
    ]);
    exit();
}

$id_commande = $_POST['id_commande'] ?? null;
$nouveau_statut = $_POST['nouveau_statut'] ?? null;

if (!$id_commande || !$nouveau_statut) {
    echo json_encode([
        'statut' => 'erreur',
        'message' => 'Données manquantes (ID commande ou statut).'
    ]);
    exit();
}

$chemin_commandes = '../data/commandes.json';

if (!file_exists($chemin_commandes)) {
    echo json_encode([
        'statut' => 'erreur',
        'message' => 'Le fichier des commandes est introuvable.'
    ]);
    exit();
}

$commandes = json_decode(file_get_contents($chemin_commandes), true) ?? [];
$commande_trouvee = false;

foreach ($commandes as &$commande) {
    if ((string)$commande['id_commande'] === (string)$id_commande) {
        
        if ((string)$commande['id_livreur'] !== (string)$_SESSION['user_id']) {
            echo json_encode([
                'statut' => 'erreur',
                'message' => 'Accès interdit. Cette livraison ne vous est pas assignée.'
            ]);
            exit();
        }

        $commande['statut_commande'] = $nouveau_statut;
        $commande_trouvee = true;
        break;
    }
}

if ($commande_trouvee) {
    file_put_contents($chemin_commandes, json_encode($commandes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo json_encode(['statut' => 'ok']);
} else {
    echo json_encode([
        'statut' => 'erreur',
        'message' => 'Commande introuvable dans la base de données.'
    ]);
}
exit();
