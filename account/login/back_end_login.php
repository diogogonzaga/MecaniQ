<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['mail']) && !empty($_POST['pass'])) {
    require_once '../../bd/conecao_db.php';

    $mail = trim($_POST['mail']);
    $pass = $_POST['pass'];

    try {
        $sql = "SELECT * FROM oficinas WHERE mail = :mail LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':mail' => $mail,
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($pass, $row['pass'])) {
            session_regenerate_id(true);
            $_SESSION['mail'] = $row['mail'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];

            header("Location: perfil_oficina.php");
            exit();
        } else {
         $_SESSION['login_error'] = "Email ou password incorretos.";
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Erro no login (PDO): " . $e->getMessage());
        header("Location: index.html?error=1");
        exit();
    }
} else {
    header("Location: index.html");
    exit();
}