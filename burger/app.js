const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');

    burger.addEventListener('click', () => {
        nav.classList.toggle('nav-active');
        for (let i = 0; i < navLinks.length; i++) {
            if (navLinks[i].style.animation) {
                navLinks[i].style.animation = '';
            } else {
                navLinks[i].style.animation = `navLinkFade 0.5s ease forwards ${i / 7 + 0.3}s`;    
            }
        }
        burger.classList.toggle('toggle');
    });
}

navSlide();