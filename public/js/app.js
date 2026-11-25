async function apiRequest(url, method = 'GET', data = null) {
    const options = {
        method: method,
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector(
                'meta[name="csrf-token"]'
            ).content
        }
    };

    if (data !== null) {
        options.body = JSON.stringify(data);
    }

    return await fetch(url, options);
}

const logoutButton = document.getElementById('logout-button');

if (logoutButton) {
    logoutButton.addEventListener('click', async function () {
        try {
            const response = await apiRequest('/api/logout', 'POST');

            if (response.ok) {
                window.location.href = '/';
            } else {
                alert('Не удалось выйти из аккаунта');
            }
        } catch (error) {
            alert('Ошибка соединения с сервером');
        }
    });
}