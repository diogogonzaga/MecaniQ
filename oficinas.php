<?php
require_once __DIR__ . '/bd/conecao_db.php';

$districtInput = $_GET['distrito'] ?? '';
$invalidDistrict = !is_string($districtInput);
$district = $invalidDistrict ? '' : trim($districtInput);
$workshops = [];
$databaseError = false;

if ($invalidDistrict) {
    http_response_code(400);
} else {
    try {
        $sql = 'SELECT name, address, mail FROM users';
        $params = [];

        if ($district !== '') {
            $sql .= ' WHERE address LIKE :district';
            $params['district'] = '%' . $district . '%';
        }

        $sql .= ' ORDER BY name';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $workshops = $stmt->fetchAll();
    } catch (PDOException $exception) {
        error_log('Erro ao procurar oficinas: ' . $exception->getMessage());
        $databaseError = true;
    }
}

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MecaniQ - Encontrar oficinas</title>
    <link rel="icon" type="image/png" href="images/logo_sem.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/oficinas.css">
</head>
<body>
<header class="navbar-header">
    <nav class="navbar">
        <div class="logo">
            <a href="index.php">
                <img src="images/logo_title_sem.png" alt="MecaniQ">
            </a>
        </div>
        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>
        <div class="nav-links">
            <a href="index.php" class="nav-btn nav-btn-secondary">Início</a>
            <a href="account/login/index.html" class="nav-btn nav-btn-secondary">Login</a>
            <a href="account/create/index.php" class="nav-btn nav-btn-primary">Criar conta</a>
        </div>
    </nav>
</header>

<main class="workshops-page">
    <section class="workshops-container" aria-labelledby="page-title">
        <div class="workshops-heading">
            <span class="badge"><i class="bi bi-geo-alt" aria-hidden="true"></i> Oficinas registadas</span>
            <h1 id="page-title">Encontre uma oficina perto de si</h1>
            <p class="slogan">Pesquise por distrito e consulte os dados de contacto das oficinas.</p>
        </div>

        <form class="district-search" action="oficinas.php" method="get">
            <label for="district">Distrito</label>
            <div class="search-controls">
                <input
                    type="search"
                    id="district"
                    name="distrito"
                    value="<?= escapeHtml($district) ?>"
                    placeholder="Ex.: Lisboa"
                >
                <button class="cta-btn" type="submit">
                    <i class="bi bi-search" aria-hidden="true"></i> Procurar
                </button>
                <?php if ($district !== ''): ?>
                    <a class="clear-search" href="oficinas.php">Limpar pesquisa</a>
                <?php endif; ?>
            </div>
        </form>

        <section class="workshop-results" aria-label="Resultados da pesquisa">
            <?php if ($invalidDistrict): ?>
                <p class="results-message results-error" role="alert">
                    O distrito indicado não é válido. Volte a preencher a pesquisa.
                </p>
            <?php elseif ($databaseError): ?>
                <p class="results-message results-error" role="alert">
                    Não foi possível carregar as oficinas. Tente novamente mais tarde.
                </p>
            <?php elseif (count($workshops) === 0): ?>
                <p class="results-message">
                    <?= $district !== ''
                        ? 'Não foram encontradas oficinas para este distrito.'
                        : 'Ainda não existem oficinas registadas.' ?>
                </p>
            <?php else: ?>
                <p class="results-count">
                    <?= count($workshops) ?> <?= count($workshops) === 1 ? 'oficina encontrada' : 'oficinas encontradas' ?>
                </p>
                <div class="workshop-list">
                    <?php foreach ($workshops as $workshop): ?>
                        <article class="workshop-card">
                            <div class="workshop-details">
                                <h2><?= escapeHtml($workshop['name']) ?></h2>
                                <p><i class="bi bi-geo-alt" aria-hidden="true"></i> <?= escapeHtml($workshop['address']) ?></p>
                            </div>
                            <a class="workshop-contact" href="mailto:<?= escapeHtml($workshop['mail']) ?>">
                                <i class="bi bi-envelope" aria-hidden="true"></i>
                                <span><?= escapeHtml($workshop['mail']) ?></span>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
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
