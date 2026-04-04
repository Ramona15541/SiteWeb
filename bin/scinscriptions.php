<?php
// On démarre la session au cas où on en aurait besoin
session_start();

// 1. Récupération des données (On utilise ?? pour éviter les notices)
$prenom = $_POST['prenom'] ?? '';
$nom = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$password = $_POST['password'] ?? '';
$adresse = $_POST['adresse'] ?? '';
$code_postal = $_POST['code_postal'] ?? '';
$ville = $_POST['ville'] ?? '';
$etage = $_POST['etage'] ?? '';
$code_interphone = $_POST['code_interphone'] ?? '';
$instructions = $_POST['instructions'] ?? '';

// 2. Lecture du fichier
$fichier = '../data/utilisateur.json';
if (!file_exists($fichier)) {
    file_put_contents($fichier, json_encode([])); // Crée le fichier s'il n'existe pas
}
$users = json_decode(file_get_contents($fichier), true) ?? [];

// 3. Vérification email unique
foreach ($users as $user) {
    if ($user['email'] === $email) {
        header('Location: ../views/inscription.php?erreur=email_existe');
        exit();
    }
}

// 4. Création utilisateur
$nouvel_user = [
    "id_user" => count($users) + 1,
    "login" => $prenom . "_" . $nom,
    "password" => $password,
    "role" => "client",
    "nom" => $nom,
    "prenom" => $prenom,
    "email" => $email,
    "telephone" => $telephone,
    "adresse" => $adresse,
    "code_postal" => $code_postal,
    "ville" => $ville,
    "etage" => $etage,
    "code_interphone" => $code_interphone,
    "instructions" => $instructions,
    "date_inscription" => date('Y-m-d')
];

// 5. Enregistrement
$users[] = $nouvel_user;
file_put_contents($fichier, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: ../views/connexion.php?inscription=succes');
exit();