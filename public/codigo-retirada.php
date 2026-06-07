<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Consumidor') {
    header("Location: login.php");
    exit();
}

$reserva_id = isset($_GET['reserva_id']) ? htmlspecialchars($_GET['reserva_id']) : 0;

$pageTitle = "Código de Retirada";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/high-contrast.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
    <style>
        .qr-code-container {
            width: 280px;
            height: 280px;
            padding: 10px;
            background-color: #fff;
            border-radius: 1rem;
        }
    </style>
</head>
<body>
    <?php include 'layout/header_consumidor.php'; ?>

    <main class="container mt-4 text-center">
        <div id="loading-state">
            <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="mt-2">Carregando dados da reserva...</p>
        </div>

        <div id="error-state" class="d-none">
             <i class="bi bi-x-circle-fill text-danger fs-1"></i>
             <h1 class="h3 mt-3">Reserva não encontrada</h1>
             <p class="text-muted">Não foi possível encontrar os dados da sua reserva. Por favor, <a href="minhas-reservas.php">volte à lista</a> e tente novamente.</p>
        </div>

        <div id="success-state" class="d-none">
            <h1 class="h3 mb-2">Código de Retirada</h1>
            <p class="lead mb-4">Apresente este código ao feirante para retirar seu kit.</p>

            <div class="d-flex justify-content-center mb-4">
                <div id="qrcode" class="qr-code-container shadow"></div>
            </div>

            <div class="card shadow-sm mx-auto" style="max-width: 400px;">
                <div class="card-body">
                    <h5 class="card-title">Seu Código</h5>
                    <p id="codigo-retirada-text" class="display-4 font-monospace text-success fw-bold"></p>
                    <ul class="list-group list-group-flush text-start">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Produto:</span>
                            <strong id="oferta-nome"></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Feirante:</span>
                            <strong id="feirante-nome"></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Status:</span>
                            <strong id="reserva-status"></strong>
                        </li>
                    </ul>
                </div>
            </div>

            <p class="mt-4"><a href="minhas-reservas.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Voltar para Minhas Reservas</a></p>
        </div>
    </main>

    <?php include 'layout/footer.php'; ?>

    <!-- Biblioteca para gerar o QR Code -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/codigo-retirada.js" data-reserva-id="<?php echo $reserva_id; ?>"></script>
</body>
</html>
