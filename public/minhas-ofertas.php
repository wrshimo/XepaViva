<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Feirante') {
    header("Location: login.php");
    exit();
}

$feirante_id = $_SESSION['usuario_id'];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Ofertas | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/high-contrast.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>
    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="feirante.php"><img src="./assets/images/logo-white.svg" alt="XepaViva" width="120"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="feirante.php"><i class="bi bi-house-door-fill me-1"></i>Início</a></li>
                    <li class="nav-item"><a class="nav-link active" href="minhas-ofertas.php" aria-current="page"><i class="bi bi-list-check me-1"></i>Minhas Ofertas</a></li>
                    <li class="nav-item"><a class="nav-link" href="gerenciar-reservas.php"><i class="bi bi-calendar-check-fill me-1"></i>Gerenciar Reservas</a></li>
                    <li class="nav-item me-lg-2"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Sair</a></li>
                    <li class="nav-item mt-2 mt-lg-0"><button id="highContrastToggle" class="btn btn-outline-light"><i class="bi bi-sun"></i></button></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2">Minhas Ofertas</h1>
            <button class="btn btn-primary" style="min-width: 44px; min-height: 44px;" data-bs-toggle="modal" data-bs-target="#ofertaModal" id="btnNovaOferta">
                <i class="bi bi-plus-circle me-2"></i>Anunciar Nova Xepa
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Categoria</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaOfertas"></tbody>
            </table>
             <div id="ofertas-placeholder" class="text-center py-5"></div>
        </div>
    </main>

    <div class="modal fade" id="ofertaModal" tabindex="-1" aria-labelledby="ofertaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ofertaModalLabel">Anunciar Nova Xepa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="formOferta" novalidate>
                        <input type="hidden" id="ofertaId">
                        <input type="hidden" id="feirante_id" value="<?php echo htmlspecialchars($feirante_id); ?>">
                        <div class="mb-3"><label for="produto" class="form-label">Nome do Produto <span class="text-danger">*</span></label><input type="text" class="form-control" id="produto" placeholder="Ex: Kit de Tomates" required></div>
                        <div class="mb-3"><label for="descricao" class="form-label">Descrição</label><textarea class="form-control" id="descricao" rows="3" placeholder="Descreva os itens, estado de maturação, etc."></textarea></div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="preco" class="form-label">Preço (R$) <span class="text-danger">*</span></label><input type="number" class="form-control" id="preco" placeholder="5.00" step="0.01" required></div>
                            <div class="col-md-6 mb-3"><label for="quantidade_disponivel" class="form-label">Qtd. Disponível <span class="text-danger">*</span></label><input type="number" class="form-control" id="quantidade_disponivel" placeholder="10" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="peso" class="form-label">Peso Aproximado (Kg)</label><input type="number" class="form-control" id="peso" placeholder="2.5" step="0.1"></div>
                            <div class="col-md-6 mb-3"><label for="categoria" class="form-label">Categoria <span class="text-danger">*</span></label><select class="form-select" id="categoria" required><option value="" selected disabled>Selecione...</option></select></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formOferta" class="btn btn-primary" id="btnSalvar">Salvar Oferta</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 text-muted text-center"><p>&copy; 2024 XepaViva. Todos os direitos reservados.</p></footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/toast.js"></script>
    <script src="assets/js/gerenciar-ofertas.js"></script>
</body>
</html>