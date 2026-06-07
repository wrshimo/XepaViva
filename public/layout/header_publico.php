<?php
$pageTitle = isset($pageTitle) ? $pageTitle : "XepaViva";
$pageDescription = isset($pageDescription) ? $pageDescription : "Conectando feirantes e consumidores para reduzir o desperdício de alimentos e promover a sustentabilidade.";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | XepaViva</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#2ECC71">
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
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
                    <li class="nav-item"><a class="nav-link" href="impacto.php">Impacto</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-outline-light" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </header>
