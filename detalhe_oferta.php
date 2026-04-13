<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Oferta | XepaViva</title>
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
            <div class="d-flex">
                <button id="highContrastToggle" class="btn btn-outline-light me-2" style="min-height: 44px;">
                    <i class="bi bi-sun"></i>
                    <span class="d-none d-sm-inline">Alto Contraste</span>
                </button>
            </div>
        </div>
    </header>

    <main class="container mt-4" style="max-width: 720px;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="consumidor.php">Painel</a></li>
                <li class="breadcrumb-item"><a href="#buscar">Ofertas</a></li>
                <li class="breadcrumb-item active">Tomate Italiano</li>
            </ol>
        </nav>

        <!-- Imagem do produto -->
        <div class="text-center mb-4">
            <img src="https://placehold.co/600x400/198754/FFFFFF?text=Tomate+Italiano" class="img-fluid rounded shadow-sm" alt="Foto do Tomate Italiano">
        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title h3">Tomate Italiano</h1>
                <p class="card-text text-muted">Publicado por: Seu Benedito</p>
                <p class="card-text"><strong>Localização:</strong> Feira da Vila Madalena</p>
                <p class="card-text"><strong>Descrição:</strong> Caixa com aproximadamente 5kg de tomates maduros, ideais para molhos.</p>
                <p class="display-6 text-success fw-bold">R$ 10,00</p>

                <div class="d-grid mt-4">
                    <a href="#" class="btn btn-success btn-lg" style="min-height: 44px;">Reservar Kit</a>
                </div>
            </div>
        </div>

    </main>

    <footer class="mt-5 text-muted text-center">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/utilidades.js"></script>
    <script src="assets/js/high-contrast.js"></script>
</body>
</html>
