const passwordInput = document.getElementById('pass');
const toggleButton = document.getElementById('togglePassword');
toggleButton.addEventListener('click', () => {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    toggleButton.textContent = type === 'password' ? '👁️' : '🙈';
})