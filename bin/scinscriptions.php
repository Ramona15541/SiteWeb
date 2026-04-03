
//lecture les données du formulaire
<?php
// Lecture les données du formulaire
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$password = $_POST['password'];
$adresse = $_POST['adresse'];
$code_postal = $_POST['code_postal'];
$ville = $_POST['ville'];

if (isset($_POST['etage'])) {
    $etage = $_POST['etage'];
} else {
    $etage = '';
}

if (isset($_POST['code_interphone'])) {
    $code_interphone = $_POST['code_interphone'];
} else {
    $code_interphone = '';
}

if (isset($_POST['instructions'])) {
    $instructions = $_POST['instructions'];
} else {
    $instructions = '';
}
// 2. On lit le fichier users.json
$fichier = '../data/utilisateur.json';
$contenu = file_get_contents($fichier);
$users = json_decode($contenu, true);

// 3. On vérifie que l'email n'existe pas déjà
foreach ($users as $user) {
    if ($user['email'] === $email) {
        // Email déjà utilisé → on redirige avec une erreur
        header('Location: ../views/inscription.php?erreur=email_existe');
        exit();
    }
}

// 4. On crée le nouvel utilisateur
$nouvel_id = count($users) + 1;

$nouvel_user = [
    "id_user" => $nouvel_id,
    "login" => $prenom . "_" . $nom,
    "password" => password_hash($password, PASSWORD_DEFAULT), // mot de passe hashé !
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

// 5. On ajoute l'utilisateur à la liste
$users[] = $nouvel_user;

// 6. On réécrit le fichier JSON
file_put_contents($fichier, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// 7. On redirige vers la connexion
header('Location: ../views/connexion.php?inscription=succes');
exit();
?>
