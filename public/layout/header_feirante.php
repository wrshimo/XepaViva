<?php
// /public/layout/header_feirante.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nome_usuario = $_SESSION['usuario_nome'] ?? 'Feirante';
$current_page = basename($_SERVER['PHP_SELF']);
$pageTitle = $pageTitle ?? 'XepaViva'; // Fallback para o título da página

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - XepaViva</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- High Contrast CSS - Carregado via JS -->
    <link rel="stylesheet" href="assets/css/high-contrast.css" id="highContrastStylesheet" disabled>

    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="feirante.php">
                <img src="assets/images/favicon.svg" alt="" width="30" height="24" class="d-inline-block align-text-top">
                XepaViva
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'feirante.php') ? 'active' : ''; ?>" href="feirante.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'minhas-ofertas.php') ? 'active' : ''; ?>" href="minhas-ofertas.php">Minhas Ofertas</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'gerenciar-reservas.php') ? 'active' : ''; ?>" href="gerenciar-reservas.php">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'validar-retirada.php') ? 'active' : ''; ?>" href="validar-retirada.php">Validar Retirada</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill"></i> <?php echo htmlspecialchars($nome_usuario); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="logout.php">Sair</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <button id="highContrastToggle" class="btn btn-outline-light btn-sm" style="min-width: 44px; min-height: 44px;">
                            <i class="bi bi-circle-half"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div style="height: 70px;"></div> <!-- Spacer for fixed-top navbar -->
