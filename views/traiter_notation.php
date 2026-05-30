<?php 
 
session_start(); 
 
 
if (!isset($_SESSION['user_id'])) { 
 
   header('Location: connexion.php'); 
   exit(); 
} 
 
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
 
   header('Location: profil.php'); 
   exit(); 
} 
 
 
if ( 
   !isset($_POST['id_commande']) || 
   !isset($_POST['note_produit']) 
) { 
 
   die("Données manquantes."); 
} 
 
$id_commande = (int) $_POST['id_commande']; 
 
$note = (int) $_POST['note_produit']; 
 
$avis = trim($_POST['avis'] ?? ''); 
 
 
if ($note < 1 || $note > 5) { 
 
   die("Note invalide."); 
} 
 
 
$fichier_commandes = '../data/commandes.json'; 
 
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
 
 
$commande_trouvee = null; 
 
foreach ($commandes as $commande) { 
 
   if ($commande['id_commande'] == $id_commande) { 
 
       $commande_trouvee = $commande; 
       break; 
   } 
} 
 
 
if (!$commande_trouvee) { 
 
   die("Commande introuvable."); 
} 
 
 
if ( 
   $commande_trouvee['id_user'] 
   != $_SESSION['user_id'] 
) { 
 
   die("Accès interdit."); 
} 
 
 
if ( 
   !isset($commande_trouvee['statut_commande']) || 
   $commande_trouvee['statut_commande'] !== 'livree' 
) { 
 
   die("Impossible de noter une commande non livrée."); 
} 
 
 
$fichier_notations = '../data/notations.json'; 
 
 
if (!file_exists($fichier_notations)) { 
 
   file_put_contents( 
       $fichier_notations, 
       json_encode([], JSON_PRETTY_PRINT) 
   ); 
} 
 
$notations = json_decode( 
   file_get_contents($fichier_notations), 
   true 
); 
 
if (!is_array($notations)) { 
 
   $notations = []; 
} 
 
 
foreach ($notations as $notation) { 
 
   if ( 
       $notation['id_commande'] 
           == $id_commande 
       && 
       $notation['id_user'] 
           == $_SESSION['user_id'] 
   ) { 
 
       die("Cette commande a déjà été notée."); 
   } 
} 
 
 
$nouvel_id = 1; 
 
if (!empty($notations)) { 
 
   $ids = array_column( 
       $notations, 
       'id_notation' 
   ); 
 
   $nouvel_id = max($ids) + 1; 
} 
 
 
$nouvelle_notation = [ 
 
   'id_notation' => $nouvel_id, 
 
   'id_commande' => $id_commande, 
 
   'id_user' => $_SESSION['user_id'], 
 
   'note' => $note, 
 
   'commentaire' => htmlspecialchars($avis), 
 
   'date_notation' => date('Y-m-d H:i:s') 
]; 
 
 
$notations[] = $nouvelle_notation; 
 
 
$resultat = file_put_contents( 
 
   $fichier_notations, 
 
   json_encode( 
       $notations, 
       JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE 
   ) 
); 
 
if ($resultat === false) { 
 
   die("Erreur sauvegarde notation."); 
} 
 
 
foreach ($commandes as &$commande) { 
 
   if ($commande['id_commande'] == $id_commande) { 
 
       $commande['notation_envoyee'] = true; 
 
       break; 
   } 
} 
 
unset($commande); 
 
file_put_contents( 
   $fichier_commandes, 
   json_encode( 
       $commandes, 
       JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE 
   ) 
); 
 
header('Location: profil.php?notation=success'); 
exit(); 
?>