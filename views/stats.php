<?php 
 
 
 
if ( 
   !isset($_SESSION['user_id']) 
   || 
   ( 
       $_SESSION['role'] !== 'admin' 
   )
) { 
   die("Accès interdit."); 
} 
 
 
$fichier_commandes = '../data/commandes.json'; 
 
if (!file_exists($fichier_commandes)) { 
 
   die("fichier commandes introuvable."); 
} 
 
$commandes = json_decode( 
   file_get_contents($fichier_commandes), 
   true 
); 
if (!is_array($commandes)) { 
 
   die("Erreur lecture commandes."); 
} 
 
$fichier_plats = '../data/plat.json'; 
$plats = []; 
 
if (file_exists($fichier_plats)) { 
 
   $plats = json_decode( 
       file_get_contents($fichier_plats), 
       true 
   ); 
} 
$noms_plats = []; 
foreach ($plats as $plat) { 
 
   $noms_plats[$plat['id']] = 
       $plat['nom']; 
} 
 
 
$stats_plats = []; 
$combinaisons = []; 
 
 
foreach ($commandes as $commande) { 
   if (empty($commande['plats'])) { 
       continue; 
   } 
   $ids_plats_commande = []; 
 
   foreach ($commande['plats'] as $plat_cmd) { 
       $id_plat = $plat_cmd['id_plat']; 
       $quantite = $plat_cmd['quantite']; 
       $ids_plats_commande[] = $id_plat; 
       if (!isset($stats_plats[$id_plat])) { 
           $stats_plats[$id_plat] = 0; 
       } 
       $stats_plats[$id_plat] += $quantite; 
   } 
 
   $nb = count($ids_plats_commande); 
   for ($i = 0; $i < $nb; $i++) { 
       for ($j = $i + 1; $j < $nb; $j++) { 
 
           $a = $ids_plats_commande[$i]; 
 
           $b = $ids_plats_commande[$j]; 
 
 
           $pair = [$a, $b]; 
 
           sort($pair); 
 
           $cle = implode('-', $pair); 
           if (!isset($combinaisons[$cle])) { 
               $combinaisons[$cle] = 0; 
           } 
           $combinaisons[$cle]++; 
       } 
   } 
} 
 
arsort($stats_plats); 
arsort($combinaisons);
?> 

<!DOCTYPE html> 
<html lang="fr"> 
<head> 
   <meta charset="UTF-8"> 
 
   <title> 
       SunSip - Statistiques 
   </title> 
 
   <link rel="stylesheet" href="../style.css"> 
 
</head> 
 
<body> 
 
<section class="formsectionn"> 
   <div class="formcontainerr"> 
       <h2 class="titlepink"> 
           

 Statistiques SunSip 
       </h2> 
 
       <!-- TOP PRODUITS --> 
 
       <div> 
           <h3> 
               

 Produits les plus commandés 
           </h3> 
 
           <?php if (empty($stats_plats)): ?> 
 
               <p> 
                   Aucune statistique disponible. 
               </p> 
 
           <?php else: ?> 
 
               <table> 
 
                   <thead> 
 
                   <tr> 
 
                       <th> 
                           Produit 
                       </th> 
 
                       <th> 
                           Nombre de commandes 
                       </th> 
 
                   </tr> 
 
                   </thead> 
 
                   <tbody> 
 
                   <?php foreach ($stats_plats as $id_plat => $nombre): ?> 
 
                       <tr style=" 
                           border-bottom:1px solid #eee; 
                           text-align:center; 
                       "> 
 
                           <td style="padding:12px;"> 
 
                               <?php 
                               echo htmlspecialchars( 
                                   $noms_plats[$id_plat] 
                                   ?? 'Produit inconnu' 
                               ); 
                               ?> 
 
                           </td> 
 
                           <td> 
 
                               <strong> 
                                   <?php echo $nombre; ?> 
                               </strong> 
 
                           </td> 
 
                       </tr> 
 
                   <?php endforeach; ?> 
 
                   </tbody> 
 
               </table> 
 
           <?php endif; ?> 
 
       </div> 
 
 
       <div> 
 
           <h3>  Produits souvent achetés ensemble 
           </h3> 
 
           <?php if (empty($combinaisons)): ?> 
 
               <p> 
                   Pas assez de données. </p> 
 
           <?php else: ?> 
 
               <table> 
 
                   <thead> 
 
                   <tr> 
 
                       <th> 
                           Combinaison 
                       </th> 
 
                       <th> 
                           Nombre 
                       </th> 
 
                   </tr> 
 
                   </thead> 
 
                   <tbody> 
 
                   <?php 
 
                   $top_combinaisons = 
                       array_slice( 
                           $combinaisons, 
                           0, 
                           10, 
                           true 
                       ); 
 
                   ?> 
 
                   <?php foreach ($top_combinaisons as $cle => $nb): ?> 
 
                       <?php 
 
                       $ids = explode('-', $cle); 
 
                       $nom1 = 
                           $noms_plats[$ids[0]] 
                           ?? 'Produit'; 
 
                       $nom2 = 
                           $noms_plats[$ids[1]] 
                           ?? 'Produit'; 
 
                       ?> 
 
                       <tr> 
 
                           <td> 
 
                               <?php 
                               echo htmlspecialchars( 
                                   $nom1 
                                   . " + " 
                                   . $nom2 
                               ); 
                               ?> 
 
                           </td> 
 
                           <td> 
 
                               <strong> 
                                   <?php echo $nb; ?> 
                               </strong> 
 
                           </td> 
 
                       </tr> 
 
                   <?php endforeach; ?> 
 
                   </tbody> 
 
               </table> 
 
           <?php endif; ?> 
 
       </div> 
 
   </div> 
 
</section> 
 
</body> 
 
</html>
