<?php
require_once 'bd/conecao_db.php';

$distrito = isset($_GET['distrito']) ? trim($_GET['distrito']) : '';

if ($distrito !== '') {
    $sql = "SELECT id, name, address, mail, telefone, dias_disponiveis, hora_abertura, hora_fecho
            FROM oficinas
            WHERE address LIKE :distrito
            ORDER BY name ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':distrito' => '%' . $distrito . '%',
    ]);
} else {
    $sql = "SELECT id, name, address, mail, telefone, dias_disponiveis, hora_abertura, hora_fecho
            FROM oficinas
            ORDER BY name ASC";
    $stmt = $pdo->query($sql);
}

$oficinas = $stmt->fetchAll();
?>
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
      <a href="account/create/index.php" class="nav-btn nav-btn-primary" id="account-create" onclick="account_conta(event)">Criar Conta</a>
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
              value="<?= htmlspecialchars($distrito, ENT_QUOTES, 'UTF-8') ?>"
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
      <?php if (count($oficinas) > 0): ?>
        <?php foreach ($oficinas as $oficina): ?>
          <?php
            $horaAbertura = !empty($oficina['hora_abertura']) ? substr($oficina['hora_abertura'], 0, 5) : '';
            $horaFecho = !empty($oficina['hora_fecho']) ? substr($oficina['hora_fecho'], 0, 5) : '';
            $telefoneLimpo = preg_replace('/\D/', '', (string) $oficina['telefone']);
          ?>
          <article class="workshop-card">
            <div class="workshop-info">
              <h2 class="workshop-name">Nome oficina: <span><?= htmlspecialchars($oficina['name'], ENT_QUOTES, 'UTF-8') ?></span></h2>
              <p class="workshop-address">Morada: <span><?= htmlspecialchars($oficina['address'], ENT_QUOTES, 'UTF-8') ?></span></p>
              <?php if (!empty($oficina['dias_disponiveis'])): ?>
                <p class="workshop-days">Dias disponíveis: <span><?= htmlspecialchars($oficina['dias_disponiveis'], ENT_QUOTES, 'UTF-8') ?></span></p>
              <?php endif; ?>
              <?php if ($horaAbertura !== '' && $horaFecho !== ''): ?>
                <p class="workshop-hours">Horário: <span><?= htmlspecialchars($horaAbertura . ' - ' . $horaFecho, ENT_QUOTES, 'UTF-8') ?></span></p>
              <?php endif; ?>
              <?php if (!empty($oficina['mail'])): ?>
                <p class="workshop-mail">Email: <a href="mailto:<?= htmlspecialchars($oficina['mail'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($oficina['mail'], ENT_QUOTES, 'UTF-8') ?></a></p>
              <?php endif; ?>
            </div>
            <div class="workshop-contact">
              Contacto: <a href="tel:<?= htmlspecialchars($telefoneLimpo, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $oficina['telefone'], ENT_QUOTES, 'UTF-8') ?></a>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="no-workshops">
          <?php if ($distrito !== ''): ?>
            Não foram encontradas oficinas para "<?= htmlspecialchars($distrito, ENT_QUOTES, 'UTF-8') ?>".
          <?php else: ?>
            Ainda não existem oficinas registadas.
          <?php endif; ?>
        </p>
      <?php endif; ?>
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