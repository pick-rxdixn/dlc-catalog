const registerForm = document.getElementById('register-form');
const loginForm = document.getElementById('login-form');
const message = document.getElementById('message');

// Отправка формы авторизации или регистрации
async function submitAuthForm(event, url) {
    event.preventDefault();

    const form = event.target;
    const button = form.querySelector('button[type="submit"]');

    const data = Object.fromEntries(new FormData(form));

    button.disabled = true;
    message.textContent = '';

    try {
        const response = await apiRequest(url, 'POST', data);
        const result = await response.json();

        if (response.ok) {
            window.location.href = '/';
            return;
        }

        if (result.errors) {
            message.textContent = Object.values(result.errors)
                .flat()
                .join('\n');
        } else {
            message.textContent = result.message || 'Произошла ошибка';
        }

    } catch (error) {
        message.textContent = 'Ошибка соединения с сервером';
    } finally {
        button.disabled = false;
    }
}

// Регистрация
if (registerForm) {
    registerForm.addEventListener('submit', function (event) {
        submitAuthForm(event, '/api/register');
    });
}

// Авторизация
if (loginForm) {
    loginForm.addEventListener('submit', function (event) {
        submitAuthForm(event, '/api/login');
    });
}