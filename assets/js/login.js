// Login & Registration sliding switch
const wrapper = document.querySelector('.section');
const registerLink = document.querySelector('.register-link p a, .register-link a');
const loginLink = document.querySelector('.login-link p a, .login-link a');

if (registerLink && loginLink && wrapper) {
    registerLink.onclick = (e) => {
        e.preventDefault();
        wrapper.classList.add('active');
    };

    loginLink.onclick = (e) => {
        e.preventDefault();
        wrapper.classList.remove('active');
    };
}
