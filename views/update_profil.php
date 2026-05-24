<?php
session_start();
$response = array('success' => false, 'message' => 'Une erreur est survenue');
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $adresse = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';
    $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';

    if (!empty($nom)&& !empty($adresse) && !empty($telephone)) {
        $response['success'] = true;
        $response['message'] ='Profil mis à jour avec succès !';
    }else {
        $response['message'] = 'Veuillez remplir tous les champs obligatoires';
    }
}


header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
