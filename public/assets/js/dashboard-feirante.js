document.addEventListener('DOMContentLoaded', () => {

    // --- URLs DA API (CORRIGIDAS DE ACORDO COM A ESPECIFICAÇÃO) ---
    const API_URL_OFERTAS = '/api/routes/ofertas.php';
    const API_URL_CATEGORIAS = '/api/routes/categorias.php';

    // --- ELEMENTOS DO DOM ---
    const ofertasRecentesContainer = document.getElementById('ofertasRecentesContainer');
    const feiranteIdInput = document.getElementById('feirante_id');
    
    // Modal de Oferta
    const ofertaModalElement = document.getElementById('ofertaModal');
    const ofertaModal = new bootstrap.Modal(ofertaModalElement);
    const formOferta = document.getElementById('formOferta');
    const ofertaModalLabel = document.getElementById('ofertaModalLabel');
    const categoriaSelect = document.getElementById('categoria');
    const ofertaIdInput = document.getElementById('ofertaId');

    // --- ESTADO DA APLICAÇÃO ---
    let currentUser = null;

    /**
     * Ponto de entrada: Verifica o usuário e inicia o carregamento dos dados.
     */
    const init = () => {
        currentUser = JSON.parse(localStorage.getItem('xepa-user'));

        if (!currentUser || currentUser.tipo !== 'feirante') {
            if (ofertasRecentesContainer) {
                ofertasRecentesContainer.innerHTML = '<div class="alert alert-danger">Erro: Usuário não autenticado ou não é um feirante.</div>';
            }
            return;
        }

        if (feiranteIdInput) {
            feiranteIdInput.value = currentUser.id;
        }

        carregarCategorias();
        carregarOfertasRecentes();
    };

    const carregarCategorias = async () => {
        try {
            const response = await fetch(API_URL_CATEGORIAS);
            const result = await response.json();
            if (result.status === 'success' && result.data) {
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

    const carregarOfertasRecentes = async () => {
        if (!currentUser || !ofertasRecentesContainer) return;

        const url = `${API_URL_OFERTAS}?feirante_id=${currentUser.id}`;
        ofertasRecentesContainer.innerHTML = '<p>Carregando ofertas...</p>';

        try {
            const response = await fetch(url);
            const result = await response.json();

            if (result.status === 'success' && result.data && result.data.length > 0) {
                ofertasRecentesContainer.innerHTML = '';
                const recentes = result.data.slice(0, 3);
                
                const listGroup = document.createElement('div');
                listGroup.className = 'list-group';

                recentes.forEach(oferta => {
                    const item = document.createElement('a');
                    item.href = 'minhas-ofertas.php';
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">${oferta.nome}</h5>
                            <small>Qtd: ${oferta.quantidade_disponivel}</small>
                        </div>
                        <p class="mb-1">R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}</p>
                        <small>Anunciado em: ${new Date(oferta.data_criacao).toLocaleDateString()}</small>
                    `;
                    listGroup.appendChild(item);
                });
                ofertasRecentesContainer.appendChild(listGroup);
            } else {
                ofertasRecentesContainer.innerHTML = '<div class="alert alert-secondary">Nenhuma oferta anunciada ainda. Clique em \"Anunciar Nova Xepa\" para começar!</div>';
            }
        } catch (error) {
            console.error('Erro ao carregar ofertas recentes:', error);
            ofertasRecentesContainer.innerHTML = '<div class="alert alert-danger">Não foi possível carregar as ofertas. Verifique a conexão.</div>';
        }
    };

    const handleSalvarOferta = async (event) => {
        event.preventDefault();
        event.stopPropagation();

        if (!formOferta.checkValidity()) {
            formOferta.classList.add('was-validated');
            return;
        }

        const dadosOferta = {
            feirante_id: feiranteIdInput.value,
            nome: document.getElementById('produto').value,
            descricao: document.getElementById('descricao').value,
            preco: document.getElementById('preco').value,
            quantidade_inicial: document.getElementById('quantidade_disponivel').value,
            quantidade_disponivel: document.getElementById('quantidade_disponivel').value,
            peso: document.getElementById('peso').value || null,
            categoria: categoriaSelect.value
        };
        
        const method = 'POST';
        const url = API_URL_OFERTAS;

        try {
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dadosOferta)
            });

            const result = await response.json();

            if (result.status === 'success') {
                showToast(result.message || 'Oferta salva com sucesso!', 'success');
                ofertaModal.hide();
                carregarOfertasRecentes();
            } else {
                throw new Error(result.message || 'Erro ao salvar oferta.');
            }
        } catch (error) {
            console.error('Erro ao salvar oferta:', error);
            showToast(error.message, 'error');
        }
    };

    ofertaModalElement.addEventListener('hidden.bs.modal', () => {
        formOferta.reset();
        formOferta.classList.remove('was-validated');
        ofertaIdInput.value = '';
        ofertaModalLabel.textContent = 'Anunciar Nova Xepa';
    });
    
    formOferta.addEventListener('submit', handleSalvarOferta);

    // --- INICIALIZAÇÃO ---
    init();
});
