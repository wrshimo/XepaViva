<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Feirante') {
    header("Location: login.php");
    exit();
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Feirante';
$pageTitle = "Painel do Feirante";

// CORREÇÃO: Usando __DIR__ para criar um caminho de arquivo absoluto e robusto.
require_once __DIR__ . '/layout/header_feirante.php';
?>

<main class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-5 mb-4 bg-light rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Boas-vindas, <?php echo htmlspecialchars($nomeUsuario); ?>!</h1>
                    <p class="col-md-8 fs-4">Este é o seu painel de controle. Acompanhe suas vendas e gerencie suas ofertas.</p>
                    <div class="mt-4">
                        <a href="anunciar-xepa.php" class="btn btn-primary btn-lg" style="min-height: 44px;"><i class="bi bi-plus-circle"></i> Anunciar Nova Xepa</a>
                        <a href="minhas-ofertas.php" class="btn btn-outline-secondary btn-lg" style="min-height: 44px;"><i class="bi bi-list-ul"></i> Gerenciar Ofertas</a>
                    </div>
                </div>
            </div>
    </div>

    <!-- KPIs de Desempenho -->
    <div class="row text-center g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title"><i class="bi bi-basket-fill text-success"></i></h2>
                    <h3 class="display-6 fw-bold" id="kpi-ofertas-ativas">-</h3>
                    <p class="card-text">Ofertas Ativas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title"><i class="bi bi-check-circle-fill text-primary"></i></h2>
                    <h3 class="display-6 fw-bold" id="kpi-reservas-hoje">-</h3>
                    <p class="card-text">Reservas para Retirada</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title"><i class="bi bi-people-fill text-info"></i></h2>
                    <h3 class="display-6 fw-bold" id="kpi-clientes-atendidos">-</h3>
                    <p class="card-text">Clientes Atendidos</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção de Reservas para Retirada -->
    <section id="reservas-retirada-section" class="mb-5">
        <h2 class="h3 mb-3">Reservas Aguardando Retirada</h2>
        <div id="reservas-retirada-container"></div>
        <div id="sem-reservas-retirada" class="alert alert-info" style="display: none;">
            Nenhuma reserva aguardando retirada no momento.
        </div>
    </section>

    <!-- Seção de Produtos Mais Vendidos -->
    <section id="top-produtos-section">
        <h2 class="h3 mb-3">Seus Produtos Mais Vendidos</h2>
        <div id="top-produtos-container"></div>
         <div id="sem-top-produtos" class="alert alert-secondary" style="display: none;">
            Você ainda não tem um histórico de produtos vendidos.
        </div>
    </section>

</main>

<?php 
// CORREÇÃO: Usando __DIR__ para criar um caminho de arquivo absoluto e robusto.
require_once __DIR__ . '/layout/footer.php'; 
?>

<!-- Script específico do dashboard do feirante -->
<script src="assets/js/dashboard-feirante.js"></script>

</body>
</html>
