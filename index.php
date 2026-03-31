<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | XepaViva</title>
    <meta name="description" content="Acesse sua conta ou cadastre-se no XepaViva para comprar ou vender alimentos frescos.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="container text-center" style="max-width: 480px;">
        <header>
            <img src="assets/images/logo.svg" alt="Logo do XepaViva" class="mb-4" width="200">
            <h1 class="h3 mb-3 fw-normal">Bem-vindo(a) ao XepaViva!</h1>
            <p class="mb-4">Conectando feirantes e consumidores para reduzir o desperdício de alimentos.</p>
        </header>

        <main>
            <div class="card p-4">
                <div class="card-body">
                    <h2 class="h4 mb-4">Selecione seu perfil para continuar</h2>
                    <div class="d-grid gap-3">
                        <a href="feirante.php" class="btn btn-primary btn-lg" style="min-height: 44px;">
                            <i class="bi bi-shop"></i> Sou Feirante
                        </a>
                        <a href="consumidor.php" class="btn btn-success btn-lg" style="min-height: 44px;">
                            <i class="bi bi-cart3"></i> Sou Consumidor
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <footer class="mt-5 text-muted">
            <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
