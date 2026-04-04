<?php
session_start();

$email_saisi = "";


if (isset($_POST['mail'])) {
    $email_saisi = $_POST['mail'];
}


$login_saisi = "";
if (isset($_POST['login'])) {
    $login_saisi = $_POST['login'];
}

$password_saisi = "";
if (isset($_POST['password'])) {
    $password_saisi = $_POST['password'];
}


$fichier = '../data/utilisateur.json';
$contenu = file_get_contents($fichier);
$users = json_decode($contenu, true);

$utilisateur_trouve = null;


foreach ($users as $user) {
    
    if (!empty($email_saisi) && $user['email'] === $email_saisi) {
        $utilisateur_trouve = $user;
        break; 
    }

    else if (!empty($login_saisi) && $user['login'] === $login_saisi) {
        $utilisateur_trouve = $user;
        break; 
    }
}



if ($utilisateur_trouve) {
   
    if ($password_saisi === $utilisateur_trouve['password']){
       
        $_SESSION['user_id'] = $utilisateur_trouve['id_user'];
        $_SESSION['nom'] = $utilisateur_trouve['nom'];
        $_SESSION['prenom'] = $utilisateur_trouve['prenom'];
        $_SESSION['role'] = $utilisateur_trouve['role'];

        
        if ($utilisateur_trouve['role'] === 'admin') {
            header('Location: ../views/admin.php');
        } elseif ($utilisateur_trouve['role'] === 'livreur') {
            header('Location: ../views/livraison.php');
        } elseif ($utilisateur_trouve['role'] === 'restaurateur') {
            header('Location: ../views/commande.php');
        } else {

            header('Location: ../views/presentation.php?connexion=ok');
        }
        exit();

    } else {
        
        header('Location: ../views/connexion.php?erreur=password');
        exit();
    }
} else {

    header('Location: ../views/connexion.php?erreur=introuvable');
    exit();
}
?>
