function enregistrerCommande(idCommande) {
    let carte = document.getElementById('carte-' + idCommande);
    let statutChoisi = carte.querySelector('.select-statut').value;
    let livreurChoisi = carte.querySelector('.select-livreur').value;

    let boite = new FormData();
    boite.append('id_commande', idCommande);
    boite.append('nouveau_statut', statutChoisi);
    boite.append('id_livreur', livreurChoisi);

    fetch('../bin/update_commande.php', {
        method: 'POST',
        body: boite
    })
    .then(reponse => {
        if (!reponse.ok) throw new Error("Erreur HTTP " + reponse.status);
        return reponse.json();
    })
    .then(resultat => {
        if (resultat.statut === 'ok') {
            alert("Commande mise à jour avec succès !");
            location.reload();
        } else {
            alert("Erreur : " + resultat.message);
        }
    })
    .catch(erreur => alert("Erreur réseau : " + erreur.message));
}