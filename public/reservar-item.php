<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Item - XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <main class="container my-5">
        <div id="loading-placeholder" class="text-center">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="mt-2">Carregando detalhes da oferta...</p>
        </div>

        <div id="oferta-content" class="d-none">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="buscar-ofertas.php">Buscar Ofertas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Confirmar Reserva</li>
                        </ol>
                    </nav>

                    <h1 class="mb-3">Sua reserva</h1>

                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 id="oferta-nome" class="card-title h3">--</h2>
                            <p id="oferta-descricao" class="text-muted">--</p>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Vendido por:</strong> <span id="oferta-feirante">--</span></p>
                                    <p class="mb-2"><strong>Categoria:</strong> <span id="oferta-categoria" class="badge bg-info text-dark">--</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Preço unitário:</strong> <span id="oferta-preco" class="text-success fw-bold">--</span></p>
                                    <p class="mb-2"><strong>Disponível:</strong> <span id="oferta-disponivel">--</span> unidades</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title">Quantas unidades você quer?</h3>
                            <form id="form-reserva" novalidate>
                                <div class="mb-3">
                                    <label for="quantidade" class="form-label">Quantidade</label>
                                    <input type="number" class="form-control form-control-lg" id="quantidade" name="quantidade" min="1" value="1" required>
                                    <div class="invalid-feedback">
                                        Por favor, insira uma quantidade válida.
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                   <button type="submit" id="submit-button" class="btn btn-success btn-lg">
                                       <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                       Confirmar Reserva
                                   </button>
                                   <a href="buscar-ofertas.php" class="btn btn-outline-secondary">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="feedback-message" class="mt-4"></div>

    </main>

    <script src="assets/js/reservar-item.js"></script>
</body>
</html>
