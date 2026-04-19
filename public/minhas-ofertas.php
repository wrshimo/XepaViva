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
                <li class="nav-item"><a href="cadastrar_oferta.php" class="nav-link">Cadastrar</a></li>
            </ul>
        </div>
    </nav>
    <main class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2">Minhas Ofertas</h1>
            <a href="cadastrar_oferta.php" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Anunciar Nova Xepa</a>
        </div>
        <div id="minhas-ofertas-container">
            <!-- O conteúdo dinâmico será inserido aqui pelo JavaScript -->
            <div class="text-center py-5">
                <div class="spinner-border text-success" role="status"><span class="visually-hidden">Carregando...</span></div>
                <p class="mt-2">Buscando suas ofertas...</p>
            </div>
        </div>
    </main>
    <footer class="mt-5 text-muted text-center"><p>&copy; 2026 XepaViva. Todos os direitos reservados.</p></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Simula o ID do feirante logado.
            const feiranteIdLogado = 1;
            initMinhasOfertas(feiranteIdLogado);
        });
    </script>
</body>
</html>