<?php
$pageTitle = "Como Funciona";
$pageDescription = "Entenda como o XepaViva conecta feirantes e consumidores para um futuro com menos desperdício.";
require __DIR__ . '/layout/header_publico.php';
?>

<main>
    <section class="text-center py-5 bg-light">
        <div class="container">
            <h1 class="display-5 fw-bold">Juntos, transformamos o fim da feira em um final feliz.</h1>
            <p class="lead text-muted">O XepaViva é uma ponte. De um lado, feirantes com produtos de qualidade. Do outro, consumidores conscientes. No meio, a tecnologia que evita o desperdício.</p>
        </div>
    </section>

    <!-- Seção para Consumidores -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Para <span class="text-success">Consumidores</span>: Economize e Faça a Diferença</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-3">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-search display-3 text-success"></i>
                            <h5 class="card-title mt-3">1. Descubra</h5>
                            <p class="card-text">Navegue pelas ofertas de kits de alimentos frescos perto de você.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-hand-thumbs-up-fill display-3 text-success"></i>
                            <h5 class="card-title mt-3">2. Reserve</h5>
                            <p class="card-text">Garanta seu kit com um clique, de forma simples e rápida.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-bag-check-fill display-3 text-success"></i>
                            <h5 class="card-title mt-3">3. Retire</h5>
                            <p class="card-text">Retire seu pedido diretamente na barraca do feirante no final do dia.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <h4 class="fw-light">Pronto para começar?</h4>
                <a href="buscar-ofertas.php" class="btn btn-success btn-lg me-2 mt-2">Ver Ofertas Agora</a>
                <a href="registro.php" class="btn btn-outline-success btn-lg mt-2">Cadastre-se</a>
            </div>
        </div>
    </section>

    <!-- Seção para Feirantes -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Para <span class="text-primary">Feirantes</span>: Gere Renda Extra e Reduza Perdas</h2>
             <div class="row g-4 justify-content-center">
                <div class="col-md-3">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-megaphone-fill display-3 text-primary"></i>
                            <h5 class="card-title mt-3">1. Anuncie</h5>
                            <p class="card-text">Publique o que sobrou no fim da feira de forma rápida, mesmo sem internet.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-bell-fill display-3 text-primary"></i>
                            <h5 class="card-title mt-3">2. Receba</h5>
                            <p class="card-text">Seja notificado quando um consumidor reservar um dos seus kits.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-cash-coin display-3 text-primary"></i>
                            <h5 class="card-title mt-3">3. Venda</h5>
                            <p class="card-text">Entregue os kits reservados e transforme o que seria perda em lucro.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <h4 class="fw-light">Quer transformar suas perdas em lucro?</h4>
                <a href="registro.php" class="btn btn-primary btn-lg mt-2">Cadastre sua Banca Gratuitamente</a>
            </div>
        </div>
    </section>

</main>

<?php
require __DIR__ . '/layout/footer_publico.php';
?>
