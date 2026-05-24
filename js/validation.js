document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.getElementById("toggle-password");
    const passwordInput = document.getElementById("password");
    
    if (togglePassword && passwordInput) {
        
        togglePassword.addEventListener("click", function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text"; 
                togglePassword.textContent = "🙈";
            } 
            else {
                passwordInput.type = "password"; 
                togglePassword.textContent = "👁️"; 
            }
        });
    }

});
