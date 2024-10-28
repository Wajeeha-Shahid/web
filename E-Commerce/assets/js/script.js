// JavaScript to toggle menu on mobile screens
const menuToggle = document.getElementById('menuToggle');
const navMenu = document.querySelector('.nav3 ul');

menuToggle.addEventListener('click', function() {
    navMenu.classList.toggle('show');
});

