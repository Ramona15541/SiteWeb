<?php
if (isset($_SESSION['id_user'])) {
    
    $liste_utilisateurs = json_decode(file_get_contents('../data/utilisateur.json'), true);
    
    foreach ($liste_utilisateurs as $utilisateur) {
        
        if ($utilisateur['id_user'] == $_SESSION['id_user']) {
            
            if (isset($utilisateur['statut']) && $utilisateur['statut'] === 'bloque') {
                session_destroy(); // On détruit sa session courante
                header('Location: connexion.php?erreur=compte_bloque'); // On le vire vers la connexion
                exit();
            }
        }
    }
}