<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Nova Xepa | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#2ECC71">
</head>
<body>

    <header class="navbar navbar-dark bg-dark sticky-top">
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
                <li class="nav-item"><a href="feirante.php" class="nav-link">Painel</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Minhas Ofertas</a></li>
                <li class="nav-item"><a href="cadastrar_oferta.php" class="nav-link active" aria-current="page">Cadastrar</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Anunciar Nova Xepa</h2>
                        <form>
                            <div class="mb-3">
                                <label for="produtoNome" class="form-label">Nome do Produto</label>
                                <input type="text" class="form-control" id="produtoNome" placeholder="Ex: Tomate Italiano (kit)" required>
                            </div>
                            <div class="mb-3">
                                <label for="produtoPreco" class="form-label">Preço do Kit (R$)</label>
                                <input type="number" class="form-control" id="produtoPreco" placeholder="5.00" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="produtoPeso" class="form-label">Peso Estimado (Kg)</label>
                                <input type="number" class="form-control" id="produtoPeso" placeholder="2.5" step="0.1" required>
                            </div>
                            <div class="mb-3">
                                <label for="produtoCategoria" class="form-label">Categoria</label>
                                <select class="form-select" id="produtoCategoria" required>
                                    <option selected disabled value="">Selecione uma categoria...</option>
                                    <option>Frutas</option>
                                    <option>Legumes</option>
                                    <option>Verduras</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="produtoFoto" class="form-label">Foto do Produto</label>
                                <input class="form-control" type="file" id="produtoFoto" accept="image/*">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Publicar Anúncio</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-5 text-muted text-center">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const highContrastToggle = document.getElementById('highContrastToggle');
            const body = document.body;

            // Verifica o estado no LocalStorage e aplica o tema
            if (localStorage.getItem('highContrast') === 'true') {
                body.classList.add('high-contrast');
            }

            // Alterna o tema e salva o estado
            highContrastToggle.addEventListener('click', () => {
                body.classList.toggle('high-contrast');
                localStorage.setItem('highContrast', body.classList.contains('high-contrast'));
            });
        });
    </script>
</body>
</html>
