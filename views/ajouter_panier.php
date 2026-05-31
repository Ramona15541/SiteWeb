<?php 
 
session_start(); 
 
 
 
if ( 
   !isset($_GET['id']) || 
   !isset($_GET['type']) 
) { 
 
   header('Location: presentation.php'); 
   exit(); 
} 
 
$id = (int) $_GET['id']; 
 
$type = $_GET['type']; 
 

 
if ( 
   $type !== 'plat' && 
   $type !== 'menu' 
) { 
 
   header('Location: presentation.php'); 
   exit(); 
} 
if ( 
   isset($_SESSION['statut_commande']) && 
   $_SESSION['statut_commande'] === 'preparation' 
) { 
 
   $_SESSION['erreur_panier'] = 
       "Commande déjà en préparation."; 
 
   header('Location: panier.php'); 
   exit(); 
} 
 
 
 
if (!isset($_SESSION['panier'])) { 
 
   $_SESSION['panier'] = []; 
} 
 
 
$cle = $type . "_" . $id; 
 

 
if (isset($_SESSION['panier'][$cle])) { 
 
   $_SESSION['panier'][$cle]++; 
 
} else { 
 
   $_SESSION['panier'][$cle] = 1; 
} 
 

 
if (!isset($_SESSION['ancien_total'])) { 
 
   $_SESSION['ancien_total'] = 
       $_SESSION['total_general'] ?? 0; 
} 
 
 
$_SESSION['message_panier'] = 
   "Produit ajouté au panier."; 
 

 
if (isset($_SERVER['HTTP_REFERER'])) { 
 
   header('Location: ' . $_SERVER['HTTP_REFERER']); 
 
} else { 
 
   header('Location: presentation.php'); 
} 
 
exit();
