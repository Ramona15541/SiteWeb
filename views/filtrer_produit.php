<?php 
 
header('Content-Type: application/json'); 
 
/* Chargement des produits */ 
 
$fichier_plats = '../data/plat.json'; 
 
if (!file_exists($fichier_plats)) { 
 
   echo json_encode([ 
       'erreur' => 'Fichier plat.json introuvable' 
   ]); 
 
   exit(); 
} 
 
$plats = json_decode( 
   file_get_contents($fichier_plats), 
   true 
); 
 
if (!is_array($plats)) { 
 
   echo json_encode([ 
       'erreur' => 'Erreur lecture JSON' 
   ]); 
 
   exit(); 
} 
 
/* Récupération filtres */ 
 
$categorie = $_GET['categorie'] ?? ''; 
 
$vegan = $_GET['vegan'] ?? ''; 
 
$halal = $_GET['halal'] ?? ''; 
 
$sans_gluten = $_GET['sans_gluten'] ?? ''; 
 
$tri = $_GET['tri'] ?? ''; 
 
$recherche = strtolower( 
   trim($_GET['recherche'] ?? '') 
); 
 
/* Filtrage produits */ 
 
$plats_filtres = array_filter( 
 
   $plats, 
 
   function ($plat) use ( 
       $categorie, 
       $vegan, 
       $halal, 
       $sans_gluten, 
       $recherche 
   ) { 
 
       /* Catégorie */ 
 
       if ( 
           !empty($categorie) 
           && 
           $plat['categorie'] !== $categorie 
       ) { 
 
           return false; 
       } 
 
       /* Vegan */ 
 
       if ( 
           $vegan == '1' 
           && 
           !$plat['vegan'] 
       ) { 
 
           return false; 
       } 
 
       /* Halal */ 
 
       if ( 
           $halal == '1' 
           && 
           !$plat['halal'] 
       ) { 
 
           return false; 
       } 
 
       /* Sans gluten */ 
 
       if ( 
           $sans_gluten == '1' 
           && 
           !$plat['sans_gluten'] 
       ) { 
 
           return false; 
       } 
 
       /* Recherche texte */ 
 
       if (!empty($recherche)) { 
 
           $nom = 
               strtolower($plat['nom']); 
 
           $description = 
               strtolower($plat['description']); 
 
           if ( 
               strpos($nom, $recherche) === false 
               && 
               strpos($description, $recherche) === false 
           ) { 
 
               return false; 
           } 
       } 
 
       return true; 
   } 
); 
 
/* Tri */ 
 
if ($tri === 'prix_croissant') { 
 
   usort($plats_filtres, function ($a, $b) { 
 
       return $a['prix'] <=> $b['prix']; 
   }); 
} 
 
elseif ($tri === 'prix_decroissant') { 
 
   usort($plats_filtres, function ($a, $b) { 
 
       return $b['prix'] <=> $a['prix']; 
   }); 
} 
 
elseif ($tri === 'popularite') { 
 
   usort($plats_filtres, function ($a, $b) { 
 
       return $b['popularite'] 
           <=> 
           $a['popularite']; 
   }); 
} 
 
/* Réindexation tableau */ 
 
$plats_filtres = array_values($plats_filtres); 
 
/* Retour JSON */ 
 
echo json_encode( 
 
   $plats_filtres, 
 
   JSON_PRETTY_PRINT | 
   JSON_UNESCAPED_UNICODE 
); 
 
?> 