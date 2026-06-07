<?php
$pageTitle = "Painel de Impacto";
$pageDescription = "Veja o impacto real do projeto XepaViva na comunidade, reduzindo o desperdício de alimentos e gerando renda.";
require __DIR__ . '/layout/header_publico.php';
?>

<main class="container my-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Nosso Impacto na Comunidade</h1>
        <p class="lead text-muted">Dados que mostram como estamos, juntos, construindo um futuro mais sustentável.</p>
    </div>

    <!-- Linha de KPIs -->
    <div class="row g-4 text-center mb-5">
        <div class="col-6 col-md-4 col-lg">
            <div class="card h-100 shadow-sm border-success">
                <div class="card-body">
                    <h3 class="display-5 fw-bold text-success" id="kpi-kg-salvo">--</h3>
                    <p class="card-text text-muted">Kg de Alimentos Salvos</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg">
            <div class="card h-100 shadow-sm border-primary">
                <div class="card-body">
                    <h3 class="display-5 fw-bold text-primary" id="kpi-renda-gerada">--</h3>
                    <p class="card-text text-muted">Renda para Feirantes</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="display-5 fw-bold" id="kpi-feirantes">--</h3>
                    <p class="card-text text-muted">Feirantes Parceiros</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="display-5 fw-bold" id="kpi-familias">--</h3>
                    <p class="card-text text-muted">Famílias Impactadas</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h3 class="display-5 fw-bold" id="kpi-reservas">--</h3>
                    <p class="card-text text-muted">Refeições Salvas (Reservas)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Linha dos Gráficos -->
    <div class="row g-5">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Categorias Mais Salvas (em Kg)</h5>
                    <canvas id="chart-categorias"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Situação das Reservas</h5>
                    <canvas id="chart-status-reservas"></canvas>
                </div>
            </div>
        </div>
    </div>

</main>

<?php
// Adicionar Chart.js antes do footer
echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
// Adicionar o script específico do dashboard
echo '<script src="assets/js/dashboard-impacto.js"></script>';

require __DIR__ . '/layout/footer_publico.php';
?>
