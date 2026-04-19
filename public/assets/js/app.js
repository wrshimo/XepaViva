// assets/js/app.js

/**
 * Busca dados de um arquivo JSON de forma assíncrona.
 * @param {string} filePath - O caminho para o arquivo JSON.
 * @returns {Promise<any>} - Uma promessa que resolve com os dados JSON.
 */
async function fetchJsonData(filePath) {
    try {
        const response = await fetch(filePath);
        if (!response.ok) {
            throw new Error(`Erro ao buscar arquivo: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error('[fetchJsonData] Falha ao buscar ou processar o JSON:', error);
        return { ofertas: [], reservas: [] }; // Retorna uma estrutura padrão em caso de erro
    }
}

/**
 * Exibe um estado de vazio (empty state) em um contêiner.
 * @param {HTMLElement} container - O elemento onde o HTML do empty state será inserido.
 * @param {object} emptyStateInfo - Objeto com as informações do empty state.
 */
function renderEmptyState(container, emptyStateInfo) {
    let buttonHtml = '';
    if (emptyStateInfo.button_text && emptyStateInfo.button_url) {
        buttonHtml = `<a href="${emptyStateInfo.button_url}" class="btn btn-primary mt-3">${emptyStateInfo.button_text}</a>`;
    }
    const wrapperClass = container.classList.contains('row') ? 'col-12' : '';
    container.innerHTML = `
        <div class="${wrapperClass}">
            <div class="text-center py-5 border rounded bg-light">
                <i class="bi ${emptyStateInfo.icon} display-1 text-muted"></i>
                <h5 class="mt-3">${emptyStateInfo.title}</h5>
                <p class="text-muted">${emptyStateInfo.message}</p>
                ${buttonHtml}
            </div>
        </div>
    `;
}

/**
 * Cria o HTML para um único card de oferta (versão pública).
 * @param {object} oferta - O objeto da oferta.
 * @returns {string} - O HTML do card.
 */
function createOfferCard(oferta) {
    const precoFormatado = parseFloat(oferta.preco).toFixed(2).replace('.', ',');
    return `
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="${oferta.foto}" class="card-img-top" alt="${oferta.nome}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">${oferta.nome}</h5>
                    <p class="card-text"><small class="text-muted">${oferta.feirante_nome} | ${oferta.feirante_local}</small></p>
                    <p class="fs-5 fw-bold text-success mt-auto">R$ ${precoFormatado}</p>
                    <a href="detalhe_oferta.php?id=${oferta.id}" class="btn btn-outline-success stretched-link">Ver Detalhes</a>
                </div>
            </div>
        </div>
    `;
}

/**
 * Cria o HTML para um card de oferta na lista "Minhas Ofertas" do feirante.
 * @param {object} oferta - O objeto da oferta.
 * @returns {string} - O HTML do card.
 */
function createMyOfferCard(oferta) {
    return `
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">${oferta.nome}</h5>
                        <span class="badge bg-success">${oferta.reservas} Reservas</span>
                    </div>
                    <div class="btn-group">
                        <a href="cadastrar_oferta.php?id=${oferta.id}" class="btn btn-outline-secondary"><i class="bi bi-pencil"></i> Editar</a>
                        <a href="#" class="btn btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esta oferta?');"><i class="bi bi-trash"></i> Excluir</a>
                    </div>
                </div>
            </div>
        </div>
    `;
}

/**
 * Retorna a classe CSS do Bootstrap para o status da reserva.
 * @param {string} status - O status da reserva.
 * @returns {string} A classe do badge.
 */
function getStatusBadgeClass(status) {
    switch (status) {
        case 'Confirmada': return 'bg-primary';
        case 'Pendente Retirada': return 'bg-warning text-dark';
        case 'Concluída': return 'bg-success';
        case 'Cancelada': return 'bg-danger';
        default: return 'bg-secondary';
    }
}

/**
 * Cria o HTML para um card de reserva na lista "Minhas Reservas" do consumidor.
 * @param {object} reserva - O objeto da reserva.
 * @returns {string} - O HTML do card.
 */
function createMyReservationCard(reserva) {
    return `
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">${reserva.oferta_nome}</h5>
                        <p class="card-text"><small class="text-muted">Reservado com: ${reserva.feirante_nome}</small></p>
                        <span class="badge ${getStatusBadgeClass(reserva.status)}">${reserva.status}</span>
                    </div>
                    <a href="codigo-retirada.php?id=${reserva.id}" class="btn btn-success">Ver Código</a>
                </div>
            </div>
        </div>
    `;
}

/**
 * Inicializa a funcionalidade da página de busca de ofertas.
 */
async function initBuscarOfertas() {
    const container = document.getElementById('ofertas-container');
    const searchInput = document.getElementById('filtroBusca');
    const categoryInput = document.getElementById('filtroCategoria');
    const searchButton = document.getElementById('btnBuscar');
    const data = await fetchJsonData('data/ofertas.json');
    const allOffers = data.ofertas || [];
    const renderFilteredOffers = () => {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const category = categoryInput.value;
        let filteredOffers = allOffers.filter(o => o.disponivel);
        if (searchTerm) {
            filteredOffers = filteredOffers.filter(o => o.nome.toLowerCase().includes(searchTerm) || o.feirante_nome.toLowerCase().includes(searchTerm));
        }
        if (category) {
            filteredOffers = filteredOffers.filter(o => o.categoria === category);
        }
        container.innerHTML = '';
        if (filteredOffers.length > 0) {
            container.innerHTML = filteredOffers.map(createOfferCard).join('');
        } else {
            renderEmptyState(container, { icon: 'bi-search', title: 'Nenhuma oferta encontrada', message: 'Tente ajustar seus filtros ou remover algumas condições de busca.'});
        }
    };
    searchButton.addEventListener('click', renderFilteredOffers);
    searchInput.addEventListener('keyup', e => e.key === 'Enter' && renderFilteredOffers());
    categoryInput.addEventListener('change', renderFilteredOffers);
    renderFilteredOffers(); 
}

/**
 * Inicializa a página "Minhas Ofertas" para um feirante.
 * @param {number} feiranteId - O ID do feirante logado.
 */
async function initMinhasOfertas(feiranteId) {
    const container = document.getElementById('minhas-ofertas-container');
    if (!container) return;
    const data = await fetchJsonData('data/ofertas.json');
    const myOffers = (data.ofertas || []).filter(o => o.feirante_id === feiranteId);
    container.innerHTML = '';
    if (myOffers.length > 0) {
        container.innerHTML = myOffers.map(createMyOfferCard).join('');
    } else {
        renderEmptyState(container, { icon: 'bi-megaphone', title: 'Você ainda não anunciou nenhuma xepa.', message: 'Vamos começar? Anuncie sua primeira xepa e evite o desperdício.', button_text: 'Anunciar Primeira Xepa', button_url: 'cadastrar_oferta.php'});
    }
}

/**
 * Inicializa a página "Minhas Reservas" para um consumidor.
 * @param {number} consumidorId - O ID do consumidor logado.
 */
async function initMinhasReservas(consumidorId) {
    const container = document.getElementById('minhas-reservas-container');
    if (!container) return;

    const data = await fetchJsonData('data/reservas.json');
    const myReservations = (data.reservas || []).filter(r => r.consumidor_id === consumidorId);

    container.innerHTML = '';
    if (myReservations.length > 0) {
        container.innerHTML = myReservations.map(createMyReservationCard).join('');
    } else {
        renderEmptyState(container, {
            icon: 'bi-inbox',
            title: 'Você ainda não tem reservas ativas.',
            message: 'Que tal encontrar algumas ofertas fresquinhas?',
            button_text: 'Buscar Ofertas Agora',
            button_url: 'buscar-ofertas.php'
        });
    }
}
