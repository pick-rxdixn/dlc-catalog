const catalog = document.getElementById('catalog');
const search = document.getElementById('search');
const gameFilter = document.getElementById('game-filter');
const categoryFilter = document.getElementById('category-filter');
const resetButton = document.getElementById('reset-filters');
const ownedDlcIds = new Set();

// Загрузка полученных дополнений
async function loadOwnedDlcs() {
    ownedDlcIds.clear();

    if (catalog.dataset.auth !== '1') {
        return;
    }

    try {
        const response = await apiRequest('/api/library');

        if (!response.ok) {
            return;
        }

        const dlcs = await response.json();

        dlcs.forEach(dlc => {
            ownedDlcIds.add(dlc.id);
        });
    } catch (error) {
        console.error('Ошибка загрузки библиотеки', error);
    }
}

// Загрузка игр и категорий
async function loadFilters() {
    const gamesResponse = await apiRequest('/api/games');
    const categoriesResponse = await apiRequest('/api/categories');

    if (!gamesResponse.ok || !categoriesResponse.ok) {
        throw new Error('Ошибка загрузки фильтров');
    }

    const games = await gamesResponse.json();
    const categories = await categoriesResponse.json();

    games.forEach(game => {
        gameFilter.add(new Option(game.title, game.id));
    });

    categories.forEach(category => {
        categoryFilter.add(new Option(category.name, category.id));
    });
}

// Загрузка дополнений
async function loadCatalog() {
    const params = new URLSearchParams();

    if (search.value.trim()) {
        params.set('search', search.value.trim());
    }

    if (gameFilter.value) {
        params.set('game_id', gameFilter.value);
    }

    if (categoryFilter.value) {
        params.set('category_id', categoryFilter.value);
    }

    try {
        const response = await apiRequest('/api/dlcs?' + params);

        if (!response.ok) {
            throw new Error('Ошибка загрузки каталога');
        }

        const dlcs = await response.json();

        renderCatalog(dlcs);
    } catch (error) {
        catalog.textContent = 'Не удалось загрузить дополнения';
    }
}

// Отображение карточек дополнений
function renderCatalog(dlcs) {
    catalog.replaceChildren();

    if (dlcs.length === 0) {
        catalog.textContent = 'Дополнения не найдены';
        return;
    }

    dlcs.forEach(dlc => {
        const card = document.createElement('article');
        card.className = 'dlc-card';

        if (dlc.image) {
            const image = document.createElement('img');
            image.className = 'dlc-image';
            image.src = dlc.image;
            image.alt = dlc.title;
            image.loading = 'lazy';

            card.appendChild(image);
        }

        const game = document.createElement('p');
        game.className = 'game-name';
        game.textContent = dlc.game.title;

        const title = document.createElement('h2');
        title.textContent = dlc.title;

        const category = document.createElement('span');
        category.className = 'category';
        category.textContent = dlc.category.name;

        const description = document.createElement('p');
        description.textContent = dlc.description;

        const link = document.createElement('a');
        link.className = 'button';
        link.href = '/dlcs/' + dlc.id;
        link.textContent = 'Подробнее';

        card.append(game, title, category, description);

        if (ownedDlcIds.has(dlc.id)) {
            const status = document.createElement('p');
            status.className = 'owned-status';
            status.textContent = '✓ В библиотеке';

            card.appendChild(status);
        }

        card.appendChild(link);
        catalog.appendChild(card);
    });
}

// Обработка фильтров
search.addEventListener('input', loadCatalog);
gameFilter.addEventListener('change', loadCatalog);
categoryFilter.addEventListener('change', loadCatalog);

resetButton.addEventListener('click', function () {
    search.value = '';
    gameFilter.value = '';
    categoryFilter.value = '';

    loadCatalog();
});

// Первоначальная загрузка страницы
async function init() {
    try {
        await loadFilters();
        await loadOwnedDlcs();
        await loadCatalog();
    } catch (error) {
        catalog.textContent = 'Ошибка загрузки данных';
    }
}

init();