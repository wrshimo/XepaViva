document.addEventListener('DOMContentLoaded', () => {

    const ofertasContainer = document.getElementById('ofertas-container');
    const filtroBusca = document.getElementById('filtroBusca');
    const filtroCategoria = document.getElementById('filtroCategoria');
    const btnLimparFiltros = document.getElementById('btnLimparFiltros');
    const loadingIndicator = document.getElementById('loading-indicator');
    
    const reservaModalEl = document.getElementById('reservaModal');
    const reservaModal = reservaModalEl ? new bootstrap.Modal(reservaModalEl) : null;
    const modalOfertaNome = document.getElementById('modal-oferta-nome');
    const modalQuantidade = document.getElementById('modal-quantidade');
    const modalFeedback = document.getElementById('modal-feedback');
    const btnConfirmarReserva = document.getElementById('btn-confirmar-reserva');

    let debounceTimer;
    let ofertasAtuais = [];

    // Função restaurada para ser simples e eficiente
    const buscarERenderizarOfertas = async () => {
        const termo = filtroBusca.value.trim();
        const categoria = filtroCategoria.value;
        const baseUrl = '/api/routes/ofertas.php';
        
        // ETAPA 2: A chamada à API volta a pedir apenas o que precisa (`disponivel=1`).
        // A API agora retorna a lista correta, incluindo ofertas com quantidade zero.
        const params = new URLSearchParams({ disponivel: '1' }); 

        if (termo) params.append('q', termo);
        if (categoria) params.append('categoria', categoria);
        const apiUrl = `${baseUrl}?${params.toString()}`;

        setLoadingState(true);

        try {
            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error(`Erro na requisição: ${response.statusText}`);
            const result = await response.json();

            if (result.status === 'success' && result.data.length > 0) {
                ofertasAtuais = result.data;
                renderCards(ofertasAtuais);
            } else {
                ofertasAtuais = [];
                renderPlaceholder('vazio');
            }
        } catch (error) {
            console.error('Falha ao buscar ofertas:', error);
            renderPlaceholder('erro');
        } finally {
            setLoadingState(false);
        }
    };

    // Nenhuma mudança necessária aqui. A lógica de renderização já estava correta.
    const renderCards = (ofertas) => {
        ofertasContainer.innerHTML = '';
        ofertas.forEach(oferta => {
            const card = document.createElement('div');
            card.className = 'col';
            
            const isEsgotado = parseInt(oferta.quantidade_disponivel, 10) === 0;

            const cardInnerClasses = isEsgotado ? "card-esgotado" : "";
            const stampHTML = isEsgotado ? '<div class="esgotado-stamp">Esgotado</div>' : '';

            card.innerHTML = `
                <div class="card h-100 shadow-sm ${cardInnerClasses}">
                    ${stampHTML}
                    <img src="${oferta.foto || 'https://placehold.co/300x200/198754/FFFFFF?text=XepaViva'}" class="card-img-top" alt="${oferta.nome}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${oferta.nome}</h5>
                        <p class="card-text text-muted small">Feirante: ${oferta.nome_feirante}</p>
                        <div class="mt-auto pt-3">
                            <p class="card-text fs-5 fw-bold text-success mb-2">R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}</p>
                             <button 
                                class="btn ${!isEsgotado ? 'btn-success' : 'btn-secondary'} w-100 reservar-btn" 
                                data-oferta-id="${oferta.id}" 
                                style="min-height: 44px;" 
                                ${isEsgotado ? 'disabled' : ''}>
                                ${!isEsgotado ? 'Quero Reservar' : 'Esgotado'}
                            </button>
                        </div>
                    </div>
                </div>
            `;
            ofertasContainer.appendChild(card);
        });
    };

    const carregarCategorias = async () => {
        try {
            const response = await fetch('/api/routes/categorias.php');
            const result = await response.json();
            if (result.status === 'success') {
                result.data.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.nome;
                    option.textContent = cat.nome;
                    filtroCategoria.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Falha ao carregar categorias:', error);
        }
    };

    const setLoadingState = (isLoading) => {
        if (loadingIndicator) loadingIndicator.style.display = isLoading ? 'block' : 'none';
        if (isLoading) ofertasContainer.innerHTML = '';
    };

    const renderPlaceholder = (state) => {
        let message = '';
        if (state === 'vazio') {
            message = 'Nenhuma oferta disponível no momento com os filtros selecionados.';
        } else if (state === 'erro') {
            message = 'Erro ao carregar as ofertas. Tente novamente mais tarde.';
        }
        ofertasContainer.innerHTML = `<div class="text-center w-100"><p>${message}</p></div>`;
    };

    const handleAbrirModalReserva = (ofertaId) => {
        const oferta = ofertasAtuais.find(o => o.id == ofertaId);
        if (!oferta) return;

        const user = JSON.parse(localStorage.getItem('xepa-user'));
        if (!user || !user.id) {
            alert('Você precisa estar logado para fazer uma reserva.');
            window.location.href = `login.php?redirect_url=buscar-ofertas.php`;
            return;
        }
        if (!reservaModal) return;
        modalFeedback.innerHTML = '';
        modalQuantidade.value = 1;
        btnConfirmarReserva.disabled = false;
        modalOfertaNome.textContent = oferta.nome;
        modalQuantidade.max = oferta.quantidade_disponivel;
        btnConfirmarReserva.dataset.ofertaId = ofertaId;
        reservaModal.show();
    };

    const handleConfirmarReserva = async () => {
        const ofertaId = btnConfirmarReserva.dataset.ofertaId;
        const quantidade = parseInt(modalQuantidade.value, 10);
        const user = JSON.parse(localStorage.getItem('xepa-user'));
        if (!ofertaId || !quantidade || !user) return;

        btnConfirmarReserva.disabled = true;
        modalFeedback.innerHTML = '<div class="spinner-border spinner-border-sm"></div> Reservando...';
        try {
            const response = await fetch('/api/routes/reservas.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ oferta_id: ofertaId, consumidor_id: user.id, quantidade_reservada: quantidade })
            });
            const result = await response.json();
            if (response.status === 201 && result.status === 'success') {
                modalFeedback.innerHTML = `<div class="alert alert-success">Reserva efetuada! Seu código de retirada é <strong>${result.data.codigo_retirada}</strong>.</div>`;
                setTimeout(() => {
                    reservaModal.hide();
                    buscarERenderizarOfertas();
                }, 4000);
            } else {
                throw new Error(result.message || 'Não foi possível criar a reserva.');
            }
        } catch (error) {
            modalFeedback.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
            btnConfirmarReserva.disabled = false;
        }
    };

    filtroBusca.addEventListener('keyup', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(buscarERenderizarOfertas, 300);
    });
    filtroCategoria.addEventListener('change', buscarERenderizarOfertas);
    btnLimparFiltros.addEventListener('click', () => {
        filtroBusca.value = '';
        filtroCategoria.value = '';
        buscarERenderizarOfertas();
    });
    ofertasContainer.addEventListener('click', (event) => {
        const target = event.target.closest('.reservar-btn');
        if (target && !target.disabled) {
            const ofertaId = target.getAttribute('data-oferta-id');
            handleAbrirModalReserva(ofertaId);
        }
    });
    if(btnConfirmarReserva) {
        btnConfirmarReserva.addEventListener('click', handleConfirmarReserva);
    }

    carregarCategorias();
    buscarERenderizarOfertas();
});
