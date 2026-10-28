document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.querySelector('.menu-toggle');
  const navLinks = document.querySelector('.nav-links');
  const icon = menuToggle.querySelector('i');

  menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    
    // Alterna o ícone entre hambúrguer (bi-list) e fechar (bi-x)
    if (navLinks.classList.contains('active')) {
      icon.classList.remove('bi-list');
      icon.classList.add('bi-x');
    } else {
      icon.classList.remove('bi-x');
      icon.classList.add('bi-list');
    }
  });

  // Fecha o menu automaticamente se o utilizador clicar fora dele
  document.addEventListener('click', (event) => {
    if (!menuToggle.contains(event.target) && !navLinks.contains(event.target)) {
      navLinks.classList.remove('active');
      icon.classList.remove('bi-x');
      icon.classList.add('bi-list');
    }
  });
});