<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Feirante') {
    header("Location: login.php");
    exit();
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Feirante';
$pageTitle = "Painel do Feirante";

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
</head>
<body>

    <?php include 'layout/header_feirante.php'; ?>

    <main class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="p-5 mb-4 bg-light rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">Boas-vindas, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
                        <p class="col-md-8 fs-4">Este é o seu painel de controle. Use o menu para gerenciar suas ofertas e reservas.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center g-4">
             <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title"><i class="bi bi-basket-fill text-success"></i></h2>
                        <h3 class="display-6">15</h3>
                        <p class="card-text">Ofertas Ativas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title"><i class="bi bi-check-circle-fill text-primary"></i></h2>
                        <h3 class="display-6">8</h3>
                        <p class="card-text">Reservas para Hoje</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title"><i class="bi bi-people-fill text-info"></i></h2>
                        <h3 class="display-6">120</h3>
                        <p class="card-text">Clientes Atendidos</p>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include 'layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
</body>
</html>
