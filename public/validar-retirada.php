<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Feirante') {
    header("Location: login.php");
    exit();
}

$pageTitle = "Validar Retirada";
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
        #reader {
            width: 100%;
            max-width: 500px;
            border: 2px dashed #0b5ed7;
            border-radius: .5rem;
        }
        .scan-active #manual-input-section {
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'layout/header_feirante.php'; ?>

    <main class="container my-4" id="validation-container">
        <h1 class="h3 mb-3">Validar Código de Retirada</h1>

        <!-- Seção de Input Manual -->
        <section id="manual-input-section">
            <div class="input-group mb-3">
                <input type="text" id="codigo-input" class="form-control form-control-lg" placeholder="Digite o código (ex: XV-A4B8)" aria-label="Código de Retirada">
                <button class="btn btn-primary" type="button" id="validar-btn">Validar Código</button>
            </div>
            <div class="text-center">
                <button class="btn btn-outline-primary" type="button" id="start-scan-btn">
                    <i class="bi bi-qr-code-scan me-2"></i>Escanear QR Code
                </button>
            </div>
        </section>

        <!-- Seção do Scanner -->
        <section id="scanner-section" class="d-none text-center">
            <div id="reader" class="mx-auto mb-3"></div>
            <button class="btn btn-secondary" type="button" id="stop-scan-btn">Parar Leitura</button>
        </section>

        <!-- Seção de Resultado -->
        <section id="result-section" class="mt-4"></section>

    </main>

    <?php include 'layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Biblioteca para escanear QR Code -->
    <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/validar-retirada.js"></script>
</body>
</html>
