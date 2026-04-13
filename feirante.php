<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Feirante | XepaViva</title>
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
                <button id="highContrastToggle" class="btn btn-outline-light me-2">
                    <i class="bi bi-sun"></i>
                    <span class="d-none d-sm-inline">Alto Contraste</span>
                </button>
                <a href="index.php" class="btn btn-outline-light">Sair</a>
            </div>
        </div>
    </header>

    <nav class="bg-light border-bottom">
        <div class="container d-flex justify-content-center">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="feirante.php" class="nav-link active" aria-current="page">Painel</a></li>
                <li class="nav-item"><a href="minhas-ofertas.php" class="nav-link">Minhas Ofertas</a></li>
                <li class="nav-item"><a href="cadastrar_oferta.php" class="nav-link">Cadastrar</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mt-4">
        <!-- KPIs de Impacto -->
        <section class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-cash-coin"></i> Receita com a Xepa</h5>
                        <p class="card-text fs-4 fw-bold">R$ 150,00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-box-seam"></i> Alimentos Salvos</h5>
                        <p class="card-text fs-4 fw-bold">35 Kg</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-cart-check"></i> Kits Reservados Hoje</h5>
                        <p class="card-text fs-4 fw-bold">15</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gráfico e Ação Rápida -->
        <section class="row mb-4">
            <div class="col-md-8 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Receita por Semana</h5>
                        <div style="position: relative; height: 300px;">
                            <canvas id="receitaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <h5 class="card-title">Pronto para vender mais?</h5>
                        <a href="cadastrar_oferta.php" class="btn btn-primary btn-lg">
                            <i class="bi bi-plus-circle"></i> Anunciar Nova Xepa
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gerenciamento de Ofertas -->
        <section>
            <h2 class="h3 mb-3">Gerenciamento Rápido de Ofertas</h2>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Tomate Italiano</h5>
                            <span class="badge bg-success">10 Reservas</span>
                        </div>
                        <div class="btn-group">
                            <a href="#" class="btn btn-outline-secondary"><i class="bi bi-pencil"></i> <span class="d-none d-sm-inline">Editar</span></a>
                            <a href="#" class="btn btn-outline-danger"><i class="bi bi-trash"></i> <span class="d-none d-sm-inline">Excluir</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="mt-5 text-muted text-center">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/utilidades.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script>

            // Gráfico de Receita por Semana
            const ctx = document.getElementById('receitaChart').getContext('2d');
            const receitaChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
                    datasets: [{
                        label: 'Receita (R$)',
                        data: [50, 75, 120, 150],
                        backgroundColor: 'rgba(25, 135, 84, 0.2)',
                        borderColor: 'rgba(25, 135, 84, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: { y: { beginAtZero: true } },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
</body>
</html>
