<?php
session_start();

// ID do feirante logado (deve vir da sessão)
// Para fins de desenvolvimento, usamos 1 se não estiver logado.
$feirante_id = $_SESSION['usuario_id'] ?? 1;

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
    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1081"></div>
    <header class="navbar navbar-dark bg-success sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="feirante.php"><img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="120"></a>
            <div class="d-flex align-items-center">
                <button id="highContrastToggle" class="btn btn-outline-light me-2"><i class="bi bi-sun"></i></button>
                <a href="index.php" class="btn btn-outline-light">Sair</a>
            </div>
        </div>
    </header>
    <nav class="bg-light border-bottom">
        <div class="container d-flex justify-content-center">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="feirante.php" class="nav-link">Painel</a></li>
                <li class="nav-item"><a href="minhas-ofertas.php" class="nav-link active" aria-current="page">Minhas Ofertas</a></li>
            </ul>
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
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaOfertas">
                    <!-- Linhas da tabela serão inseridas aqui dinamicamente -->
                </tbody>
            </table>
             <div id="ofertas-placeholder" class="text-center py-5" style="display: none;">
                <div class="spinner-border text-success" role="status"><span class="visually-hidden">Carregando...</span></div>
                <p class="mt-2">Buscando suas ofertas...</p>
            </div>
        </div>
    </main>

    <!-- Modal de Oferta -->
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
    
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza de que deseja excluir a oferta <strong id="nomeProdutoExclusao"></strong>? Esta ação não pode ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 text-muted text-center"><p>&copy; 2026 XepaViva. Todos os direitos reservados.</p></footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/toast.js"></script>
    <script src="assets/js/gerenciar-ofertas.js"></script>
</body>
</html>
