document.addEventListener("DOMContentLoaded", function() {
    const formProfil = document.getElementById("form-profil");
    const statusMsg = document.getElementById("status-message");

    if (formProfil) {
        formProfil.addEventListener("submit", function(event) {
           
            event.preventDefault();

            
            const formData = new FormData(formProfil);

            
            fetch("../views/update_profil.php", {
                method: "POST", 
                body: formData   })
            
            .then(response => response.json()) 
            .then(data => {
                
                statusMsg.style.display = "block";
                
                if (data.success) {
                    statusMsg.style.backgroundColor = "#d4edda"; 
                    statusMsg.style.color = "#155724";
                    statusMsg.textContent = "✨ " + data.message;
                } else {
                    statusMsg.style.backgroundColor = "#f8d7da"; 
                    statusMsg.style.color = "#721c24";
                    statusMsg.textContent = "❌ " + data.message;
                }
            })
            .catch(error => {
               
                console.error("Erreur détectée :", error);
                statusMsg.style.display = "block";
                statusMsg.style.backgroundColor = "#f8d7da";
                statusMsg.style.color = "#721c24";
                statusMsg.textContent = "Erreur de connexion avec le serveur";});
        });
    }
});
