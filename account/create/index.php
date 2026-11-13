<?php

if (isset($_POST['submit'])) {
    include_once('../../bd/conecao_db.php');

    $name = $_POST['name'];
    $address = $_POST['address'];
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];

    // Insere os dados no banco de dados
    $result = mysqli_query($conexao, "INSERT INTO users(name, address,  mail, pass) 
        VALUES ('$name', '$address', '$mail', '$pass')");

    // Redireciona para a página de login
    header('Location: ../../index.php');
    exit();
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
        <!-- GET temporário até termos a BD -->
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