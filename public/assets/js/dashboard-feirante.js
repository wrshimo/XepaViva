document.addEventListener('DOMContentLoaded', () => {

    const API_URL = '/api/routes/ofertas.php';
    const CATEGORIAS_API_URL = '/api/routes/categorias.php';

    const feiranteId = document.getElementById('feirante_id').value;
    const ofertasRecentesContainer = document.getElementById('ofertasRecentesContainer');
    
    // --- Lógica do Modal de Oferta ---
    const ofertaModalElement = document.getElementById('ofertaModal');
    const ofertaModal = new bootstrap.Modal(ofertaModalElement);
    const formOferta = document.getElementById('formOferta');
    const ofertaModalLabel = document.getElementById('ofertaModalLabel');
    const categoriaSelect = document.getElementById('categoria');

    /**
     * Carrega as categorias da API e popula o select no formulário do modal.
     */
    const carregarCategorias = async () => {
        try {
            const response = await fetch(CATEGORIAS_API_URL);
            if (!response.ok) {
                throw new Error('Não foi possível carregar as categorias.');
            }
            const resultado = await response.json();
            if (resultado.sucesso && resultado.dados) {
                categoriaSelect.innerHTML = '<option value="" selected disabled>Selecione uma categoria...</option>'; // Reset
                resultado.dados.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria;
                    option.textContent = categoria;
                    categoriaSelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Erro ao carregar categorias:', error);
            showToast('Falha ao carregar opções de categoria.', 'error');
        }
    };

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
                const recentes = ofertas.slice(0, 3);
                
                const listGroup = document.createElement('div');
                listGroup.className = 'list-group';

                recentes.forEach(oferta => {
                    listGroup.appendChild(criarItemListaOferta(oferta));
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
     */
    const criarItemListaOferta = (oferta) => {
        const item = document.createElement('a');
        item.href = 'minhas-ofertas.php';
        item.className = 'list-group-item list-group-item-action flex-column align-items-start';

        const precoFormatado = `R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}`;
        const categoriaBadge = oferta.categoria 
            ? `<span class="badge bg-info text-dark ms-2">${oferta.categoria}</span>` 
            : '';

        item.innerHTML = `
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h5 class="mb-1">${oferta.produto}${categoriaBadge}</h5>
                <small class="text-muted">${oferta.quantidade_disponivel} un.</small>
            </div>
            <p class="mb-1 mt-1">${oferta.descricao || ''}</p>
            <small class="fw-bold text-success">${precoFormatado}</small>
        `;
        return item;
    };

    /**
     * Salva a nova oferta a partir do modal.
     */
    const salvarNovaOferta = async (event) => {
        event.preventDefault();
        event.stopPropagation();

        if (!formOferta.checkValidity()) {
            formOferta.classList.add('was-validated');
            return;
        }

        const dadosOferta = {
            produto: document.getElementById('produto').value,
            descricao: document.getElementById('descricao').value,
            preco: document.getElementById('preco').value,
            quantidade_disponivel: document.getElementById('quantidade_disponivel').value,
            peso: document.getElementById('peso').value || null,
            categoria: categoriaSelect.value, // Pega o valor do select
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
                formOferta.classList.remove('was-validated');
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
        formOferta.classList.remove('was-validated');
        document.getElementById('ofertaId').value = '';
    };

    // --- EVENT LISTENERS ---
    formOferta.addEventListener('submit', salvarNovaOferta);
    document.getElementById('btnNovaOferta').addEventListener('click', prepararNovoFormulario);
    ofertaModalElement.addEventListener('hidden.bs.modal', prepararNovoFormulario);

    // --- INICIALIZAÇÃO ---
    carregarCategorias();
    carregarOfertasRecentes();
});
