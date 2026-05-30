<?php
session_start();

$fichier_notations = '../data/notations.json';
$fichier_utilisateurs = '../data/utilisateurs.json'; 

$notations = file_exists($fichier_notations) ? json_decode(file_get_contents($fichier_notations), true) : [];
$utilisateurs = file_exists($fichier_utilisateurs) ? json_decode(file_get_contents($fichier_utilisateurs), true) : [];

$moyenne = 0;
$total_avis = count($notations);
if ($total_avis > 0) {
    $somme = array_sum(array_column($notations, 'note'));
    $moyenne = round($somme / $total_avis, 1);
}

function getPrenomClient($id_user, $liste_users) {
    foreach ($liste_users as $u) {
        $id_courant = $u['id_user'] ?? $u['id'] ?? null;
        if ($id_courant == $id_user) {
            return $u['prenom'] ?? 'Un client';
        }
    }
    return "Client anonyme";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SunSip - Avis de nos clients</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<?php include('../includes/header.php'); ?>

<main class="formsection">
    <div class="formcontainer container-avis-page">
        
        <h2 class="titlepink title-avis-cursive">
            Ce que nos clients pensent de nous hihi
        </h2>

        <?php if ($total_avis > 0): ?>
            <div class="stats-globales">
                <span class="moyenne-grosse"><?= $moyenne ?></span><span class="moyenne-label"> / 5</span>
                <div class="etoiles-site">
                    <?= str_repeat('⭐', round($moyenne)) ?>
                </div>
                <p class="total-avis-txt">Basé sur <?= $total_avis ?> <?= $total_avis > 1 ? 'avis clients' : 'avis client' ?></p>
            </div>
        <?php endif; ?>

        <?php if (empty($notations)): ?>
            <p class="aucun-avis">
                Aucun avis n'a encore été laissé. Commandez un smoothie et soyez le premier ! 🥤
            </p>
        <?php else: ?>
            <div class="liste-avis-grid">
                <?php 
                foreach (array_reverse($notations) as $avis): 
                    $note = (int)($avis['note'] ?? 0);
                    $commentaire = $avis['commentaire'] ?? '';
                    $date_brute = $avis['date_notation'] ?? '';
                    $date_formatee = !empty($date_brute) ? date('d/m/Y', strtotime($date_brute)) : '';
                    $prenom = getPrenomClient($avis['id_user'] ?? 0, $utilisateurs);
                ?>
                    <div class="card-avis-item">
                        <div class="card-avis-header">
                            <strong class="client-name"><?= htmlspecialchars($prenom) ?></strong>
                            <?php if ($date_formatee): ?>
                                <span class="date-avis-span"><?= $date_formatee ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="etoiles-avis">
                            <?= str_repeat('⭐', $note) ?>
                        </div>
                        
                        <p class="commentaire-txt">
                            "<?= htmlspecialchars($commentaire) ?>"
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include('../includes/footer.php'); ?>

</body>
</html>