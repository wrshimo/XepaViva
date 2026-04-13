<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar-se | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/high-contrast.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#2ECC71">
</head>
<body class="bg-light">

    <header class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="140">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="como-funciona.php">Como Funciona</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">Voltar</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <a href="index.php">
                        <img src="assets/images/logo.svg" alt="Logo XepaViva" width="150" class="mb-3">
                    </a>
                    <h1 class="h3">Junte-se a XepaViva</h1>
                    <p class="text-muted">Comece agora a fazer parte da solução contra o desperdício</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form id="formRegistro" novalidate>
                            
                            <!-- Nome Completo -->
                            <div class="mb-3">
                                <label for="nome" class="form-label">
                                    Nome Completo <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="nome" 
                                    name="nome"
                                    placeholder="Seu nome completo"
                                    required
                                    minlength="3"
                                    maxlength="100"
                                    style="min-height: 44px;">
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="email" 
                                    name="email"
                                    placeholder="seu.email@exemplo.com"
                                    required
                                    style="min-height: 44px;">
                            </div>

                            <!-- Senha -->
                            <div class="mb-3">
                                <label for="senha" class="form-label">
                                    Senha <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="senha" 
                                    name="senha"
                                    placeholder="Mínimo 6 caracteres"
                                    required
                                    minlength="6"
                                    style="min-height: 44px;">
                                <small class="form-text text-muted">Mínimo de 6 caracteres</small>
                            </div>

                            <!-- Confirmação de Senha -->
                            <div class="mb-3">
                                <label for="confirmSenha" class="form-label">
                                    Confirmar Senha <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="confirmSenha" 
                                    name="confirmSenha"
                                    placeholder="Repita sua senha"
                                    required
                                    minlength="6"
                                    style="min-height: 44px;">
                            </div>

                            <!-- Tipo de Usuário -->
                            <div class="mb-4">
                                <label class="form-label d-block">
                                    Você é? <span class="text-danger">*</span>
                                </label>
                                <div class="form-check form-check-inline">
                                    <input 
                                        class="form-check-input" 
                                        type="radio" 
                                        id="tipoFeirante" 
                                        name="tipo" 
                                        value="Feirante"
                                        required
                                        style="min-height: 20px; min-width: 20px;">
                                    <label class="form-check-label" for="tipoFeirante">
                                        🍎 Feirante
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input 
                                        class="form-check-input" 
                                        type="radio" 
                                        id="tipoConsumidor" 
                                        name="tipo" 
                                        value="Consumidor"
                                        required
                                        style="min-height: 20px; min-width: 20px;">
                                    <label class="form-check-label" for="tipoConsumidor">
                                        👤 Consumidor
                                    </label>
                                </div>
                            </div>

                            <!-- Botão Submit -->
                            <div class="d-grid gap-2">
                                <button 
                                    type="submit" 
                                    class="btn btn-primary btn-lg"
                                    id="btnRegistro"
                                    style="min-height: 48px;">
                                    <span class="spinner-border spinner-border-sm me-2 visually-hidden" id="spinnerRegistro" role="status" aria-hidden="true"></span>
                                    Criar Conta
                                </button>
                            </div>

                            <!-- Alert Container -->
                            <div id="alertContainer" class="mt-3"></div>

                        </form>

                        <!-- Link para Login -->
                        <hr class="my-4">
                        <p class="text-center text-muted mb-0">
                            Já tem uma conta? 
                            <a href="login.php" style="min-height: 44px;">Faça login aqui</a>
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="mt-5 text-muted text-center py-4">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/utilidades.js"></script>
    <script src="assets/js/high-contrast.js"></script>
    <script src="assets/js/validacao.js"></script>
    
    <script>
        document.getElementById('formRegistro').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validar se senhas são iguais
            const senha = document.getElementById('senha').value;
            const confirmSenha = document.getElementById('confirmSenha').value;

            if (senha !== confirmSenha) {
                mostrarAlerta('As senhas não conferem', 'danger');
                return;
            }

            // Coletar dados
            const dados = {
                nome: document.getElementById('nome').value,
                email: document.getElementById('email').value,
                tipo: document.querySelector('input[name="tipo"]:checked').value,
                dataRegistro: new Date().toISOString()
            };

            // Mostrar feedback de carregamento
            mostrarCarregamento(true);

            // Simular delay de API (será substituído por backend real)
            setTimeout(() => {
                // Salvar sessão
                Util.salvarUsuarioSessao({
                    id: Util.gerarUUID(),
                    nome: dados.nome,
                    email: dados.email,
                    tipo: dados.tipo,
                    dataRegistro: dados.dataRegistro
                });

                mostrarAlerta('✅ Conta criada com sucesso!', 'success');
                mostrarCarregamento(false);

                // Redirecionar após 1.5 segundos
                setTimeout(() => {
                    if (dados.tipo === 'Feirante') {
                        window.location.href = 'feirante.php';
                    } else {
                        window.location.href = 'consumidor.php';
                    }
                }, 1500);
            }, 1000);
        });

        function mostrarAlerta(mensagem, tipo) {
            const container = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${tipo} alert-dismissible fade show`;
            alert.role = 'alert';
            alert.innerHTML = `
                ${mensagem}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            `;
            container.innerHTML = '';
            container.appendChild(alert);
        }

        function mostrarCarregamento(ativo) {
            const btn = document.getElementById('btnRegistro');
            const spinner = document.getElementById('spinnerRegistro');
            
            if (ativo) {
                btn.disabled = true;
                spinner.classList.remove('visually-hidden');
            } else {
                btn.disabled = false;
                spinner.classList.add('visually-hidden');
            }
        }
    </script>

</body>
</html>
