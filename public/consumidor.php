<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redireciona se não for um consumidor logado
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Consumidor') {
    header("Location: login.php");
    exit();
}

$pageTitle = "Meu Painel";
// Carrega o cabeçalho específico do consumidor
require_once 'layout/header_consumidor.php';
?>

<main class="container my-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Meu Painel</h1>
        <a href="ofertas.php" class="btn btn-primary" style="min-height: 44px;"><i class="bi bi-search"></i> Buscar Novas Ofertas</a>
    </div>

    <!-- KPIs de Impacto Pessoal -->
    <section class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="bi bi-coin"></i> Sua Economia Total</h5>
                    <p class="card-text fs-4 fw-bold" id="kpi-economia-total">R$ 0,00</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-box-seam"></i> Alimentos que Você Salvou</h5>
                    <p class="card-text fs-4 fw-bold" id="kpi-kg-salvos">0 Kg</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-receipt"></i> Total de Reservas</h5>
                    <p class="card-text fs-4 fw-bold" id="kpi-total-reservas">0</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Reservas Ativas -->
    <section id="reservas-ativas-section" class="mb-4">
         <h2 class="h3 mb-3">Minhas Reservas Ativas</h2>
         <div id="reservas-ativas-container">
             <!-- Conteúdo inserido via JS -->
         </div>
         <div class="alert alert-info" id="sem-reservas-ativas" style="display: none;">Você não tem nenhuma reserva aguardando retirada.</div>
    </section>

    <!-- Histórico de Reservas -->
    <section class="mb-4">
        <h2 class="h3 mb-3">Histórico de Compras</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <div id="historico-container">
                    <p id="sem-historico" class="text-muted">Seu histórico de compras aparecerá aqui.</p>
                    <div class="table-responsive" id="historico-table-container" style="display: none;">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Ação</th>
                                </tr>
                            </thead>
                            <tbody id="historico-table-body">
                                <!-- Conteúdo inserido via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Feirantes Favoritos -->
    <section id="favoritos-section" class="mb-4" style="display: none;">
        <h2 class="h3 mb-3">Seus Feirantes</h2>
        <div class="row" id="feirantes-favoritos-container">
            <!-- Conteúdo inserido via JS -->
        </div>
    </section>

</main>

<?php
// Carrega o rodapé padrão e os scripts JS
require_once 'layout/footer.php';
?>

<!-- Script específico para esta página -->
<script src="assets/js/dashboard-consumidor.js"></script>

</body>
</html>
