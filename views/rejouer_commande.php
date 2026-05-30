<?php 
 
session_start(); 
 
/* Vérification connexion */ 
 
if (!isset($_SESSION['user_id'])) { 
 
   header('Location: connexion.php'); 
   exit(); 
} 
 
/* Vérification ID commande */ 
 
if (!isset($_GET['id_commande'])) { 
 
   die("Commande manquante."); 
} 
 
$id_commande = (int) $_GET['id_commande']; 
 
/* Chargement commandes */ 
 
$fichier_commandes = '../data/commande.json'; 
 
if (!file_exists($fichier_commandes)) { 
 
   die("Fichier commandes introuvable."); 
} 
 
$commandes = json_decode( 
   file_get_contents($fichier_commandes), 
   true 
); 
 
if (!is_array($commandes)) { 
 
   die("Erreur lecture commandes."); 
} 
 
/* Recherche ancienne commande */ 
 
$ancienne_commande = null; 
 
foreach ($commandes as $commande) { 
 
   if ( 
       $commande['id_commande'] 
           == $id_commande 
   ) { 
 
       $ancienne_commande = $commande; 
       break; 
   } 
} 
 
/* Vérification commande trouvée */ 
 
if (!$ancienne_commande) { 
 
   die("Commande introuvable."); 
} 
 
/* Vérification propriétaire */ 
 
if ( 
   $ancienne_commande['id_user'] 
   != $_SESSION['user_id'] 
) { 
 
   die("Accès interdit."); 
} 
 
/* Génération nouvel ID */ 
 
$nouvel_id = 1; 
 
if (!empty($commandes)) { 
 
   $ids = array_column( 
       $commandes, 
       'id_commande' 
   ); 
 
   $nouvel_id = max($ids) + 1; 
} 
 
/* Création nouvelle commande*/ 
 
$nouvelle_commande = [ 
 
   'id_commande' => $nouvel_id, 
 
   'id_user' => $_SESSION['user_id'], 
 
   'plats' => 
       $ancienne_commande['plats'] ?? [], 
 
   'menus' => 
       $ancienne_commande['menus'] ?? [], 
 
   'prix_total' => 
       $ancienne_commande['prix_total'] ?? 0, 
 
   'montant_deja_paye' => 0, 
 
   'supplement_a_payer' => 0, 
 
   'notation_envoyee' => false, 
 
   'id_livreur' => null, 
 
   'adresse' => 
       $ancienne_commande['adresse'] ?? '', 
 
   'statut_paiement' => 'en_attente', 
 
   'statut_commande' => 'en_attente', 
 
   'date_heure' => 
       date('Y-m-d H:i:s') 
]; 
 
/* Ajout commande */ 
 
$commandes[] = $nouvelle_commande; 
 
/* Sauvegarde JSON */ 
 
$resultat = file_put_contents( 
 
   $fichier_commandes, 
 
   json_encode( 
       $commandes, 
       JSON_PRETTY_PRINT | 
       JSON_UNESCAPED_UNICODE 
   ) 
); 
 
if ($resultat === false) { 
 
   die("Erreur sauvegarde commande."); 
} 
 
/* Message succès */ 
 
$_SESSION['success_commande'] = 
   "Commande rejouée avec succès."; 
 
/* Retour profil */ 
 
header('Location: profil.php?commande=rejouee'); 
 
exit(); 
 
?>