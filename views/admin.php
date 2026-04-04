<?php 

include '../includes/header.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}

$json = file_get_contents('../data/utilisateur.json');
$utilisateurs = json_decode($json, true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>SunSip - Administration</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body class="adminbody">

<header class="headersun">
    <h1 class="titlepink">Tableau de Bord Admin</h1>
</header>



<section class="admincontainer">
    <div class="admincard">
        <h2 class="titleblue">Gestion des Utilisateurs</h2>

        <div class="adminfilters">
            <button class="btnfilter active">Tous</button>
            <button class="btnfilter">Avec commandes</button>
            <button class="btnfilter">Sans commandes</button>
        </div>

        <table class="usertable">
    <thead>
        <tr>
            <th>Utilisateur</th>
            <th>Email</th>
            <th>Statut actuel</th>
            <th>Remise</th>
            <th>Actions de gestion</th> </tr>
    </thead>
    <tbody>
        <?php foreach ($utilisateurs as $user): ?>
            <tr>
                <td><strong><?php echo $user['nom'] . " " . $user['prenom']; ?></strong></td>
                <td><?php echo $user['email']; ?></td>
                
                <td>
                    <span class="badge <?php echo ($user['role'] === 'admin') ? 'admin-color' : 'user-color'; ?>">
                        <?php echo $user['role']; ?>
                    </span>
                </td>

                <td>0%</td> 

                <td>
                    <div class="admin-actions">
                        <select name="change_status">
                            <option value="">Modifier Statut...</option>
                            <option value="vip">Passer VIP</option>
                            <option value="premium">Passer Premium</option>
                        </select>
                        
                        <button class="btn-block" title="Bloquer le compte">🚫</button>
                        <a href="profil.php?id=<?php echo $user['id_user']; ?>" class="btnview">Voir Profil</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</section>

<footer>
    <p>Espace sécurisé - SunSip Admin</p>
</footer>

</body>
</html>
