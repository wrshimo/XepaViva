document.addEventListener('DOMContentLoaded', () => {

    let API_URL = '/api/routes/ofertas.php';

    const tabelaOfertas = document.getElementById('tabelaOfertas');
    const ofertaModal = new bootstrap.Modal(document.getElementById('ofertaModal'));
    const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const nomeProdutoExclusao = document.getElementById('nomeProdutoExclusao');
    const formOferta = document.getElementById('formOferta');
    const ofertaModalLabel = document.getElementById('ofertaModalLabel');
    const placeholder = document.getElementById('ofertas-placeholder');
    const feiranteId = document.getElementById('feirante_id').value;

    let ofertaIdParaExcluir = null;

    // --- FUNÇÕES DE LÓGICA PRINCIPAL ---

    const carregarOfertas = async () => {
        mostrarPlaceholder(true);
        tabelaOfertas.innerHTML = ''; 

        const url = `${API_URL}?feirante_id=${feiranteId}`;

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('A resposta da rede não foi OK: ' + response.statusText);
            }
            const ofertas = await response.json();
            
            if (!ofertas || ofertas.length === 0) {
                mostrarPlaceholder(false, 'Nenhuma oferta encontrada. Que tal criar uma nova?');
            } else {
                mostrarPlaceholder(false);
                ofertas.forEach(oferta => {
                    tabelaOfertas.appendChild(criarLinhaOferta(oferta));
                });
            }
        } catch (error) {
            console.error('Erro ao carregar ofertas:', error);
            mostrarPlaceholder(false, 'Erro ao carregar as ofertas. Verifique sua conexão ou tente mais tarde.');
            showToast('Erro ao buscar ofertas.', 'danger');
        }
    };

    const salvarOferta = async (event) => {
        event.preventDefault();

        const ofertaId = document.getElementById('ofertaId').value;

        const dadosOferta = {
            produto: document.getElementById('produto').value,
            descricao: document.getElementById('descricao').value,
            preco: document.getElementById('preco').value,
            quantidade_disponivel: document.getElementById('quantidade_disponivel').value,
            peso: document.getElementById('peso').value || null,
            feirante_id: parseInt(feiranteId)
        };

        const isUpdating = !!ofertaId;
        let url = API_URL;
        let method = 'POST';

        if(isUpdating) {
            url = `${API_URL}?id=${ofertaId}`;
            method = 'PUT';
        }

        try {
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dadosOferta)
            });

            const result = await response.json();

            if (result.status === 'success') {
                showToast(`Oferta ${isUpdating ? 'atualizada' : 'criada'} com sucesso!`, 'success');
                ofertaModal.hide();
                carregarOfertas(); 
            } else {
                throw new Error(result.message || 'Erro desconhecido ao salvar.');
            }
        } catch (error) {
            console.error('Erro ao salvar oferta:', error);
            showToast(error.message, 'danger');
        }
    }; 

    const editarOferta = (oferta) => {
        ofertaModalLabel.textContent = 'Editar Oferta';
        formOferta.reset();

        document.getElementById('ofertaId').value = oferta.id;
        document.getElementById('produto').value = oferta.produto;
        document.getElementById('descricao').value = oferta.descricao;
        document.getElementById('preco').value = oferta.preco;
        document.getElementById('quantidade_disponivel').value = oferta.quantidade_disponivel;
        document.getElementById('peso').value = oferta.peso;
        
        ofertaModal.show();
    };

    const excluirOferta = async () => {
        if (!ofertaIdParaExcluir) return;

        try {
            const response = await fetch(`${API_URL}?id=${ofertaIdParaExcluir}`, {
                method: 'DELETE'
            });

            const result = await response.json();

            if (result.status === 'success') {
                showToast('Oferta excluída com sucesso!', 'success');
                carregarOfertas();
            } else {
                throw new Error(result.message || 'Erro ao excluir.');
            }
        } catch (error) {
            console.error('Erro ao excluir oferta:', error);
            showToast(error.message, 'danger');
        } finally {
            confirmDeleteModal.hide();
            ofertaIdParaExcluir = null;
        }
    };


    // --- FUNÇÕES AUXILIARES E UI ---

    const criarLinhaOferta = (oferta) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <div class="fw-bold">${oferta.produto}</div>
                <div class="text-muted small">${oferta.descricao || ''}</div>
            </td>
            <td>R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}</td>
            <td>${oferta.quantidade_disponivel}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-secondary me-2" data-oferta-id="${oferta.id}" data-action="edit" style="min-width: 44px; min-height: 44px;">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" data-oferta-id="${oferta.id}" data-action="delete" style="min-width: 44px; min-height: 44px;">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        return tr;
    };
    
    const prepararNovoFormulario = () => {
        ofertaModalLabel.textContent = 'Anunciar Nova Xepa';
        formOferta.reset();
        document.getElementById('ofertaId').value = '';
    };

    const mostrarPlaceholder = (mostrar, mensagem = null) => {
        if (mostrar) {
            placeholder.style.display = 'block';
            placeholder.innerHTML = '<div class="spinner-border text-success" role="status"><span class="visually-hidden">Carregando...</span></div><p class="mt-2">Buscando suas ofertas...</p>';
        } else {
            if (mensagem) {
                 placeholder.style.display = 'block';
                 placeholder.innerHTML = `<p class="text-muted">${mensagem}</p>`;
            } else {
                placeholder.style.display = 'none';
            }
        }
    };


    // --- EVENT LISTENERS ---

    tabelaOfertas.addEventListener('click', async (event) => {
        const target = event.target.closest('button');
        if (!target) return;

        const action = target.dataset.action;
        const id = target.dataset.ofertaId;

        if (action === 'edit') {
            try {
                const response = await fetch(`${API_URL}?id=${id}`);
                if (!response.ok) throw new Error('Falha ao buscar dados da oferta.');
                const oferta = await response.json();
                editarOferta(oferta);
            } catch (error) {
                showToast(error.message, 'danger');
            }
        } else if (action === 'delete') {
            // Prepara o modal de confirmação
            const tr = target.closest('tr');
            const nomeProduto = tr.querySelector('.fw-bold').textContent;
            nomeProdutoExclusao.textContent = `"${nomeProduto}"`; // Adiciona aspas
            
            ofertaIdParaExcluir = id;
            confirmDeleteModal.show();
        }
    });
    
    confirmDeleteBtn.addEventListener('click', excluirOferta);

    formOferta.addEventListener('submit', salvarOferta);

    document.getElementById('btnNovaOferta').addEventListener('click', prepararNovoFormulario);
    document.getElementById('ofertaModal').addEventListener('hidden.bs.modal', prepararNovoFormulario);
    

    // --- INICIALIZAÇÃO ---
    carregarOfertas();
});