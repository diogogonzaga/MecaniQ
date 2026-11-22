<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['mail']) && !empty($_POST['pass'])) {
    require_once '../../bd/conecao_db.php';

    $mail = trim($_POST['mail']);
    $pass = $_POST['pass'];

    try {
        $sql = "SELECT id, name, address, mail, pass FROM users WHERE mail = :mail AND pass = :pass LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':mail' => $mail,
            ':pass' => $pass,
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $_SESSION['mail'] = $row['mail'];
            $_SESSION['id'] = $row['id'];

            header("Location: ../../index.php");
            exit();
        } else {
            header("Location: index.html?error=1");
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