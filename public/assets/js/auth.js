document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('main-header');
    const user = JSON.parse(localStorage.getItem('xepa-user'));

    let menuHTML = '';

    if (user && user.id) {
        // USUÁRIO LOGADO
        const isFeirante = user.tipo === 'Feirante';
        const homeLink = isFeirante ? 'feirante.php' : 'consumidor.php';

        menuHTML = `
            <nav class="navbar navbar-dark bg-success sticky-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="${homeLink}">
                        <img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="120">
                    </a>
                    <div class="d-flex align-items-center">
                        <button id="highContrastToggle" class="btn btn-outline-light me-2" aria-label="Alternar alto contraste">
                            <i class="bi bi-sun"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> Olá, ${user.nome.split(' ')[0]}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
                                <li><a class="dropdown-item" href="${homeLink}">Meu Painel</a></li>
                                ${isFeirante ? 
                                    `<li><a class="dropdown-item" href="minhas-ofertas.php">Minhas Ofertas</a></li>` : 
                                    `<li><a class="dropdown-item" href="minhas-reservas.php">Minhas Reservas</a></li>`
                                }
                                <li><a class="dropdown-item" href="buscar-ofertas.php">Buscar Ofertas</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" id="logout-button">Sair</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        `;
    } else {
        // VISITANTE NÃO LOGADO
        menuHTML = `
            <nav class="navbar navbar-dark bg-success sticky-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img src="assets/images/logo-white.svg" alt="Logo XepaViva" width="120">
                    </a>
                    <div class="d-flex align-items-center">
                        <button id="highContrastToggle" class="btn btn-outline-light me-2" aria-label="Alternar alto contraste">
                            <i class="bi bi-sun"></i>
                        </button>
                        <a href="login.php" class="btn btn-outline-light me-2">Entrar</a>
                        <a href="cadastro.php" class="btn btn-warning">Cadastre-se</a>
                    </div>
                </div>
            </nav>
        `;
    }

    header.innerHTML = menuHTML;

    // Adiciona o listener para o botão de logout se ele existir
    const logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', function (e) {
            e.preventDefault();
            localStorage.removeItem('xepa-user');
            window.location.href = 'index.php';
        });
    }
    
    // Garante que o toggle de alto contraste seja reinicializado após a injeção do menu
    if (typeof inicializarHighContrast === 'function') {
        inicializarHighContrast();
    }
});
