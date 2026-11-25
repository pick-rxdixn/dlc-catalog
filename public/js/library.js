const library = document.getElementById('library');
const libraryCount = document.getElementById('library-count');

// Загрузка личной библиотеки
async function loadLibrary() {
    try {
        const response = await apiRequest('/api/library');

        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }

        if (!response.ok) {
            throw new Error('Ошибка загрузки библиотеки');
        }

        const dlcs = await response.json();

        renderLibrary(dlcs);

    } catch (error) {
        library.textContent = 'Не удалось загрузить библиотеку';
    }
}

// Отображение полученных дополнений
function renderLibrary(dlcs) {
    library.replaceChildren();

    libraryCount.textContent =
        'Количество дополнений: ' + dlcs.length;

    if (dlcs.length === 0) {
        const empty = document.createElement('div');
        empty.className = 'empty-library';

        const text = document.createElement('p');
        text.textContent = 'Ваша библиотека пока пуста';

        const link = document.createElement('a');
        link.href = '/';
        link.className = 'button';
        link.textContent = 'Перейти в каталог';

        empty.append(text, link);
        library.appendChild(empty);

        return;
    }

    dlcs.forEach(dlc => {
        const card = document.createElement('article');
        card.className = 'dlc-card';

        const game = document.createElement('p');
        game.className = 'game-name';
        game.textContent = dlc.game.title;

        const title = document.createElement('h2');
        title.textContent = dlc.title;

        const category = document.createElement('span');
        category.className = 'category';
        category.textContent = dlc.category.name;

        const date = document.createElement('p');
        date.className = 'granted-date';

        date.textContent = 'Дата получения: ' +
            new Date(dlc.pivot.granted_at)
                .toLocaleDateString('ru-RU');

        const status = document.createElement('p');
        status.className = 'owned-status';
        status.textContent = 'В библиотеке';

        const link = document.createElement('a');
        link.className = 'button';
        link.href = '/dlcs/' + dlc.id;
        link.textContent = 'Подробнее';

        card.append(
            game,
            title,
            category,
            date,
            status,
            link
        );

        library.appendChild(card);
    });
}

loadLibrary();