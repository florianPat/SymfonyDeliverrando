export function switchToRegisterForm()
{
    let loginForm = document.getElementById('personLoginForm');
    let registerForm = document.getElementById('personRegisterForm');
    let switchToLoginText = document.getElementById('personShowLoginFormText');
    let switchToRegisterText = document.getElementById('personShowRegisterFormText');

    loginForm.style.display = 'none';
    registerForm.style.display = 'inline';
    switchToLoginText.style.display = 'block';
    switchToRegisterText.style.display = 'none';
}

export function switchToLoginForm()
{
    let loginForm = document.getElementById('personLoginForm');
    let registerForm = document.getElementById('personRegisterForm');
    let switchToLoginText = document.getElementById('personShowLoginFormText');
    let switchToRegisterText = document.getElementById('personShowRegisterFormText');

    loginForm.style.display = 'inline';
    registerForm.style.display = 'none';
    switchToLoginText.style.display = 'none';
    switchToRegisterText.style.display = 'block';
}

window.switchToRegisterForm = switchToRegisterForm;
window.switchToLoginForm = switchToLoginForm;