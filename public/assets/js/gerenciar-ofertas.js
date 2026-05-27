document.addEventListener('DOMContentLoaded', () => {

    const API_URL_OFERTAS = '/api/routes/ofertas.php';
    const API_URL_CATEGORIAS = '/api/routes/categorias.php';

    const tabelaOfertasBody = document.getElementById('tabelaOfertas');
    const ofertasPlaceholder = document.getElementById('ofertas-placeholder');
    const feiranteIdInput = document.getElementById('feirante_id');

    const ofertaModal = new bootstrap.Modal(document.getElementById('ofertaModal'));
    const formOferta = document.getElementById('formOferta');
    const ofertaModalLabel = document.getElementById('ofertaModalLabel');
    const ofertaIdInput = document.getElementById('ofertaId');
    const quantidadeDisponivelInput = document.getElementById('quantidade_disponivel');

    let currentUser = null;

    const init = () => {
        currentUser = JSON.parse(localStorage.getItem('xepa-user'));
        
        // CORREÇÃO: A verificação agora usa 'Feirante' (maiúsculo) para corresponder
        // aos dados salvos no localStorage pelo auth.js.
        if (!currentUser || currentUser.tipo !== 'Feirante') {
            setPlaceholderState('erro', 'Usuário inválido ou não autenticado.');
            return;
        }

        if (feiranteIdInput) {
            feiranteIdInput.value = currentUser.id;
        }
        carregarCategorias();
        carregarOfertas();
        setupEventListeners();
    };

    const carregarOfertas = async () => {
        if (!currentUser) return;
        setPlaceholderState('loading');
        try {
            const cacheBuster = `_=${new Date().getTime()}`;
            const url = `${API_URL_OFERTAS}?feirante_id=${currentUser.id}&${cacheBuster}`;
            
            const response = await fetch(url);
            
            // Tratamento de erro HTTP
            if (!response.ok) {
                let errorMsg = `Erro HTTP: ${response.status}`;
                try {
                    const errorResult = await response.json();
                    errorMsg = errorResult.message || errorMsg;
                } catch (e) { /* Ignora se o corpo não for JSON */ }
                throw new Error(errorMsg);
            }

            const result = await response.json();

            if (result.status === 'success' && Array.isArray(result.data)) {
                 if (result.data.length > 0) {
                    renderTabela(result.data);
                } else {
                    setPlaceholderState('vazio');
                }
            } else {
                setPlaceholderState('erro', result.message || 'Nenhuma oferta encontrada.');
            }
        } catch (error) {
            console.error('Erro ao carregar ofertas:', error);
            setPlaceholderState('erro', error.message || 'Falha ao carregar ofertas.');
        }
    };

    const carregarCategorias = async () => {
        try {
            const response = await fetch(API_URL_CATEGORIAS);
            const result = await response.json();
            if (result.status === 'success' && result.data) {
                const categoriaSelect = document.getElementById('categoria');
                categoriaSelect.innerHTML = '<option value="" selected disabled>Selecione...</option>';
                result.data.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.nome;
                    option.textContent = cat.nome;
                    categoriaSelect.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Erro ao carregar categorias:', error);
        }
    };

    const renderTabela = (ofertas) => {
        tabelaOfertasBody.innerHTML = '';
        ofertasPlaceholder.style.display = 'none';
        tabelaOfertasBody.style.display = '';
        ofertas.forEach(oferta => {
            const tr = document.createElement('tr');
            const isChecked = oferta.disponivel == 1 ? 'checked' : '';
            tr.innerHTML = `
                <td>${oferta.nome}</td>
                <td>R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}</td>
                <td>${oferta.quantidade_disponivel}</td>
                <td><span class="badge bg-secondary">${oferta.categoria || 'N/A'}</span></td>
                <td class="text-center">
                    <div class="form-check form-switch d-inline-block align-middle me-2">
                        <input class="form-check-input status-switch" type="checkbox" role="switch" data-id="${oferta.id}" ${isChecked}>
                    </div>
                    <button class="btn btn-sm btn-outline-primary btn-edit" data-id="${oferta.id}" style="min-width: 44px; min-height: 44px;">Editar</button>
                </td>
            `;
            tabelaOfertasBody.appendChild(tr);
        });
    };

    const setPlaceholderState = (state, message = '') => {
        tabelaOfertasBody.style.display = 'none';
        ofertasPlaceholder.style.display = '';
        switch (state) {
            case 'loading':
                ofertasPlaceholder.innerHTML = '<div class="spinner-border text-success" role="status"></div><p class="mt-2">Buscando suas ofertas...</p>';
                break;
            case 'vazio':
                ofertasPlaceholder.innerHTML = '<p>Nenhuma oferta encontrada. Clique em "Anunciar Nova Xepa" para começar.</p>';
                break;
            case 'erro':
                ofertasPlaceholder.innerHTML = `<p class="text-danger fw-bold">${message}</p>`;
                break;
        }
    };

    const setupEventListeners = () => {
        formOferta.addEventListener('submit', handleSalvarOferta);
        document.getElementById('btnNovaOferta').addEventListener('click', handleAbrirModalCriacao);
        tabelaOfertasBody.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-edit')) {
                handleAbrirModalEdicao(e.target.dataset.id);
            }
            if (e.target.classList.contains('status-switch')) {
                handleToggleDisponibilidade(e.target.dataset.id, e.target.checked);
            }
        });
    };

    const handleToggleDisponibilidade = async (id, isDisponivel) => {
        try {
            const response = await fetch(`${API_URL_OFERTAS}?id=${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ disponivel: isDisponivel ? 1 : 0 })
            });
            const result = await response.json();
            if (result.status === 'success') {
                showToast('Status da oferta atualizado com sucesso.', 'success');
                // Não precisa recarregar a tabela inteira, apenas confirma a mudança.
            } else {
                throw new Error(result.message);
            }
        } catch(error) {
            showToast(error.message || 'Falha ao atualizar o status da oferta.', 'error');
            carregarOfertas(); // Recarrega para reverter a mudança visual do switch
        }
    };

    const handleAbrirModalCriacao = () => {
        formOferta.reset();
        formOferta.classList.remove('was-validated');
        ofertaIdInput.value = '';
        ofertaModalLabel.textContent = 'Anunciar Nova Xepa';
        quantidadeDisponivelInput.readOnly = false;
        ofertaModal.show();
    };

    const handleAbrirModalEdicao = async (id) => {
        formOferta.reset();
        formOferta.classList.remove('was-validated');
        try {
            const response = await fetch(`${API_URL_OFERTAS}?id=${id}`);
            const result = await response.json();
            if (result.status === 'success' && result.data && result.data.length > 0) {
                const oferta = result.data[0]; 
                ofertaIdInput.value = oferta.id;
                document.getElementById('produto').value = oferta.nome;
                document.getElementById('descricao').value = oferta.descricao;
                document.getElementById('preco').value = oferta.preco;
                document.getElementById('quantidade_disponivel').value = oferta.quantidade_disponivel;
                document.getElementById('peso').value = oferta.peso;
                document.getElementById('categoria').value = oferta.categoria;
                quantidadeDisponivelInput.readOnly = true;
                ofertaModalLabel.textContent = 'Editar Oferta';
                ofertaModal.show();
            } else {
                showToast(result.message || 'Falha ao carregar dados da oferta para edição.', 'error');
            }
        } catch(e) { 
            console.error(e);
            showToast('Erro de comunicação ao tentar editar oferta.', 'error');
        }
    };

    const handleSalvarOferta = async (event) => {
        event.preventDefault();
        if (!formOferta.checkValidity()) {
            event.stopPropagation();
            formOferta.classList.add('was-validated');
            return;
        }
        const id = ofertaIdInput.value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${API_URL_OFERTAS}?id=${id}` : API_URL_OFERTAS;
        const dadosOferta = {
            feirante_id: currentUser.id,
            nome: document.getElementById('produto').value,
            descricao: document.getElementById('descricao').value,
            preco: document.getElementById('preco').value,
            quantidade_disponivel: quantidadeDisponivelInput.value,
            peso: document.getElementById('peso').value || null,
            categoria: document.getElementById('categoria').value,
            unidade_medida: 'kit' 
        };
        if (method === 'POST') {
            dadosOferta.quantidade_inicial = quantidadeDisponivelInput.value;
        }
        try {
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dadosOferta)
            });
            const result = await response.json();
            if (result.status === 'success') {
                showToast(result.message, 'success');
                ofertaModal.hide();
                carregarOfertas();
            } else {
                throw new Error(result.message);
            }
        } catch(error) {
            showToast(error.message || 'Erro ao salvar a oferta.', 'error');
        }
    };

    init();
});
