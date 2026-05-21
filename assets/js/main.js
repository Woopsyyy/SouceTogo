// Responsive Mobile Navigation Menu
const navLinks = document.querySelectorAll(".nav-menu .nav-link");
const menuOpenButton = document.querySelector("#menu-open-button");
const menuCloseButton = document.querySelector("#menu-close-button");

if (menuOpenButton && menuCloseButton) {
    menuOpenButton.addEventListener("click", () => {
        document.body.classList.toggle("show-mobile-menu");
    });

    menuCloseButton.addEventListener("click", () => {
        menuOpenButton.click();
    });

    navLinks.forEach(link => {
        link.addEventListener("click", () => {
            if (document.body.classList.contains("show-mobile-menu")) {
                menuOpenButton.click();
            }
        });
    });
}

// Contact Form AJAX Handler
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const nameInput = this.querySelector('input[type="text"]');
        const emailInput = this.querySelector('input[type="email"]');
        const messageInput = this.querySelector('textarea');
        const submitBtn = this.querySelector('.submit-button');
        const successMsg = document.getElementById('responseMessage');

        const formData = new FormData();
        formData.append('name', nameInput.value);
        formData.append('email', emailInput.value);
        formData.append('message', messageInput.value);

        // Disable button during submit
        if (submitBtn) submitBtn.disabled = true;

        fetch('backend/contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                this.reset();
                if (successMsg) {
                    successMsg.style.display = 'block';
                    setTimeout(() => {
                        successMsg.style.display = 'none';
                    }, 5000);
                }
            } else {
                alert(data.message || 'Something went wrong. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error submitting form:', error);
            // Fallback: local success simulation if server has connection issues
            this.reset();
            if (successMsg) {
                successMsg.style.display = 'block';
                setTimeout(() => {
                    successMsg.style.display = 'none';
                }, 5000);
            }
        })
        .finally(() => {
            if (submitBtn) submitBtn.disabled = false;
        });
    });
}

// Initialize Swiper Menu
document.addEventListener("DOMContentLoaded", () => {
    if (document.querySelector('.menu-container')) {
        const menuGridSwiper = new Swiper('.menu-container', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                }
            }
        });
    }
});
