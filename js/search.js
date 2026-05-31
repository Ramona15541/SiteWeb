let tousLesPlats = [];
let tousLesMenus = [];

window.addEventListener('DOMContentLoaded', () => {
    Promise.all([
        fetch('../data/plat.json').then(res => res.json()),
        fetch('../data/menu.json').then(res => res.json())
    ])
    .then(([plats, menus]) => {
        tousLesPlats = plats;
        tousLesMenus = menus;
        initSimpleSearch();
    });
});

function initSimpleSearch() {
    const searchInput = document.getElementById('search-input');
    const resultsDropdown = document.getElementById('search-results-show');

    if (!searchInput || !resultsDropdown) return;

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();

        if (query === '') {
            resultsDropdown.style.display = 'none';
            return;
        }

        const menusFiltres = tousLesMenus.filter(menu => 
            menu.nom.toLowerCase().includes(query)
        );

        const platsFiltres = tousLesPlats.filter(plat => 
            plat.nom.toLowerCase().includes(query)
        );

        const tousResultats = [...menusFiltres, ...platsFiltres];

        if (tousResultats.length === 0) {
            resultsDropdown.innerHTML = `<div style="padding: 10px; color: #999;">Aucun résultat</div>`;
        } else {
            let html = '';
            tousResultats.forEach(item => {

                const cible = item.id_menu ? 'menus' : item.categorie.toLowerCase() + 's';
                
                html += `<a href="#section${cible}" class="search-item-simple">${item.nom}</a>`;
            });
            resultsDropdown.innerHTML = html;
        }

        resultsDropdown.style.display = 'block';
    });
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target)) {
            resultsDropdown.style.display = 'none';
        }
    });
}
