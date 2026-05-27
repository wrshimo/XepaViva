<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define um título padrão se não for especificado
$pageTitle = isset($pageTitle) ? $pageTitle : "Painel do Consumidor";

// Determina a página ativa para o menu de navegação
$activePage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Caminho para o CSS deve ser relativo à raiz do site ou absoluto -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/high-contrast.css" rel="stylesheet">
    <link rel="icon" href="/assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>

    <header class="navbar navbar-dark bg-success sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="consumidor.php">
                <img src="/assets/images/logo-white.svg" alt="Logo XepaViva" width="120">
            </a>
            <div class="d-flex align-items-center">
                 <button id="highContrastToggle" class="btn btn-outline-light me-2 d-flex align-items-center" style="min-height: 44px; min-width: 44px;">
                    <i class="bi bi-sun"></i>
                    <span class="d-none d-sm-inline ms-1">Alto Contraste</span>
                </button>
                <a href="logout.php" class="btn btn-outline-light d-flex align-items-center" style="min-height: 44px;">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    <span class="d-none d-sm-inline">Sair</span>
                </a>
            </div>
        </div>
    </header>

    <nav class="bg-light border-bottom">
        <div class="container d-flex justify-content-center">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="consumidor.php" class="nav-link <?php echo ($activePage == 'consumidor.php') ? 'active' : ''; ?>" <?php echo ($activePage == 'consumidor.php') ? 'aria-current="page"' : ''; ?>>Painel</a></li>
                <li class="nav-item"><a href="buscar-ofertas.php" class="nav-link <?php echo ($activePage == 'buscar-ofertas.php') ? 'active' : ''; ?>" <?php echo ($activePage == 'buscar-ofertas.php') ? 'aria-current="page"' : ''; ?>>Buscar Ofertas</a></li>
                <li class="nav-item"><a href="minhas-reservas.php" class="nav-link <?php echo ($activePage == 'minhas-reservas.php') ? 'active' : ''; ?>" <?php echo ($activePage == 'minhas-reservas.php') ? 'aria-current="page"' : ''; ?>>Minhas Reservas</a></li>
            </ul>
        </div>
    </nav>
