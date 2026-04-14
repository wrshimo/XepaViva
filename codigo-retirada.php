<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Retirada | XepaViva</title>
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
                <a href="index.php" class="btn btn-outline-light" style="min-height: 44px;">Sair</a>
            </div>
        </div>
    </header>

    <nav class="bg-light border-bottom">
        <div class="container d-flex justify-content-center">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="consumidor.php" class="nav-link">Painel</a></li>
                <li class="nav-item"><a href="buscar-ofertas.php" class="nav-link">Buscar Ofertas</a></li>
                <li class="nav-item"><a href="minhas-reservas.php" class="nav-link active" aria-current="page">Minhas Reservas</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="bg-light">
        <div class="container">
            <ol class="breadcrumb py-2 mb-0">
                <li class="breadcrumb-item"><a href="consumidor.php">Painel</a></li>
                <li class="breadcrumb-item"><a href="minhas-reservas.php">Minhas Reservas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Código de Retirada</li>
            </ol>
        </div>
    </nav>

    <main class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card text-center shadow-lg">
                    <div class="card-header bg-success text-white">
                        <h2 class="h4 mb-0">Sua Reserva foi Confirmada!</h2>
                    </div>
                    <div class="card-body p-4">
                        <p class="card-text">Mostre este código para o feirante para retirar o seu kit.</p>
                        
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=XEPAVIVA-RESERVA-ID-12345" class="img-fluid my-3" alt="QR Code de Retirada">
                        
                        <h3 class="h1 fw-bold text-success">XV-12345</h3>

                        <div class="text-start mt-4">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Produto:</strong> 
                                    <span>Kit de Tomate Italiano</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Feirante:</strong> 
                                    <span>Seu Benedito</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Local:</strong> 
                                    <span>Feira da Vila Madalena</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Retirar até:</strong> 
                                    <span>Hoje, 13:00</span>
                                </li>
                            </ul>
                        </div>
                        
                        <a href="minhas-reservas.php" class="btn btn-outline-secondary mt-4 w-100">Voltar para Minhas Reservas</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-5 text-muted text-center">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
</body>
</html>
