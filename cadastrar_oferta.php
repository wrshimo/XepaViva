<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Oferta | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>
    <header class="navbar navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="feirante.php">
                <img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="120">
            </a>
        </div>
    </header>

    <main class="container mt-4" style="max-width: 600px;">
        <h1 class="h2 mb-4">Cadastrar Nova Xepa</h1>
        <form action="feirante.php" method="post">
            <div class="mb-3">
                <label for="nome_produto" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control" id="nome_produto" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" class="form-control" id="preco" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto do Produto</label>
                <input class="form-control" type="file" id="foto">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg" style="min-height: 44px;">Publicar Oferta</button>
                <a href="feirante.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </main>

    <footer class="mt-5 text-muted text-center">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
