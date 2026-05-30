<?php 
 
session_start(); 
 

if (!isset($_SESSION['panier'])) { 
 
   header('Location: panier.php'); 
   exit(); 
} 
 
 
if (!isset($_GET['cle'])) { 
 
   header('Location: panier.php'); 
   exit(); 
} 
 
$cle = $_GET['cle']; 
 

 
if ( 
   isset($_SESSION['statut_commande']) && 
   $_SESSION['statut_commande'] === 'preparation' 
) { 
 
   $_SESSION['erreur_panier'] = 
       "Impossible de modifier une commande en préparation."; 
 
   header('Location: panier.php'); 
   exit(); 
} 
 

 
if (!isset($_SESSION['ancien_total'])) { 
 
   $_SESSION['ancien_total'] = 
       $_SESSION['total_general'] ?? 0; 
} 
 

 
if (isset($_SESSION['panier'][$cle])) { 
 
  
 
   if ($_SESSION['panier'][$cle] > 1) { 
 
       $_SESSION['panier'][$cle]--; 
 
       $_SESSION['message_panier'] = 
           "Quantité diminuée."; 
 
   } 
 
  
 
   else { 
 
       unset($_SESSION['panier'][$cle]); 
 
       $_SESSION['message_panier'] = 
           "Produit supprimé du panier."; 
   } 
} 
 

 
if (empty($_SESSION['panier'])) { 
 
   unset($_SESSION['panier']); 
} 
 
/* Retour panier */ 
 
header('Location: panier.php'); 
 
exit();