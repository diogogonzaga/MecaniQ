<?php
session_start();

// Garante que apenas um utilizador autenticado acede à página
if (empty($_SESSION['id'])) {
    header("Location: login/index.php");
    exit();
}

    require_once '../../bd/conecao_db.php';

$idOficina = (int) $_SESSION['id'];
$mensagemSucesso = '';
$mensagemErro = '';

// Processar pedidos POST (Atualizar ou Apagar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // --- APAGAR CONTA ---
    if ($acao === 'apagar') {
        try {
            $sqlDelete = "DELETE FROM oficinas WHERE id = :id";
            $stmtDelete = $pdo->prepare($sqlDelete);
            $stmtDelete->execute([':id' => $idOficina]);

            $_SESSION = [];
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }
            session_destroy();

            header("Location: login/index.php?conta_apagada=1");
            exit();
        } catch (PDOException $e) {
            error_log("Erro ao apagar oficina: " . $e->getMessage());
            $mensagemErro = "Ocorreu um erro ao tentar apagar a conta.";
        }
    }

    // --- ATUALIZAR DADOS ---
    if ($acao === 'atualizar') {
        $name = trim($_POST['name'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $mail = trim($_POST['mail'] ?? '');
        $telefoneRaw = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
        $diasDisponiveis = trim($_POST['dias_disponiveis'] ?? '');
        $horaAbertura = trim($_POST['hora_abertura'] ?? '');
        $horaFecho = trim($_POST['hora_fecho'] ?? '');
        $novaPass = $_POST['nova_pass'] ?? '';

        if ($name === '' || $mail === '' || $address === '' || $diasDisponiveis === '' || $horaAbertura === '' || $horaFecho === '') {
            $mensagemErro = "Por favor, preencha todos os campos obrigatórios.";
        } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $mensagemErro = "Introduza um endereço de e-mail válido.";
        } elseif (strlen($telefoneRaw) < 7 || strlen($telefoneRaw) > 9) {
            $mensagemErro = "O telefone deve ter até 9 dígitos.";
        } else {
            try {
                // Verifica se o e-mail já pertence a outra oficina
                $stmtCheck = $pdo->prepare("SELECT id FROM oficinas WHERE mail = :mail AND id != :id LIMIT 1");
                $stmtCheck->execute([
                    ':mail' => $mail,
                    ':id'   => $idOficina,
                ]);

                if ($stmtCheck->fetch()) {
                    $mensagemErro = "Este e-mail já está associado a outra oficina.";
                } else {
                    $telefone = (int) $telefoneRaw;

                    if ($novaPass !== '') {
                        if (strlen($novaPass) < 6) {
                            $mensagemErro = "A nova password deve ter pelo menos 6 caracteres.";
                        } else {
                            $hashPass = password_hash($novaPass, PASSWORD_DEFAULT);
                            $sqlUpdate = "UPDATE oficinas
                                          SET name = :name,
                                              address = :address,
                                              mail = :mail,
                                              telefone = :telefone,
                                              dias_disponiveis = :dias_disponiveis,
                                              hora_abertura = :hora_abertura,
                                              hora_fecho = :hora_fecho,
                                              pass = :pass
                                          WHERE id = :id";
                            $stmtUpdate = $pdo->prepare($sqlUpdate);
                            $stmtUpdate->execute([
                                ':name'             => $name,
                                ':address'          => $address,
                                ':mail'             => $mail,
                                ':telefone'         => $telefone,
                                ':dias_disponiveis' => $diasDisponiveis,
                                ':hora_abertura'    => $horaAbertura,
                                ':hora_fecho'       => $horaFecho,
                                ':pass'             => $hashPass,
                                ':id'               => $idOficina,
                            ]);
                        }
                    } else {
                        $sqlUpdate = "UPDATE oficinas
                                      SET name = :name,
                                          address = :address,
                                          mail = :mail,
                                          telefone = :telefone,
                                          dias_disponiveis = :dias_disponiveis,
                                          hora_abertura = :hora_abertura,
                                          hora_fecho = :hora_fecho
                                      WHERE id = :id";
                        $stmtUpdate = $pdo->prepare($sqlUpdate);
                        $stmtUpdate->execute([
                            ':name'             => $name,
                            ':address'          => $address,
                            ':mail'             => $mail,
                            ':telefone'         => $telefone,
                            ':dias_disponiveis' => $diasDisponiveis,
                            ':hora_abertura'    => $horaAbertura,
                            ':hora_fecho'       => $horaFecho,
                            ':id'               => $idOficina,
                        ]);
                    }

                    if ($mensagemErro === '') {
                        $_SESSION['name'] = $name;
                        $_SESSION['mail'] = $mail;
                        $mensagemSucesso = "Dados da oficina atualizados com sucesso!";
                    }
                }
            } catch (PDOException $e) {
                error_log("Erro ao atualizar oficina: " . $e->getMessage());
                $mensagemErro = "Ocorreu um erro ao guardar as alterações.";
            }
        }
    }
}

