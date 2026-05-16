document.addEventListener('DOMContentLoaded', () => {

    const API_URL = '/api/routes/ofertas.php';
    const ofertasContainer = document.getElementById('ofertas-container');

    /**
     * Busca todas as ofertas disponíveis na API e as exibe na página.
     */
    const carregarOfertas = async () => {
        if (!ofertasContainer) return;

        // Exibe o placeholder de carregamento
        mostrarPlaceholder('carregando');

        try {
            const response = await fetch(API_URL);
            if (!response.ok) {
                throw new Error(`A resposta da rede não foi OK: ${response.statusText}`);
            }
            const ofertas = await response.json();

            // Limpa o container antes de adicionar os novos cards
            ofertasContainer.innerHTML = '';

            if (ofertas && ofertas.length > 0) {
                ofertas.forEach(oferta => {
                    const card = criarCardOferta(oferta);
                    ofertasContainer.appendChild(card);
                });
            } else {
                // Exibe a mensagem de nenhuma oferta encontrada
                mostrarPlaceholder('vazio');
            }
        } catch (error) {
            console.error('Erro ao carregar ofertas:', error);
            // Exibe a mensagem de erro
            mostrarPlaceholder('erro');
        }
    };

    /**
     * Cria o HTML para um card de oferta.
     * @param {object} oferta - O objeto da oferta vindo da API.
     * @returns {HTMLElement} - O elemento do card (uma coluna do Bootstrap).
     */
    const criarCardOferta = (oferta) => {
        const col = document.createElement('div');
        col.className = 'col';

        const isDisponivel = oferta.quantidade_disponivel > 0;
        const precoFormatado = `R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}`;
        // Utiliza o nome do feirante que vem da API, com um fallback.
        const nomeFeirante = oferta.nome_feirante || 'Feirante não informado';

        let badgeHTML;
        let botaoHTML;

        if (isDisponivel) {
            badgeHTML = `<span class="badge bg-secondary">${oferta.quantidade_disponivel} disponíveis</span>`;
            botaoHTML = `<a href="#" class="btn btn-primary w-100" style="min-height: 44px; display: flex; align-items: center; justify-content: center;">Reservar Kit</a>`;
        } else {
            badgeHTML = `<span class="badge bg-danger">Esgotado</span>`;
            botaoHTML = `<button class="btn btn-secondary w-100" style="min-height: 44px;" disabled>Esgotado</button>`;
            // Adiciona uma opacidade para indicar visualmente que o item não está disponível
            col.style.opacity = '0.65';
        }

        col.innerHTML = `
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">${oferta.produto}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Por ${nomeFeirante}</h6>
                    <p class="card-text">${oferta.descricao || 'Descrição não disponível.'}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold fs-5 text-success">${precoFormatado}</span>
                            ${badgeHTML}
                        </div>
                        ${botaoHTML}
                    </div>
                </div>
            </div>
        `;
        return col;
    };

    /**
     * Controla a exibição de placeholders de estado no container de ofertas.
     * @param {'carregando'|'vazio'|'erro'} estado - O estado a ser exibido.
     */
    const mostrarPlaceholder = (estado) => {
        let placeholderHTML = '';
        switch (estado) {
            case 'carregando':
                placeholderHTML = `
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                        <p class="mt-2">Buscando ofertas fresquinhas...</p>
                    </div>`;
                break;
            case 'vazio':
                placeholderHTML = `
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info">Nenhuma oferta encontrada no momento. Volte mais tarde!</div>
                    </div>`;
                break;
            case 'erro':
                placeholderHTML = `
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-danger">Ocorreu um erro ao buscar as ofertas. Por favor, tente novamente.</div>
                    </div>`;
                break;
        }
        ofertasContainer.innerHTML = placeholderHTML;
    };

    // --- INICIALIZAÇÃO ---
    carregarOfertas();

});
