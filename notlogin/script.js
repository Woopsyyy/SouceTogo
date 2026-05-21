const naVlinks = document.querySelectorAll(".nav-menu .nav-link");
const menuOpenButton = document.querySelector("#menu-open-button");
const menuCloseButton = document.querySelector("#menu-close-button");


menuOpenButton.addEventListener("click", () => {
    /*Toggle mobile menu visibility */
    document.body.classList.toggle("show-mobile-menu");
});

/*Close Menu when click the close */
menuCloseButton.addEventListener("click", () => menuOpenButton.click());

// Close menu when the naavlink is clicked
naVlinks.forEach(link => { link.addEventListener("click", () => menuOpenButton.click()); }); 

document.getElementById('contactForm').addEventListener('submit', function(event) {
    // 1. Prevent the page from reloading
    event.preventDefault();
    this.reset();
    const msg = document.getElementById('responseMessage');
    msg.style.display = 'block';
    setTimeout(() => {
        msg.style.display = 'none';
    }, 5000);
    console.log("Form submitted and cleared without leaving the page.");
});

const menuGridSwiper = new Swiper('.menu-container', {
  slidesPerView: 3,
  grid: {
    rows: 2,
    fill: 'row'
  },
  spaceBetween: 120,
  slidesPerGroup: 3,
  loop: false, 
  
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});

