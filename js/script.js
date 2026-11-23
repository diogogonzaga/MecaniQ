document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.querySelector('.menu-toggle');
  const navLinks = document.querySelector('.nav-links');
  const icon = menuToggle.querySelector('i');

  menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    menuToggle.setAttribute('aria-expanded', navLinks.classList.contains('active') ? 'true' : 'false');
    
    
    if (navLinks.classList.contains('active')) {
      icon.classList.remove('bi-list');
      icon.classList.add('bi-x');
    } else {
      icon.classList.remove('bi-x');
      icon.classList.add('bi-list');
    }
  });

 
  document.addEventListener('click', (event) => {
    if (!menuToggle.contains(event.target) && !navLinks.contains(event.target)) {
      navLinks.classList.remove('active');
      menuToggle.setAttribute('aria-expanded', 'false');
      icon.classList.remove('bi-x');
      icon.classList.add('bi-list');
    
    }
  });
});