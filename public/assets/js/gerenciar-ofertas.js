document.addEventListener('DOMContentLoaded', () => {

    let API_URL = '/api/routes/ofertas.php';
    const CATEGORIAS_API_URL = '/api/routes/categorias.php';

    const tabelaOfertas = document.getElementById('tabelaOfertas');
    const ofertasPlaceholder = document.getElementById('ofertas-placeholder');
    
    const modalElement = document.getElementById('ofertaModal');
    const ofertaModal = new bootstrap.Modal(modalElement);
    const modalLabel = document.getElementById('ofertaModalLabel');
    const formOferta = document.getElementById('formOferta');
    const ofertaIdInput = document.getElementById('ofertaId');
    const feiranteIdInput = document.getElementById('feirante_id');

    // Campos do formulário
    const produtoInput = document.getElementById('produto');
    const descricaoInput = document.getElementById('descricao');
    const precoInput = document.getElementById('preco');
    const quantidadeInput = document.getElementById('quantidade_disponivel');
    const pesoInput = document.getElementById('peso');
    const categoriaSelect = document.getElementById('categoria');

    const btnNovaOferta = document.getElementById('btnNovaOferta');
    
    // Modal de exclusão
    const confirmDeleteModalElement = document.getElementById('confirmDeleteModal');
    const confirmDeleteModal = new bootstrap.Modal(confirmDeleteModalElement);
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const nomeProdutoExclusao = document.getElementById('nomeProdutoExclusao');
    let ofertaIdParaExcluir = null;

    /**
     * Carrega as categorias da API e popula o select no formulário.
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
            showToast('Falha ao carregar categorias. Tente recarregar a página.', 'error');
        }
    };


    /**
     * Busca as ofertas do feirante logado na API e as exibe na tabela.
     */
    const carregarOfertas = async () => {
        ofertasPlaceholder.style.display = 'block';
        tabelaOfertas.innerHTML = '';
        
        const feiranteId = feiranteIdInput.value;

        try {
            const response = await fetch(`${API_URL}?feirante_id=${feiranteId}`);
            if (!response.ok) {
                throw new Error(`A resposta da rede não foi OK: ${response.statusText}`);
            }
            const ofertas = await response.json();

            ofertasPlaceholder.style.display = 'none';

            if (ofertas && ofertas.length > 0) {
                ofertas.forEach(oferta => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${oferta.produto}</td>
                        <td>R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}</td>
                        <td>${oferta.quantidade_disponivel}</td>
                        <td><span class="badge bg-info text-dark">${oferta.categoria || 'N/A'}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-secondary me-2 editar-btn" style="min-width: 44px; min-height: 44px;" data-id="${oferta.id}"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger deletar-btn" style="min-width: 44px; min-height: 44px;" data-id="${oferta.id}" data-nome="${oferta.produto}"><i class="bi bi-trash"></i></button>
                        </td>
                    `;
                    tabelaOfertas.appendChild(tr);
                });
            } else {
                tabelaOfertas.innerHTML = '<tr><td colspan="5" class="text-center">Nenhuma oferta cadastrada.</td></tr>';
            }
        } catch (error) {
            console.error('Erro ao carregar ofertas:', error);
            ofertasPlaceholder.style.display = 'none';
            tabelaOfertas.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Erro ao carregar ofertas. Tente novamente mais tarde.</td></tr>';
        }
    };

    /**
     * Reseta e prepara o modal para uma nova oferta.
     */
    btnNovaOferta.addEventListener('click', () => {
        modalLabel.textContent = 'Anunciar Nova Xepa';
        formOferta.reset();
        ofertaIdInput.value = '';
        formOferta.classList.remove('was-validated');
    });

    /**
     * Manipula o envio do formulário, seja para criar ou atualizar uma oferta.
     */
    formOferta.addEventListener('submit', async (event) => {
        event.preventDefault();
        event.stopPropagation();

        if (!formOferta.checkValidity()) {
            formOferta.classList.add('was-validated');
            return;
        }

        const id = ofertaIdInput.value;
        const dadosOferta = {
            feirante_id: feiranteIdInput.value,
            produto: produtoInput.value,
            descricao: descricaoInput.value,
            preco: parseFloat(precoInput.value),
            quantidade_disponivel: parseInt(quantidadeInput.value),
            peso: pesoInput.value ? parseFloat(pesoInput.value) : null,
            categoria: categoriaSelect.value
        };

        const method = id ? 'PUT' : 'POST';
        let url = id ? `${API_URL}?id=${id}` : API_URL;

        try {
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dadosOferta)
            });

            const resultado = await response.json();

            if (resultado.status === 'success') {
                ofertaModal.hide();
                carregarOfertas(); 
                showToast(resultado.message, 'success');
            } else {
                throw new Error(resultado.message || 'Erro desconhecido ao salvar oferta.');
            }
        } catch (error) {
            console.error('Erro ao salvar oferta:', error);
            showToast(error.message, 'error');
        }
    });

    /**
     * Prepara e exibe o modal de edição com os dados da oferta clicada.
     * @param {number} id - O ID da oferta a ser editada.
     */
    const abrirModalEdicao = async (id) => {
        try {
            const response = await fetch(`${API_URL}?id=${id}`);
            if (!response.ok) {
                throw new Error('Não foi possível carregar os dados da oferta.');
            }
            const oferta = await response.json();

            modalLabel.textContent = 'Editar Oferta';
            ofertaIdInput.value = oferta.id;
            produtoInput.value = oferta.produto;
            descricaoInput.value = oferta.descricao;
            precoInput.value = oferta.preco;
            quantidadeInput.value = oferta.quantidade_disponivel;
            pesoInput.value = oferta.peso;
            categoriaSelect.value = oferta.categoria;

            formOferta.classList.remove('was-validated');
            ofertaModal.show();

        } catch (error) {
            console.error('Erro ao buscar dados para edição:', error);
            showToast(error.message, 'error');
        }
    };
    
    /**
     * Prepara e exibe o modal de confirmação para exclusão.
     * @param {number} id - O ID da oferta a ser excluída.
     * @param {string} nome - O nome do produto da oferta.
     */
    const abrirModalExclusao = (id, nome) => {
        ofertaIdParaExcluir = id;
        nomeProdutoExclusao.textContent = nome;
        confirmDeleteModal.show();
    };

    /**
     * Delega os eventos de clique na tabela para os botões de editar e excluir.
     */
    tabelaOfertas.addEventListener('click', (event) => {
        const target = event.target.closest('button');
        if (!target) return;

        const id = target.dataset.id;
        if (target.classList.contains('editar-btn')) {
            abrirModalEdicao(id);
        }
        if (target.classList.contains('deletar-btn')) {
            const nome = target.dataset.nome;
            abrirModalExclusao(id, nome);
        }
    });

    /**
     * Manipula a confirmação da exclusão de uma oferta.
     */
    confirmDeleteBtn.addEventListener('click', async () => {
        if (!ofertaIdParaExcluir) return;

        try {
            const response = await fetch(`${API_URL}?id=${ofertaIdParaExcluir}`, { // O ID vai na URL
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const resultado = await response.json();

            if (resultado.status === 'success') {
                confirmDeleteModal.hide();
                carregarOfertas(); 
                showToast(resultado.message, 'success');
            } else {
                throw new Error(resultado.message || 'Erro ao excluir a oferta.');
            }
        } catch (error) {
            console.error('Erro ao excluir oferta:', error);
            showToast(error.message, 'error');
        }
        ofertaIdParaExcluir = null;
    });

    
    // --- INICIALIZAÇÃO ---
    carregarCategorias();
    carregarOfertas();
});
