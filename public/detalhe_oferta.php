<?php
// Inicializa a variável de oferta como nula
$oferta = null;
$oferta_id = null;

// 1. Capturar o ID da URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $oferta_id = (int)$_GET['id'];
}

// Se temos um ID, vamos procurar a oferta
if ($oferta_id) {
    // 2. Ler data/ofertas.json
    $json_data = file_get_contents('data/ofertas.json');
    $data = json_decode($json_data, true);
    $todas_ofertas = isset($data['ofertas']) ? $data['ofertas'] : [];

    // 3. Encontrar a Oferta Certa
    foreach ($todas_ofertas as $item) {
        if ($item['id'] === $oferta_id) {
            $oferta = $item;
            break;
        }
    }
}

// Se após a busca a oferta ainda for nula, significa que não foi encontrada.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $oferta ? htmlspecialchars($oferta['nome']) : 'Oferta não encontrada' ?> | XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/high-contrast.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
</head>
<body>
    <header class="navbar navbar-dark bg-success sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="consumidor.php">
                <img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="120">
            </a>
            <div class="d-flex">
                <button id="highContrastToggle" class="btn btn-outline-light me-2" style="min-height: 44px;">
                    <i class="bi bi-sun"></i>
                    <span class="d-none d-sm-inline">Alto Contraste</span>
                </button>
                 <a href="index.php" class="btn btn-outline-light">Sair</a>
            </div>
        </div>
    </header>

    <main class="container mt-4" style="max-width: 720px;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="consumidor.php">Painel</a></li>
                <li class="breadcrumb-item"><a href="buscar-ofertas.php">Ofertas</a></li>
                <?php if ($oferta): ?>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($oferta['nome']) ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item active">Oferta não encontrada</li>
                <?php endif; ?>
            </ol>
        </nav>

        <?php if ($oferta): ?>
            <!-- Imagem do produto -->
            <div class="text-center mb-4">
                <img src="<?= htmlspecialchars($oferta['foto']) ?>" class="img-fluid rounded shadow-sm" alt="Foto de <?= htmlspecialchars($oferta['nome']) ?>" style="max-height: 400px; width: auto;">
            </div>

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title h3"><?= htmlspecialchars($oferta['nome']) ?></h1>
                    <p class="card-text text-muted">Publicado por: <?= htmlspecialchars($oferta['feirante_nome']) ?></p>
                    <p class="card-text"><strong>Localização:</strong> <?= htmlspecialchars($oferta['feirante_local']) ?></p>
                    <p class="card-text"><strong>Descrição:</strong> <?= htmlspecialchars($oferta['descricao']) ?></p>
                    <p class="card-text"><strong>Peso Aproximado:</strong> <?= htmlspecialchars($oferta['peso']) ?> kg</p>
                    <p class="display-6 text-success fw-bold">R$ <?= number_format($oferta['preco'], 2, ',', '.') ?></p>

                    <div class="d-grid mt-4">
                        <!-- O link de reserva eventualmente levará para um script que processa a reserva -->
                        <a href="minhas-reservas.php" class="btn btn-success btn-lg" style="min-height: 44px;">Reservar Kit</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- 5. Tratar "Não Encontrado" -->
            <div class="text-center py-5 border rounded bg-light">
                <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
                <h2 class="mt-3">Oferta não encontrada</h2>
                <p class="lead">A oferta que você está tentando visualizar não existe ou não está mais disponível.</p>
                <a href="buscar-ofertas.php" class="btn btn-primary mt-3">Voltar para as ofertas</a>
            </div>
        <?php endif; ?>

    </main>

    <footer class="mt-5 text-muted text-center">
        <p>&copy; 2026 XepaViva. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/high-contrast.js"></script>
</body>
</html>
