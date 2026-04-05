<?php
session_start();

if (isset($_GET['cle'])) {
    $cle = $_GET['cle'];

    if (isset($_SESSION['panier'][$cle])) {
        // Si plus de 1, on baisse juste la quantité
        if ($_SESSION['panier'][$cle] > 1) {
            $_SESSION['panier'][$cle]--;
        } else {
            // Sinon on supprime la ligne
            unset($_SESSION['panier'][$cle]);
        }
    }
}

header('Location: panier.php');
exit();
?>