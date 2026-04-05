<?php
session_start();


if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = (int)$_GET['id'];
    $type = $_GET['type'];
    $cle = $type . "_" . $id;

    
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    
    if (isset($_SESSION['panier'][$cle])) {
        $_SESSION['panier'][$cle]++;
    } else {
        $_SESSION['panier'][$cle] = 1;
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();