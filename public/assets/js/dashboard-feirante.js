document.addEventListener('DOMContentLoaded', () => {

    const API_URL = '/api/routes/ofertas.php';
    const feiranteId = document.getElementById('feirante_id').value;
    const ofertasRecentesContainer = document.getElementById('ofertasRecentesContainer');
    
    // --- Lógica do Modal de Oferta ---
    const ofertaModal = new bootstrap.Modal(document.getElementById('ofertaModal'));
    const formOferta = document.getElementById('formOferta');
    const ofertaModalLabel = document.getElementById('ofertaModalLabel');

    /**
     * Busca as 3 ofertas mais recentes e as exibe no painel.
     */
    const carregarOfertasRecentes = async () => {
        if (!feiranteId || !ofertasRecentesContainer) return;

        const url = `${API_URL}?feirante_id=${feiranteId}`;
        ofertasRecentesContainer.innerHTML = '<p>Carregando ofertas...</p>';

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Erro ao buscar ofertas.');
            }
            const ofertas = await response.json();

            if (ofertas && ofertas.length > 0) {
                ofertasRecentesContainer.innerHTML = ''; // Limpa o container
                // Pega apenas as 3 mais recentes
                const recentes = ofertas.slice(0, 3);
                
                const listGroup = document.createElement('div');
                listGroup.className = 'list-group';

                recentes.forEach(oferta => {
                    listGroup.appendChild(criarCardOferta(oferta));
                });
                ofertasRecentesContainer.appendChild(listGroup);
            } else {
                ofertasRecentesContainer.innerHTML = '<div class="alert alert-secondary">Nenhuma oferta anunciada ainda. Clique em "Anunciar Nova Xepa" para começar!</div>';
            }
        } catch (error) {
            console.error('Erro ao carregar ofertas recentes:', error);
            ofertasRecentesContainer.innerHTML = '<div class="alert alert-danger">Não foi possível carregar as ofertas.</div>';
        }
    };

    /**
     * Cria o HTML para um item da lista de ofertas recentes.
     * @param {object} oferta Objeto da oferta.
     * @returns {HTMLElement} O elemento do item da lista.
     */
    const criarCardOferta = (oferta) => {
        const item = document.createElement('a');
        item.href = 'minhas-ofertas.php'; // Link para a página de gerenciamento
        item.className = 'list-group-item list-group-item-action flex-column align-items-start';

        const precoFormatado = `R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}`;

        item.innerHTML = `
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">${oferta.produto}</h5>
                <small class="text-muted">${oferta.quantidade_disponivel} un.</small>
            </div>
            <p class="mb-1">${oferta.descricao || ''}</p>
            <small class="fw-bold">${precoFormatado}</small>
        `;
        return item;
    };

    /**
     * Salva a nova oferta (apenas criação) a partir do modal.
     * @param {Event} event 
     */
    const salvarNovaOferta = async (event) => {
        event.preventDefault();

        const dadosOferta = {
            produto: document.getElementById('produto').value,
            descricao: document.getElementById('descricao').value,
            preco: document.getElementById('preco').value,
            quantidade_disponivel: document.getElementById('quantidade_disponivel').value,
            peso: document.getElementById('peso').value || null,
            feirante_id: parseInt(feiranteId)
        };

        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dadosOferta)
            });

            const result = await response.json();

            if (result.status === 'success') {
                showToast('Nova oferta anunciada com sucesso!', 'success');
                ofertaModal.hide();
                formOferta.reset();
                carregarOfertasRecentes(); // Atualiza a lista no painel
            } else {
                throw new Error(result.message || 'Erro ao criar oferta.');
            }
        } catch (error) {
            console.error('Erro ao salvar nova oferta:', error);
            showToast(error.message, 'danger');
        }
    };

    /**
     * Reseta o formulário para garantir que está pronto para uma nova oferta.
     */
    const prepararNovoFormulario = () => {
        ofertaModalLabel.textContent = 'Anunciar Nova Xepa';
        formOferta.reset();
        document.getElementById('ofertaId').value = ''; // Garante que não há ID de edição
    };

    // --- EVENT LISTENERS ---

    // Listener para o formulário do modal
    formOferta.addEventListener('submit', salvarNovaOferta);

    // Garante que o modal esteja sempre no modo de criação
    document.getElementById('btnNovaOferta').addEventListener('click', prepararNovoFormulario);
    document.getElementById('ofertaModal').addEventListener('hidden.bs.modal', prepararNovoFormulario);

    // --- INICIALIZAÇÃO ---
    carregarOfertasRecentes();
});
