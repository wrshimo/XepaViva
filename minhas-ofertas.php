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
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#2ECC71">
</head>
<body>

    <header class="navbar navbar-dark bg-success sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="feirante.php">
                <img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="120">
            </a>
            <div class="d-flex align-items-center">
                <button id="highContrastToggle" class="btn btn-outline-light me-2" style="min-height: 44px;">
                    <i class="bi bi-sun"></i>
                    <span class="d-none d-sm-inline">Alto Contraste</span>
                </button>
                <a href="index.php" class="btn btn-outline-light" style="min-height: 44px;">Sair</a>
            </div>
        </div>
    </header>

    <nav class="bg-light border-bottom">
        <div class="container d-flex justify-content-center">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="feirante.php" class="nav-link" style="min-height: 44px;">Painel</a></li>
                <li class="nav-item"><a href="minhas-ofertas.php" class="nav-link active" aria-current="page" style="min-height: 44px;">Minhas Ofertas</a></li>
                <li class="nav-item"><a href="cadastrar_oferta.php" class="nav-link" style="min-height: 44px;">Cadastrar</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mt-4">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="feirante.php">Painel</a></li>
                <li class="breadcrumb-item active">Minhas Ofertas</li>
            </ol>
        </nav>

        <!-- Cabeçalho -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="h2 mb-2"><i class="bi bi-bag-check"></i> Minhas Ofertas</h1>
                <p class="text-muted">Gerencie suas xepas publicadas</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="cadastrar_oferta.php" class="btn btn-primary" style="min-height: 44px;">
                    <i class="bi bi-plus-circle"></i> Anunciar Nova Xepa
                </a>
            </div>
        </div>

        <!-- Filtros (opcional) -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-4">
                        <label for="filtroStatus" class="form-label">Filtrar por Status:</label>
                        <select class="form-select" id="filtroStatus" style="min-height: 44px;">
                            <option value="">Todas</option>
                            <option value="Disponível">Disponível</option>
                            <option value="Reservado">Reservado</option>
                            <option value="Vendido">Vendido</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button class="btn btn-outline-primary" id="btnAplicarFiltro" style="min-height: 44px;">
                            <i class="bi bi-search"></i> Filtrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Ofertas -->
        <div id="containerOfertas">
            <!-- Será preenchido por JavaScript -->
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="text-center py-5" style="display: none;">
            <div class="empty-state p-5 rounded">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #999;"></i>
                <h3 class="mt-3">Nenhuma oferta publicada</h3>
                <p class="text-muted">Comece a vender seus excedentes agora!</p>
                <a href="cadastrar_oferta.php" class="btn btn-primary" style="min-height: 44px;">
                    <i class="bi bi-plus-circle"></i> Publicar Primeira Xepa
                </a>
            </div>
        </div>

    </main>

    <footer class="mt-5 text-muted text-center py-4">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/utilidades.js"></script>
    <script src="assets/js/high-contrast.js"></script>

    <script>
        /**
         * Página: Minhas Ofertas (Feirante)
         * Carrega e exibe ofertas do feirante mockado
         */

        // Dados mockados - Será substituído por API real no Sprint 1
        const ofertas = [
            {
                id: 1,
                nome: "Tomate Italiano",
                categoria: "Legumes",
                preco: 5.00,
                peso: 2.5,
                status: "Disponível",
                reservas: 10,
                data_criacao: "2026-04-13T10:30:00Z"
            },
            {
                id: 2,
                nome: "Cenoura Prata",
                categoria: "Legumes",
                preco: 3.50,
                peso: 3.0,
                status: "Disponível",
                reservas: 5,
                data_criacao: "2026-04-13T09:15:00Z"
            }
        ];

        // Inicializar ao carregar
        document.addEventListener('DOMContentLoaded', () => {
            renderizarOfertas(ofertas);
        });

        // Aplicar filtro
        document.getElementById('btnAplicarFiltro').addEventListener('click', () => {
            const status = document.getElementById('filtroStatus').value;
            const ofertasFiltradas = status ? 
                ofertas.filter(o => o.status === status) : 
                ofertas;
            renderizarOfertas(ofertasFiltradas);
        });

        /**
         * Renderiza lista de ofertas
         */
        function renderizarOfertas(lista) {
            const container = document.getElementById('containerOfertas');
            const emptyState = document.getElementById('emptyState');

            if (lista.length === 0) {
                container.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';
            container.innerHTML = lista.map(oferta => `
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title mb-2">
                                    ${oferta.nome}
                                    <span class="badge ${oferta.status === 'Disponível' ? 'bg-success' : 'bg-warning'}">
                                        ${oferta.status}
                                    </span>
                                </h5>
                                <p class="card-text text-muted">
                                    <i class="bi bi-tag"></i> ${oferta.categoria} | 
                                    <i class="bi bi-box-fill"></i> ${oferta.peso}kg | 
                                    <i class="bi bi-cash-coin"></i> ${Util.formatarMoeda(oferta.preco)}
                                </p>
                                <p class="card-text small">
                                    <i class="bi bi-bookmark-check"></i> 
                                    <strong>${oferta.reservas} reserva(s)</strong>
                                </p>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-outline-primary me-2" 
                                        onclick="editarOferta(${oferta.id})" 
                                        style="min-height: 44px;">
                                    <i class="bi bi-pencil"></i> <span class="d-none d-sm-inline">Editar</span>
                                </button>
                                <button class="btn btn-outline-danger" 
                                        onclick="confirmarDelercao(${oferta.id})" 
                                        style="min-height: 44px;">
                                    <i class="bi bi-trash"></i> <span class="d-none d-sm-inline">Excluir</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        /**
         * Editar oferta (redirecionar para formulário)
         */
        function editarOferta(id) {
            alert('Feature em desenvolvimento: Editar oferta #' + id);
            // Será implementado em Sprint 1
        }

        /**
         * Confirmar exclusão de oferta
         */
        function confirmarDelercao(id) {
            if (confirm('Tem certeza que deseja excluir esta oferta?')) {
                const indice = ofertas.findIndex(o => o.id === id);
                if (indice > -1) {
                    ofertas.splice(indice, 1);
                    renderizarOfertas(ofertas);
                    alert('✅ Oferta excluída com sucesso!');
                }
            }
        }
    </script>

</body>
</html>
