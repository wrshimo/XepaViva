<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Ofertas | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/high-contrast.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>

    <!-- Header e Menu Dinâmico -->
    <header id="main-header">
        <!-- O conteúdo do header (logo, botões) será injetado aqui pelo auth.js -->
    </header>

    <main class="container mt-4">
        <h1 class="h2 mb-4">Encontre Xepas Fresquinhas</h1>

        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="search" id="filtroBusca" class="form-control" placeholder="Busque por produto ou feirante...">
            </div>
            <div class="col-md-4">
                <!-- O dropdown de categorias será populado dinamicamente -->
                <select id="filtroCategoria" class="form-select">
                    <option value="" selected>Todas as categorias</option>
                </select>
            </div>
            <div class="col-md-2">
                <button id="btnLimparFiltros" class="btn btn-outline-secondary w-100">Limpar</button>
            </div>
        </div>

        <!-- Resultados -->
        <div id="ofertas-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Indicador de Carregamento -->
            <div id="loading-indicator" class="text-center w-100">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p>Buscando ofertas...</p>
            </div>
            <!-- O conteúdo dinâmico (cards de ofertas) será inserido aqui -->
        </div>

    </main>

    <!-- MODAL DE CONFIRMAÇÃO DE RESERVA -->
    <div class="modal fade" id="reservaModal" tabindex="-1" aria-labelledby="reservaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reservaModalLabel">Confirmar Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Você está reservando: <strong id="modal-oferta-nome"></strong></p>
                    <div class="mb-3">
                        <label for="modal-quantidade" class="form-label">Quantidade de kits:</label>
                        <input type="number" class="form-control" id="modal-quantidade" value="1" min="1">
                    </div>
                    <div id="modal-feedback"></div> <!-- Para mensagens de erro ou sucesso -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btn-confirmar-reserva">Confirmar Reserva</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM DO MODAL -->

    <footer class="mt-5 text-muted text-center">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/auth.js"></script>
    <script src="assets/js/buscar-ofertas.js"></script>
</body>
</html>
