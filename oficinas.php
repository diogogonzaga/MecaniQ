<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MecaniQ - Procurar Oficinas</title>
    <link rel="icon" type="image/png" href="images/logo_sem.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/oficinas.css">
</head>
<body>

<header class="navbar-header">
  <nav class="navbar">
    <div class="logo">
      <a href="index.php">
        <img src="images/logo_title_sem.png" alt="MecaniQ Logotipo">
      </a><span>

      </span>
    </div>

    <button class="menu-toggle" aria-label="Abrir Menu">
      &#9776;
    </button>

    <div class="nav-links">
      <a href="index.php" class="nav-btn nav-btn-secondary">Início</a>
      <a href="account/login/index.php" class="nav-btn nav-btn-secondary" id="account" onclick="account(event)">Login</a>
      <a href="account/create/index.php" class="nav-btn nav-btn-primary" id="account" onclick="account_conta(event)">Criar Conta</a>
    </div>
  </nav>
</header>

<main>
  <section class="workshops-page">
    <div class="workshops-container">
      <div class="workshops-header">
        <h1>Encontrar Mecânico</h1>
        <p>Pesquise oficinas disponíveis na sua área de residência</p>
      </div>

      <div class="search-district-box">
        <form method="GET" action="oficinas.php" class="search-form">
          <div class="search-input-wrapper">
            <input 
              type="text" 
              name="distrito" 
              placeholder="Insira aqui o seu distrito:" 
              aria-label="Insira aqui o seu distrito"
            >
          </div>
          <button type="submit" class="search-btn">
            Pesquisar
          </button>
        </form>
      </div>
    </div>
      <div class="workshops-list">
        <article class="workshop-card">
          <div class="workshop-info">
            <h2 class="workshop-name">Nome oficina: <span>Auto Mecânica Central</span></h2>
            <p class="workshop-address">Morada: <span>Rua de Santa Catarina 450, Porto</span></p>
          </div>
          <div class="workshop-contact">
            Contacto: <a href="tel:220123456">220 123 456</a>
          </div>
        </article>
      </div>
  </section>
</main>


<footer class="footer">
    <div class="footer-container">
      <p>&copy; 2026 MecaniQ. Todos os direitos reservados.</p>
      <div class="policy">
        <a href="#" id="Privacidade" onclick="Privacidade()">Política de Privacidade</a>
        <a href="#" id="Termos" onclick="Termos()">Termos de Serviço</a>
      </div>
      <div class="footer-contacts">
        <a href="mailto:contato@mecaniq.com">Contato por email: contato@mecaniq.com</a>
        <a href="tel:+551112345678">Contato por telefone: (11) 1234-5678</a>
      </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/swalfire.js"></script>
<script src="js/script.js"></script>

</body>
</html>