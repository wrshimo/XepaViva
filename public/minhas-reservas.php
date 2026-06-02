<?php
// Garante que a sessão seja iniciada antes de qualquer saída de HTML.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado e se é um consumidor.
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Consumidor') {
    // Se não estiver, redireciona para a página de login.
    header("Location: login.php");
    exit();
}

// Define o título da página para ser usado no header.
$pageTitle = "Minhas Reservas";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Reservas | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/high-contrast.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>
    <?php 
    // Inclui o cabeçalho padrão do consumidor. 
    // O session_start() dentro dele não causará mais erro, pois a sessão já foi iniciada.
    include 'layout/header_consumidor.php'; 
    ?>

    <main class="container mt-4">
        <h1 class="h2 mb-4">Minhas Reservas</h1>
        
        <!-- Container principal que será populado pelo JavaScript -->
        <div id="reservations-container" class="row">
            <!-- 1. Indicador de Carregamento -->
            <div id="loading-spinner" class="col-12 text-center py-5">
                <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p class="mt-2">Buscando suas reservas...</p>
            </div>
        </div>

        <!-- 2. Mensagem para quando não houver reservas -->
        <div id="no-reservations-message" class="col-12 text-center py-5 d-none">
            <i class="bi bi-journal-x fs-1 text-muted"></i>
            <h2 class="h4 mt-3">Nenhuma reserva encontrada</h2>
            <p class="text-muted">Você ainda não fez nenhuma reserva. Que tal <a href="buscar-ofertas.php">buscar algumas ofertas</a>?</p>
        </div>

    </main>

    <?php include 'layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/minhas-reservas.js"></script>
</body>
</html>
