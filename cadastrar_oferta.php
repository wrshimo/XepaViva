<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Oferta | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/high-contrast.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body class="loading">
    <div class="page-loader">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>
    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>
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
                <li class="nav-item"><a href="minhas-ofertas.php" class="nav-link">Minhas Ofertas</a></li>
                <li class="nav-item"><a href="cadastrar_oferta.php" class="nav-link active" aria-current="page">Cadastrar</a></li>
            </ul>
        </div>
    </nav>
    <main class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 id="form-title" class="card-title text-center mb-4">Anunciar Nova Xepa</h2>
                        <form id="formCadastrarOferta" novalidate>
                            <input type="hidden" name="oferta_id" value="">
                            <div class="mb-3"><label for="produtoNome" class="form-label">Nome do Produto <span class="text-danger">*</span></label><input type="text" class="form-control" id="produtoNome" value="" placeholder="Ex: Kit de Tomates" required></div>
                            <div class="mb-3"><label for="produtoDescricao" class="form-label">Descrição</label><textarea class="form-control" id="produtoDescricao" rows="3" placeholder="Descreva os itens do kit, estado de maturação, etc."></textarea></div>
                            <div class="row">
                                <div class="col-md-6 mb-3"><label for="produtoPreco" class="form-label">Preço (R$) <span class="text-danger">*</span></label><input type="number" class="form-control" id="produtoPreco" value="" placeholder="5.00" step="0.01" required></div>
                                <div class="col-md-6 mb-3"><label for="produtoPeso" class="form-label">Peso (Kg) <span class="text-danger">*</span></label><input type="number" class="form-control" id="produtoPeso" value="" placeholder="2.5" step="0.1" required></div>
                            </div>
                            <div class="mb-3"><label for="produtoCategoria" class="form-label">Categoria <span class="text-danger">*</span></label><select class="form-select" id="produtoCategoria" required><option value="" disabled selected>Selecione...</option><option value="Frutas">Frutas</option><option value="Legumes">Legumes</option><option value="Verduras">Verduras</option></select></div>
                            <div class="mb-3"><label for="produtoFoto" class="form-label">Foto do Produto</label><input class="form-control" type="file" id="produtoFoto" accept="image/*"><img id="previewFoto" src="" alt="Preview da foto" class="img-fluid mt-3 rounded" style="display:none;"></div>
                            <div class="d-grid mt-4"><button id="btnPublicar" type="submit" class="btn btn-primary btn-lg">Publicar Anúncio</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="mt-5 text-muted text-center"><p>&copy; 2026 XepaViva. Todos os direitos reservados.</p></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/toast.js"></script>
    <script src="assets/js/validacao.js"></script>
    <script src="assets/js/app.js"></script> 
    <script src="assets/js/form-oferta.js"></script>
</body>
</html>