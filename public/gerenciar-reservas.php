<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Feirante') {
    header("Location: login.php");
    exit();
}

$feirante_id = $_SESSION['usuario_id'];
$pageTitle = "Gerenciar Reservas";

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
    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <main class="container mt-4">
        <input type="hidden" id="feiranteIdLogado" value="<?php echo htmlspecialchars($feirante_id); ?>">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h2">Gerenciar Reservas</h1>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Filtrar por Status</h5>
                <div id="filtroStatus" class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-2">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusPendente" value="Pendente" checked>
                            <label class="form-check-label" for="statusPendente">Pendente</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusConfirmada" value="Confirmada" checked>
                            <label class="form-check-label" for="statusConfirmada">Confirmada</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusAguardando" value="Aguardando Retirada" checked>
                            <label class="form-check-label" for="statusAguardando">Aguardando Retirada</label>
                        </div>
                    </div>
                     <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusConcluida" value="Concluida">
                            <label class="form-check-label" for="statusConcluida">Concluída</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusCanceladaConsumidor" value="Cancelada pelo Consumidor">
                            <label class="form-check-label" for="statusCanceladaConsumidor">Cancelada (cliente)</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusCanceladaFeirante" value="Cancelada pelo Feirante">
                            <label class="form-check-label" for="statusCanceladaFeirante">Cancelada (você)</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusNaoCompareceu" value="Nao Compareceu">
                            <label class="form-check-label" for="statusNaoCompareceu">Não Compareceu</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="statusExpirada" value="Expirada">
                            <label class="form-check-label" for="statusExpirada">Expirada</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Cliente</th>
                        <th>Produto</th>
                        <th>Qtd.</th>
                        <th>Código</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaReservas"></tbody>
            </table>
             <div id="reservas-placeholder" class="text-center py-5"></div>
        </div>
    </main>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmacaoModal" tabindex="-1" aria-labelledby="confirmacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmacaoModalLabel">Confirmar Ação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="confirmacaoModalBody">
                    Tem certeza que deseja continuar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmarAcao">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'layout/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/toast.js"></script>
    <script src="assets/js/gerenciar-reservas.js"></script>
</body>
</html>