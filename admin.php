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
                    <th>Actions de gestion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $user): ?>
                    <?php 
                    $statut = $user['statut'] ?? 'normal'; 
                    ?>
                    <tr id="ligne-<?php echo $user['id_user']; ?>" style="<?php echo ($statut === 'bloque') ? 'opacity: 0.4;' : ''; ?>">
                        <td><strong><?php echo htmlspecialchars($user['nom'] . " " . $user['prenom']); ?></strong></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        
                        <td>
                            <span class="badge <?php echo ($user['role'] === 'admin') ? 'admin-color' : 'user-color'; ?>">
                                <?php echo $user['role']; ?>
                            </span>
                            <?php if ($statut === 'bloque'): ?>
                                <span style="color: red; font-weight: bold;">(Bloqué)</span>
                            <?php elseif ($statut === 'vip'): ?>
                                <span style="color: #27ae60; font-weight: bold;">⭐ VIP</span>
                            <?php elseif ($statut === 'premium'): ?>
                                <span style="color: #2980b9; font-weight: bold;">💎 Premium</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php 
                            if ($statut === 'vip') echo "Smoothie offert";
                            elseif ($statut === 'premium') echo "10%";
                            else echo "0%";
                            ?>
                        </td> 

                        <td>
                            <div class="admin-actions">
                                <button class="btn-vip" title="Passer VIP" onclick="passerVip('<?php echo $user['id_user']; ?>')">⭐ VIP</button>
                                
                                <button class="btn-premium" title="Passer Premium" onclick="passerPremium('<?php echo $user['id_user']; ?>')">💎 Premium</button>
                                
                                <button class="btn-block" title="Bloquer le compte" onclick="envoyerBlocage('<?php echo $user['id_user']; ?>')">🚫</button>
                                
                                <a href="profil.php?id=<?php echo $user['id_user']; ?>" class="btnview">Voir Profil</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<footer>
    <p>Espace sécurisé - SunSip Admin</p>
</footer>

<script src="admin.js"></script>
</body>
</html>