<?php
$erro = '';

if (isset($_POST['submit'])) {
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $mail = trim($_POST['mail'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $dias = $_POST['dias'] ?? [];
    $horaAbertura = trim($_POST['hora_abertura'] ?? '');
    $horaFecho = trim($_POST['hora_fecho'] ?? '');
    $pass = $_POST['pass'] ?? '';

    if (
        $name === '' ||
        $address === '' ||
        $mail === '' ||
        $telefone === '' ||
        !is_array($dias) || count($dias) === 0 ||
        $horaAbertura === '' ||
        $horaFecho === '' ||
        $pass === ''
    ) {
        $erro = 'Preencha todos os campos obrigatórios e escolha pelo menos um dia.';
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Introduza um endereço de email válido.';
    } elseif (!preg_match('/^[0-9]{9}$/', $telefone)) {
        $erro = 'O telefone deve ter exatamente 9 dígitos.';
    } else {
        include_once('../../bd/conecao_db.php');

        $diasTexto = implode(',', $dias);
        $passHash = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO oficinas (name, address, mail, telefone, dias_disponiveis, hora_abertura, hora_fecho, pass)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $address, $mail, $telefone, $diasTexto, $horaAbertura, $horaFecho, $passHash]);

        header('Location: ../../index.php');
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MecaniQ - Registo</title>
    <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="../../css/style.css">

</head>
<body>

<header class="navbar-header">
  <nav class="navbar">
    <div class="logo">
      <a href="../../index.html">
        <img src="../../images/logo_title_sem.png" alt="MecaniQ Logotipo">
      </a>
    </div>

    <!-- Menu Hamburguer para dispositivos moveis -->
    <button class="menu-toggle" aria-label="Abrir Menu">
      <i class="bi bi-list"></i>
    </button>

    <div class="nav-links">
      <a href="../../index.html" class="nav-btn nav-btn-secondary">Início</a>
      <a href="../login/" class="nav-btn nav-btn-primary">Login</a>
    </div>
  </nav>
</header>

<main class="login-container">
    <section id="login_card" class="login_card">
 
        <form action="index.php" method="POST" class="form">
            <fieldset>
                <legend>Dados de Criação de Conta</legend>
                
                <div class="grupo">
                    <label for="name">Digite o nome da oficina:</label>
                    <input type="text" name="name" id="name" placeholder="Nome cda oficina" required>
                </div>

                <div class="grupo">
                    <label for="address">Digite o endereço da oficina:</label>
                    <input type="text" name="address" id="address" placeholder="Endereço da oficina" required>
                </div>

                <div class="grupo">
                    <label for="mail">Digite o seu email:</label>
                    <input type="email" name="mail" id="mail" placeholder="exemplo@gmail.com" required>
                </div>

                <div class="grupo">
                    <label for="telefone">Digite o seu telefone:</label>
                    <input type="text" name="telefone" id="telefone" placeholder="912345678" required>
                </div>

                <div class="grupo">
                <label>Dias de disponibilidade:</label>
                  <div class="dias-semana">
                 <label><input type="checkbox" name="dias[]" value="seg"> Seg</label>
                <label><input type="checkbox" name="dias[]" value="ter"> Ter</label>
                <label><input type="checkbox" name="dias[]" value="qua"> Qua</label>
                <label><input type="checkbox" name="dias[]" value="qui"> Qui</label>
                <label><input type="checkbox" name="dias[]" value="sex"> Sex</label>
                <label><input type="checkbox" name="dias[]" value="sab"> Sáb</label>
                <label><input type="checkbox" name="dias[]" value="dom"> Dom</label>
            </div>
        </div>

<div class="grupo">
    <label for="hora_abertura">Horário de funcionamento:</label>
    <div class="horario-grupo">
        <input type="time" name="hora_abertura" id="hora_abertura" value="09:00" required>
        <span class="asinhas">às</span>
        <input type="time" name="hora_fecho" id="hora_fecho" value="18:00" required>
    </div>
</div>

                <div class="grupo">
                    <label for="pass">Digite a sua password:</label>
                    <input type="password" name="pass" id="pass" placeholder="••••••••••••" required>
                </div>

                <div class="botoes-grupo">
                    <button type="submit" name="submit" class="btn-submit">Submeter</button>
                    <button type="reset" class="btn-reset">Limpar Dados</button>
                </div>
<div class="francesinha">
    Já tem uma conta? <a href="../login/index.html">Entrar na conta</a>
</div>

            
            </fieldset>
        </form>
    </section>
</main>
<script src="../../js/script.js"></script>
</body>
</html>