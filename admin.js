// --- ACTION 1 : BLOQUER UN UTILISATEUR ---
function enviarBlocage(id) {
    if (confirm("Voulez-vous vraiment bloquer cet utilisateur ?")) {
        executerActionAdmin(id, 'bloquer', "L'utilisateur a été banni avec succès !");
    }
}

// --- ACTION 2 : PASSER VIP ---
function passerVip(id) {
    if (confirm("Passer cet utilisateur en VIP ?")) {
        executerActionAdmin(id, 'vip', "Utilisateur passé en VIP !");
    }
}

// --- ACTION 3 : PASSER PREMIUM ---
function passerPremium(id) {
    if (confirm("Passer cet utilisateur en Premium ?")) {
        executerActionAdmin(id, 'premium', "Utilisateur passé en Premium !");
    }
}

// Fonction globale pour éviter de répéter 3 fois le même Fetch
function executerActionAdmin(id, actionAssignee, messageSucces) {
    let boite_donnees = new FormData();
    boite_donnees.append('id_utilisateur', id);
    boite_donnees.append('action', actionAssignee);

    fetch('/views/traiter_admin.php', {
        method: 'POST',
        body: boite_donnees
    })
    .then(reponse => {
        if (!reponse.ok) throw new Error("Erreur serveur HTTP " + reponse.status);
        return reponse.json();
    })
    .then(resultat => {
        if (resultat.statut === 'ok') {
            alert(messageSucces);
            location.reload();
        } else {
            alert("Erreur du serveur : " + resultat.message);
        }
    })
    .catch(erreur => alert("Erreur réseau : " + erreur.message));
}