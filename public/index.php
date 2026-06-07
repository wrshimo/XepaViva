<?php
$pageTitle = "Página Inicial";
$pageDescription = "Conectando feirantes e consumidores para reduzir o desperdício de alimentos e promover a sustentabilidade.";
require __DIR__ . '/layout/header_publico.php';
?>

<main>
    <section class="text-center bg-light py-5">
        <div class="container">
            <img src="assets/images/logo.svg" alt="Logo XepaViva" class="mb-3" width="120">
            <h1 class="display-5 fw-bold">Alimentos bons demais para serem desperdiçados.</h1>
            <p class="lead text-muted">A XepaViva conecta você a feirantes locais, oferecendo produtos de qualidade por um preço justo e evitando o desperdício.</p>
            <a href="buscar-ofertas.php" class="btn btn-primary btn-lg" style="min-height: 48px;">Encontrar Xepas Perto de Mim</a>
        </div>
    </section>
</main>

<?php
require __DIR__ . '/layout/footer_publico.php';
?>
