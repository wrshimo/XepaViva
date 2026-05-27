<?php
session_start();

// Segurança: Redireciona para o login se o usuário não estiver logado ou não for um Feirante.
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Feirante') {
    header("Location: login.php");
    exit();
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Feirante';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Feirante | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="./assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="feirante.php">
                <img src="./assets/images/logo-white.svg" alt="XepaViva" width="120">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="feirante.php"><i class="bi bi-house-door-fill me-1"></i>Início</a>
                    </li>
                    <!-- ITEM REMOVIDO -->
                    <li class="nav-item">
                        <a class="nav-link" href="minhas-ofertas.php"><i class="bi bi-list-check me-1"></i>Minhas Ofertas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="p-5 mb-4 bg-light rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">Boas-vindas, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
                        <!-- MENSAGEM AJUSTADA -->
                        <p class="col-md-8 fs-4">Este é o seu painel de controle. Acesse "Minhas Ofertas" para anunciar e gerenciar seus produtos.</p>
                        <!-- BOTÃO REMOVIDO -->
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

    <footer class="text-center py-4 bg-light mt-5">
        <p>&copy; 2024 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>