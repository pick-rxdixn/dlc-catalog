const details = document.getElementById('dlc-details');
const dlcId = details.dataset.id;
const isAuthenticated = details.dataset.auth === '1';

const claimButton = document.getElementById('claim-button');
const message = document.getElementById('message');

// Отображение состояния полученного дополнения
function markAsClaimed() {
    claimButton.textContent = 'В библиотеке';
    claimButton.disabled = true;
}

// Загрузка информации о дополнении
async function loadDlc() {
    try {
        const response = await apiRequest('/api/dlcs/' + dlcId);

        if (!response.ok) {
            throw new Error('Дополнение не найдено');
        }

        const dlc = await response.json();

        document.title = dlc.title + ' — DLC Catalog';

        document.getElementById('dlc-title').textContent =
            dlc.title;

        document.getElementById('dlc-game').textContent =
            dlc.game.title;

        document.getElementById('dlc-category').textContent =
            dlc.category.name;

        document.getElementById('dlc-description').textContent =
            dlc.description;

        if (isAuthenticated) {
            await checkLibrary();
        }
    } catch (error) {
        details.textContent = 'Не удалось загрузить дополнение';
    }
}

// Проверка наличия дополнения в библиотеке
async function checkLibrary() {
    const response = await apiRequest('/api/library');

    if (!response.ok) {
        throw new Error('Ошибка загрузки библиотеки');
    }

    const library = await response.json();

    const exists = library.some(
        dlc => dlc.id === Number(dlcId)
    );

    if (exists) {
        markAsClaimed();
    } else {
        claimButton.disabled = false;
    }
}

// Получение дополнения
if (claimButton) {
    claimButton.addEventListener('click', async function () {
        claimButton.disabled = true;

        try {
            const response = await apiRequest(
                '/api/dlcs/' + dlcId + '/claim',
                'POST'
            );

            const data = await response.json();

            message.textContent = data.message;

            if (response.ok || response.status === 409) {
                markAsClaimed();
            } else {
                claimButton.disabled = false;
            }
        } catch (error) {
            message.textContent = 'Ошибка соединения с сервером';
            claimButton.disabled = false;
        }
    });
}

loadDlc();