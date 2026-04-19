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

    <header class="navbar navbar-dark bg-success sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="consumidor.php">
                <img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="120">
            </a>
            <div class="d-flex align-items-center">
                <button id="highContrastToggle" class="btn btn-outline-light me-2">
                    <i class="bi bi-sun"></i>
                </button>
                <a href="index.php" class="btn btn-outline-light">Sair</a>
            </div>
        </div>
    </header>

    <nav class="bg-light border-bottom">
        <div class="container d-flex justify-content-center">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="consumidor.php" class="nav-link">Painel</a></li>
                <li class="nav-item"><a href="buscar-ofertas.php" class="nav-link active" aria-current="page">Buscar Ofertas</a></li>
                <li class="nav-item"><a href="minhas-reservas.php" class="nav-link">Minhas Reservas</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mt-4">
        <h1 class="h2 mb-4">Encontre Xepas Fresquinhas</h1>

        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="search" id="filtroBusca" class="form-control" placeholder="Busque por produto ou feirante...">
            </div>
            <div class="col-md-4">
                <select id="filtroCategoria" class="form-select">
                    <option value="" selected>Filtrar por categoria...</option>
                    <option value="Frutas">Frutas</option>
                    <option value="Legumes">Legumes</option>
                    <option value="Verduras">Verduras</option>
                </select>
            </div>
            <div class="col-md-2">
                <button id="btnBuscar" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>

        <!-- Resultados -->
        <div id="ofertas-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- O conteúdo dinâmico será inserido aqui pelo JavaScript -->
            <!-- Placeholder de carregamento -->
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <p class="mt-2">Buscando ofertas...</p>
            </div>
        </div>

    </main>

    <footer class="mt-5 text-muted text-center">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        // Inicializa a página de busca de ofertas quando o DOM estiver pronto.
        document.addEventListener('DOMContentLoaded', () => {
            initBuscarOfertas();
        });
    </script>
</body>
</html>