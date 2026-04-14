<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua Conta | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>

    <header class="navbar navbar-dark bg-success sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="120">
            </a>
            <a href="login.php" class="btn btn-outline-light">Já tem uma conta? Entrar</a>
        </div>
    </header>

    <main class="container mt-5" style="max-width: 540px;">
        <div class="card shadow-sm">
            <div class="card-body p-5">
                <h1 class="card-title text-center mb-4">Crie sua Conta</h1>
                <form id="formRegistro">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_usuario" class="form-label">Você é...</label>
                        <select class="form-select" id="tipo_usuario" name="tipo_usuario">
                            <option value="consumidor" selected>Consumidor</option>
                            <option value="feirante">Feirante</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="documento" class="form-label">CPF / CNPJ</label>
                        <input type="text" class="form-control" id="documento" name="documento" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Criar Conta</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="mt-5 text-muted text-center">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/validacao.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
