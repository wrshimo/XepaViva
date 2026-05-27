document.addEventListener('DOMContentLoaded', () => {
    const ofertasContainer = document.getElementById('ofertas-container');
    const placeholder = document.getElementById('ofertas-placeholder');
    const filtroTexto = document.getElementById('filtroTexto');
    const filtroCategoria = document.getElementById('filtroCategoria');

    let todasAsOfertas = [];

    const carregarTudo = async () => {
        renderPlaceholder('loading');
        try {
            const [categoriasResponse, ofertasResponse] = await Promise.all([
                fetch('../api/routes/categorias.php'),
                fetch('../api/routes/ofertas.php?disponivel=1') 
            ]);

            if (!categoriasResponse.ok) throw new Error('Falha ao carregar categorias');
            if (!ofertasResponse.ok) throw new Error('Falha ao carregar ofertas');

            const categoriasResult = await categoriasResponse.json();
            const ofertasResult = await ofertasResponse.json();

            if (categoriasResult.status === 'success' && Array.isArray(categoriasResult.data)) {
                filtroCategoria.innerHTML = '<option value="todas" selected>Todas as categorias</option>';
                categoriasResult.data.forEach(cat => {
                    // CORRIGIDO: Acessar a propriedade `nome` do objeto `cat`
                    const option = new Option(cat.nome, cat.nome);
                    filtroCategoria.add(option);
                });
            } else {
                filtroCategoria.innerHTML = '<option value="todas" selected>Erro ao carregar</option>';
            }
            
            if (ofertasResult.status === 'success' && Array.isArray(ofertasResult.data)) {
                todasAsOfertas = ofertasResult.data;
                aplicarFiltros(); 
            } else {
                renderPlaceholder('empty', 'Nenhuma xepa disponível no momento. Volte mais tarde!');
            }

        } catch (error) {
            console.error('Erro ao carregar a página:', error);
            renderPlaceholder('error', `Não foi possível carregar: ${error.message}`);
        }
    };

    const aplicarFiltros = () => {
        const texto = filtroTexto.value.toLowerCase();
        const categoriaSelecionada = filtroCategoria.value;

        const ofertasFiltradas = todasAsOfertas.filter(oferta => {
            const nome = oferta.nome || '';
            const descricao = oferta.descricao || '';
            const feirante = oferta.nome_feirante || '';
            const categoriaDaOferta = oferta.categoria || '';

            const matchTexto = nome.toLowerCase().includes(texto) || 
                               descricao.toLowerCase().includes(texto) || 
                               feirante.toLowerCase().includes(texto);
            
            const matchCategoria = (categoriaSelecionada === 'todas') || (categoriaDaOferta === categoriaSelecionada);

            return matchTexto && matchCategoria;
        });

        renderizarOfertas(ofertasFiltradas);
    };

    const renderizarOfertas = (ofertas) => {
        ofertasContainer.innerHTML = '';
        if (ofertas.length === 0) {
            renderPlaceholder('empty', 'Nenhuma xepa encontrada com os filtros aplicados.');
            return;
        }
        
        placeholder.style.display = 'none';
        ofertas.forEach(oferta => {
            const col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4';
            
            const isAvailable = parseInt(oferta.quantidade_disponivel, 10) > 0;

            const buttonOrLabel = isAvailable
                ? `<a href="reservar-item.php?oferta_id=${oferta.id}" class="btn btn-success mt-auto stretched-link">Reservar</a>`
                : `<button class="btn btn-secondary mt-auto" disabled>Esgotado</button>`;
            
            const categoriaBadge = oferta.categoria ? `<span class="badge bg-info text-dark me-2">${oferta.categoria}</span>` : '';

            const card = `
                <div class="card h-100 shadow-sm oferta-card ${!isAvailable ? 'opacity-50' : ''}">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title mb-1">${oferta.nome}</h5>
                            ${categoriaBadge}
                        </div>
                        <p class="card-text text-muted flex-grow-1">${oferta.descricao}</p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <p class="card-text fs-5 fw-bold text-success mb-0">R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}</p>
                            <span class="badge bg-secondary">~${parseFloat(oferta.peso).toFixed(1).replace('.', ',' )} kg</span>
                        </div>
                        <p class="card-text"><small class="text-muted">Vendido por: <strong>${oferta.nome_feirante || 'N/A'}</strong></small></p>
                        ${buttonOrLabel}
                    </div>
                </div>
            `;
            col.innerHTML = card;
            ofertasContainer.appendChild(col);
        });
    };

    const renderPlaceholder = (state, message) => {
        ofertasContainer.innerHTML = '';
        placeholder.style.display = 'block';
        switch (state) {
            case 'loading':
                placeholder.innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Carregando...</span></div><p class="mt-2">Buscando as melhores xepas...</p>`;
                break;
            case 'empty':
                placeholder.innerHTML = `<div class="text-center"><i class="bi bi-basket2 fs-1 text-muted"></i><p class="mt-2">${message}</p></div>`;
                break;
            case 'error':
                placeholder.innerHTML = `<div class="alert alert-danger">${message}</div>`;
                break;
        }
    };
    
    filtroTexto.addEventListener('input', aplicarFiltros);
    filtroCategoria.addEventListener('change', aplicarFiltros);

    carregarTudo();
});
