document.addEventListener("DOMContentLoaded", function() {
    const themeLink = document.querySelector("link[href*='style.css']");
    const themeBtn = document.getElementById("theme-toggle");
    let cookies = document.cookie.split('; ');
    let currentTheme = "../style.css"; 

    for (let c of cookies) {
        let [name, value] = c.split('=');
        if (name === 'theme') {
            currentTheme = value;
        }
    }
    if (themeLink && (currentTheme.includes("style.css") || currentTheme.includes("dark_style.css"))) {
        themeLink.setAttribute("href", currentTheme);
    }

    if (themeBtn && themeLink) {
        themeBtn.addEventListener("click", function() {
            let activeTheme = themeLink.getAttribute("href");
            let newTheme = "../style.css";
            if (activeTheme.includes("dark_style.css")) {
                newTheme = "../style.css";
            } else {
                newTheme = "../dark_style.css";
            }
            themeLink.setAttribute("href", newTheme);

            document.cookie = `theme=${newTheme}; max-age=${30 * 24 * 60 * 60}; path=/`;
        });
    }
});
