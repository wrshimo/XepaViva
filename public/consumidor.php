<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Consumidor') {
    header("Location: login.php");
    exit();
}

$pageTitle = "Painel do Consumidor";
require_once 'layout/header_consumidor.php';
?>

<main class="container mt-4">
    <!-- KPIs de Impacto Pessoal -->
    <section class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-currency-dollar text-success"></i> Sua Economia Total</h5>
                    <p class="card-text fs-4 fw-bold">R$ 45,00</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-leaf text-primary"></i> Alimentos que Você Salvou</h5>
                    <p class="card-text fs-4 fw-bold">12 Kg</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Gráfico de Impacto -->
    <section class="mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Sua Economia ao Longo do Tempo</h5>
                <div class="chart-container" style="position: relative; height:300px">
                    <canvas id="graficoEconomiaConsumidor"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- Minhas Reservas Ativas -->
    <section class="mb-4">
         <h2 class="h3 mb-3">Minhas Reservas Ativas</h2>
         <div class="card mb-3 shadow-sm">
             <div class="card-body">
                 <div class="d-flex justify-content-between align-items-center">
                     <div>
                        <h5 class="card-title mb-1">Kit de Tomate Italiano</h5>
                        <p class="card-text mb-0"><small class="text-muted">Feirante: Seu Benedito | Retirar na Feira da Vila Madalena</small></p>
                     </div>
                     <a href="codigo-retirada.php" class="btn btn-success" style="min-height: 44px;">Ver Código de Retirada</a>
                 </div>
             </div>
         </div>
    </section>

</main>

<?php require_once 'layout/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('graficoEconomiaConsumidor')?.getContext('2d');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Economia (R$)',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#2ECC71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
