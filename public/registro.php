<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-8 col-lg-6">
                <div class="text-center mb-4">
                    <a href="index.php">
                        <img src="assets/images/logo.svg" alt="Logo XepaViva" width="150">
                    </a>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="card-title text-center h3 mb-4">Crie sua conta de Consumidor</h1>
                        
                        <!-- Mensagens de sucesso ou erro -->
                        <div id="feedback-message"></div>

                        <!-- Formulário de Registro de Consumidor -->
                        <form id="registro-form" action="api/routes/usuarios.php" method="POST">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone (WhatsApp)</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX" required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                             <div class="mb-4">
                                <label for="confirmar_senha" class="form-label">Confirme sua Senha</label>
                                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" style="min-height: 48px;">Cadastrar</button>
                            </div>
                        </form>

                        <hr class="my-4">
                        <p class="text-center text-muted">
                            Já tem uma conta? <a href="login.php">Faça login</a>
                        </p>
                    </div>
                </div>
                <div class="text-center mt-3">
                     <a href="index.php">Voltar para o início</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Incluiremos um script para validação e submissão via JS -->
    <script src="assets/js/registro-consumidor.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
