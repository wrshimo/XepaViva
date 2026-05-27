<?php
session_start();
ob_start(); // Inicia o buffer de saída
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <a href="index.php">
                        <img src="assets/images/logo.svg" alt="Logo XepaViva" width="150">
                    </a>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="card-title text-center h3 mb-4">Acesse sua conta</h1>
                        
                        <!-- Contêiner de Erro para o JavaScript -->
                        <div id="loginError" class="alert alert-danger" style="display: none;"></div>

                        <!-- Formulário CORRIGIDO: sem 'action' e com 'id' -->
                        <form id="loginForm" novalidate>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-4">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" style="min-height: 48px;">Entrar</button>
                            </div>
                        </form>

                        <hr class="my-4">
                        <p class="text-center text-muted">
                            Novo por aqui? <a href="registro.php">Crie sua conta</a>
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
    <!-- Script CORRIGIDO: incluindo o auth.js -->
    <script src="assets/js/auth.js"></script>
</body>
</html>
<?php
ob_end_flush(); // Envia o buffer de saída para o navegador
?>