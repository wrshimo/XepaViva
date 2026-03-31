<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Consumidor | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>

    <header class="navbar navbar-dark bg-success sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="consumidor.php">
                <img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="120">
            </a>
            <div class="d-flex">
                <a href="index.php" class="btn btn-outline-light">Sair</a>
            </div>
        </div>
    </header>

    <nav class="bg-light border-bottom">
        <div class="container d-flex justify-content-center">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="consumidor.php" class="nav-link active" aria-current="page">Painel</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Buscar Ofertas</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Minhas Reservas</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mt-4">
        <!-- KPIs de Impacto Pessoal -->
        <section class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-currency-dollar text-success"></i> Sua Economia Total</h5>
                        <p class="card-text fs-4 fw-bold">R$ 45,00</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-leaf text-primary"></i> Alimentos que Você Salvou</h5>
                        <p class="card-text fs-4 fw-bold">12 Kg</p>
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
                         <a href="#" class="btn btn-success" style="min-height: 44px;">Ver Código de Retirada</a>
                     </div>
                 </div>
             </div>
        </section>

        <!-- Ofertas Próximas -->
        <section>
            <h2 class="h3 mb-3">Ofertas Fresquinhas Perto de Você</h2>
            <div class="card mb-3 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="https://placehold.co/300x200/198754/FFFFFF?text=Banana" class="img-fluid rounded-start" alt="Foto da Banana Prata">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Banana Prata</h5>
                            <p class="card-text"><small class="text-muted">Feirante: Dona Maria | Feira de Pinheiros</small></p>
                            <p class="card-text fs-5 fw-bold text-success">R$ 5,00</p>
                            <a href="detalhe_oferta.php" class="btn btn-outline-success" style="min-height: 44px;">Ver Detalhes e Reservar</a>
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
</body>
</html>
