<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Consumidor | XepaViva</title>
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
                <li class="nav-item"><a href="consumidor.php" class="nav-link active" aria-current="page">Painel</a></li>
                <li class="nav-item"><a href="buscar-ofertas.php" class="nav-link">Buscar Ofertas</a></li>
                <li class="nav-item"><a href="minhas-reservas.php" class="nav-link">Minhas Reservas</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mt-4">
        <!-- KPIs de Impacto Pessoal -->
        <section class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-currency-dollar text-success"></i> Sua Economia Total</h5>
                        <p class="card-text fs-4 fw-bold">R$ 45,00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card text-center shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-leaf text-primary"></i> Alimentos que Você Salvou</h5>
                        <p class="card-text fs-4 fw-bold">12 Kg</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Gráfico de Impacto -->
        <section class="mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Sua Economia ao Longo do Tempo</h5>
                    <div class="chart-container" style="position: relative; height:300px">
                        <canvas id="graficoEconomiaConsumidor"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <!-- Minhas Reservas Ativas -->
        <section class="mb-4">
             <h2 class="h3 mb-3">Minhas Reservas Ativas</h2>
             <div class="card mb-3 shadow-sm">
                 <div class="card-body">
                     <div class="d-flex justify-content-between align-items-center">
                         <div>
                            <h5 class="card-title mb-1">Kit de Tomate Italiano</h5>
                            <p class="card-text mb-0"><small class="text-muted">Feirante: Seu Benedito | Retirar na Feira da Vila Madalena</small></p>
                         </div>
                         <a href="codigo-retirada.php" class="btn btn-success" style="min-height: 44px;">Ver Código de Retirada</a>
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
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('graficoEconomiaConsumidor').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'Economia (R$)',
                        data: [12, 19, 3, 5, 2, 3],
                        borderColor: '#2ECC71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