// Buscar os dados atuais da oficina
try {
    $stmt = $pdo->prepare("SELECT id, name, address, mail, telefone, dias_disponiveis, hora_abertura, hora_fecho FROM oficinas WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $idOficina]);
    $oficina = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$oficina) {
        session_destroy();
        header("Location: login/index.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Erro ao carregar dados da oficina: " . $e->getMessage());
    die("Erro ao carregar os dados da conta.");
}

// Formata horas para HH:MM no input type="time"
$horaAberturaVal = substr((string) $oficina['hora_abertura'], 0, 5);
$horaFechoVal = substr((string) $oficina['hora_fecho'], 0, 5);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Conta - <?= htmlspecialchars($oficina['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-wrench-adjustable-circle me-2"></i>Mecaniq
            </a>
            <div class="d-flex align-items-center gap-3 text-white">
                <span>
                    <i class="bi bi-person-circle me-1"></i>
                    <?= htmlspecialchars($oficina['name']) ?>
                </span>
                <a href="index.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Sair
                </a>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-pencil-square text-primary me-2"></i>Editar Dados da Oficina
                        </h4>
                
                    </div>

                    <div class="card-body p-4">
                        <?php if ($mensagemSucesso !== ''): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($mensagemSucesso) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($mensagemErro !== ''): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($mensagemErro) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <input type="hidden" name="acao" value="atualizar">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">
                                        <i class="bi bi-shop me-1 text-secondary"></i>Nome da Oficina
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name" maxlength="30" required
                                           value="<?= htmlspecialchars($oficina['name']) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="mail" class="form-label">
                                        <i class="bi bi-envelope me-1 text-secondary"></i>E-mail
                                    </label>
                                    <input type="email" class="form-control" id="mail" name="mail" maxlength="50" required
                                           value="<?= htmlspecialchars($oficina['mail']) ?>">
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">
                                        <i class="bi bi-geo-alt me-1 text-secondary"></i>Morada
                                    </label>
                                    <input type="text" class="form-control" id="address" name="address" maxlength="100" required
                                           value="<?= htmlspecialchars($oficina['address']) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="telefone" class="form-label">
                                        <i class="bi bi-telephone me-1 text-secondary"></i>Telefone
                                    </label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" maxlength="9" required
                                           value="<?= htmlspecialchars((string) $oficina['telefone']) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="dias_disponiveis" class="form-label">
                                        <i class="bi bi-calendar-week me-1 text-secondary"></i>Dias Disponíveis
                                    </label>
                                    <input type="text" class="form-control" id="dias_disponiveis" name="dias_disponiveis" maxlength="50" required
                                           placeholder="Ex.: Seg a Sex"
                                           value="<?= htmlspecialchars($oficina['dias_disponiveis']) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="hora_abertura" class="form-label">
                                        <i class="bi bi-clock me-1 text-secondary"></i>Hora de Abertura
                                    </label>
                                    <input type="time" class="form-control" id="hora_abertura" name="hora_abertura" required
                                           value="<?= htmlspecialchars($horaAberturaVal) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="hora_fecho" class="form-label">
                                        <i class="bi bi-clock-history me-1 text-secondary"></i>Hora de Fecho
                                    </label>
                                    <input type="time" class="form-control" id="hora_fecho" name="hora_fecho" required
                                           value="<?= htmlspecialchars($horaFechoVal) ?>">
                                </div>

                                <div class="col-12">
                                    <label for="nova_pass" class="form-label">
                                        <i class="bi bi-lock me-1 text-secondary"></i>Nova Password <span class="text-muted">(opcional)</span>
                                    </label>
                                    <input type="password" class="form-control" id="nova_pass" name="nova_pass"
                                           placeholder="Deixe em branco para manter a password atual">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="index.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Guardar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Zona de apagar conta -->
                <div class="card border-danger shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-exclamation-octagon me-2"></i>Apagar Conta
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <div>
                            <p class="mb-0 text-muted">
                                Esta ação remove permanentemente o registo da oficina da base de dados e não pode ser anulada.
                            </p>
                        </div>
                        <form method="POST" action="" onsubmit="return confirm('Tem a certeza de que pretende apagar permanentemente esta conta?');">
                            <input type="hidden" name="acao" value="apagar">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash3 me-1"></i>Apagar Conta
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>