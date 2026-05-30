<?php
session_start();

// On dit au navigateur qu'on va lui répondre en JSON
header('Content-Type: application/json; charset=utf-8');

/* 1. Vérifications de sécurité */
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['statut' => 'erreur', 'message' => 'Utilisateur non connecté.']);
    exit();
}

if ($_SESSION['role'] !== 'restaurateur' && $_SESSION['role'] !== 'admin') {
    echo json_encode(['statut' => 'erreur', 'message' => 'Accès interdit.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['statut' => 'erreur', 'message' => 'Méthode non autorisée.']);
    exit();
}

if (!isset($_POST['id_commande']) || !isset($_POST['nouveau_statut'])) {
    echo json_encode(['statut' => 'erreur', 'message' => 'Données manquantes.']);
    exit();
}

$id_commande = (int)$_POST['id_commande'];
$nouveau_statut = trim($_POST['nouveau_statut']);
$id_livreur = !empty($_POST['id_livreur']) ? (int)$_POST['id_livreur'] : null;

/* 2. Validation du statut */
$statuts_valides = ['en_attente', 'confirmee', 'preparation', 'prete', 'en_route', 'livree', 'annulee'];
if (!in_array($nouveau_statut, $statuts_valides)) {
    echo json_encode(['statut' => 'erreur', 'message' => 'Statut de commande invalide.']);
    exit();
}

/* 3. Chargement du fichier JSON */
$fichier_commandes = '../data/commande.json';
if (!file_exists($fichier_commandes)) {
    echo json_encode(['statut' => 'erreur', 'message' => 'Base de données des commandes introuvable.']);
    exit();
}

$commandes = json_decode(file_get_contents($fichier_commandes), true);
if (!is_array($commandes)) {
    echo json_encode(['statut' => 'erreur', 'message' => 'Erreur lors de la lecture des commandes.']);
    exit();
}

/* 4. Modification de la commande */
$commande_trouvee = false;
foreach ($commandes as &$commande) {
    if ($commande['id_commande'] == $id_commande) {
        $commande_trouvee = true;
        
        $commande['statut_commande'] = $nouveau_statut;
        
        if ($id_livreur !== null) {
            $commande['id_livreur'] = $id_livreur;
        }
        
        $commande['date_modification'] = date('Y-m-d H:i:s');
        
        if ($nouveau_statut === 'livree') {
            $commande['date_livraison'] = date('Y-m-d H:i:s');
        }
        break;
    }
}
unset($commande);

if (!$commande_trouvee) {
    echo json_encode(['statut' => 'erreur', 'message' => 'Commande introuvable.']);
    exit();
}

/* 5. Sauvegarde */
$resultat = file_put_contents($fichier_commandes, json_encode($commandes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

if ($resultat === false) {
    echo json_encode(['statut' => 'erreur', 'message' => 'Impossible d\'écrire dans le fichier de sauvegarde.']);
    exit();
}

/* 6. Réponse de succès lue par ton JS */
$_SESSION['success_commande'] = "Commande mise à jour avec succès."; // Optionnel, pour garder le message flash
echo json_encode(['statut' => 'ok', 'message' => 'Mise à jour réussie.']);
exit();