<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Consumidor') {
    header("Location: login.php");
    exit();
}
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
    <link href="assets/css/reservas.css" rel="stylesheet"> <!-- ARQUIVO DE ESTILO ADICIONADO -->
    <link href="assets/css/high-contrast.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>
    <?php include 'layout/header_consumidor.php'; ?>

    <main class="container mt-4">
        <h1 class="h2 mb-4">Minhas Reservas</h1>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3"><i class="bi bi-funnel-fill me-2"></i>Filtrar por Status</h5>
                <div id="filtroStatusConsumidor" class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-2">
                    <div class="col">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="statusAguardando" value="Aguardando Retirada" checked>
                            <label class="form-check-label" for="statusAguardando">Aguardando Retirada</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="statusConcluida" value="Concluida">
                            <label class="form-check-label" for="statusConcluida">Concluída</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="statusCancelada" value="Cancelada pelo Consumidor,Cancelada pelo Feirante,Expirada,Nao Compareceu">
                            <label class="form-check-label" for="statusCancelada">Cancelada/Expirada</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="reservations-container" class="row">
            <div id="loading-spinner" class="col-12 text-center py-5">
                <div class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p class="mt-2">Buscando suas reservas...</p>
            </div>
        </div>

        <div id="no-reservations-message" class="col-12 text-center py-5 d-none">
            <i class="bi bi-journal-x fs-1 text-muted"></i>
            <h2 class="h4 mt-3">Nenhuma reserva encontrada</h2>
            <p class="text-muted">Você ainda não fez nenhuma reserva ou nenhuma corresponde ao filtro. Que tal <a href="buscar-ofertas.php">buscar algumas ofertas</a>?</p>
        </div>

    </main>

    <?php include 'layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/minhas-reservas.js"></script>
</body>
</html>
