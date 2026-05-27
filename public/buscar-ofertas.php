<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Consumidor') {
    header("Location: login.php");
    exit();
}

$pageTitle = "Buscar Ofertas";
require_once 'layout/header_consumidor.php';
?>

<main class="container mt-4">
    <h1 class="mb-4">Encontre uma Xepa perto de você</h1>

    <section class="mb-4 p-3 bg-light rounded shadow-sm">
        <div class="row g-3 align-items-end">
            <div class="col-md-7">
                <label for="filtroTexto" class="form-label">Buscar por nome do produto</label>
                <input type="text" class="form-control" id="filtroTexto" placeholder="Ex: Tomate, Alface, Kit de Legumes...">
            </div>
            <div class="col-md-5">
                <label for="filtroCategoria" class="form-label">Filtrar por categoria</label>
                <select class="form-select" id="filtroCategoria">
                    <option value="todas" selected>Carregando categorias...</option>
                </select>
            </div>
        </div>
    </section>

    <div id="ofertas-container" class="row gy-4">
        <!-- As ofertas serão carregadas aqui via JavaScript -->
    </div>
    
    <div id="ofertas-placeholder" class="text-center py-5">
        <!-- Placeholder para feedback de carregamento, erro ou vazio -->
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>

<script src="assets/js/buscar-ofertas.js"></script>
