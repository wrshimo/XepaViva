// public/assets/js/dashboard-feirante.js

document.addEventListener('DOMContentLoaded', () => {
    carregarDadosDashboardFeirante();
});

async function carregarDadosDashboardFeirante() {
    try {
        const response = await fetch('api/routes/dashboard_feirante.php');
        if (!response.ok) {
            // Tenta ler o corpo da resposta para obter mais detalhes do erro
            const errorBody = await response.text();
            console.error('API Error Body:', errorBody);
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (result.status === 'success') {
            popularDados(result.data);
        } else {
            console.error('Erro ao carregar dados do dashboard:', result.message, result.error_details || '');
            document.querySelector('main').innerHTML = `<div class="alert alert-warning">Não foi possível carregar as informações do seu painel. Detalhe: ${result.message}</div>`;
        }
    } catch (error) {
        console.error('Falha na requisição para o dashboard do feirante:', error);
        // A mensagem de erro da API agora deve aparecer no console antes desta linha
        const mainContainer = document.querySelector('main');
        if (mainContainer) {
             mainContainer.innerHTML = '<div class="alert alert-danger">Ocorreu um erro crítico ao buscar os dados do painel. A API pode estar indisponível. Verifique o console para detalhes técnicos.</div>';
        }
    }
}

function popularDados(data) {
    // Popula os KPIs
    document.getElementById('kpi-ofertas-ativas').textContent = data.kpis.ofertas_ativas;
    document.getElementById('kpi-reservas-hoje').textContent = data.kpis.reservas_para_hoje;
    document.getElementById('kpi-clientes-atendidos').textContent = data.kpis.clientes_atendidos;

    // Popula Reservas Aguardando Retirada
    const reservasContainer = document.getElementById('reservas-retirada-container');
    const semReservasMsg = document.getElementById('sem-reservas-retirada');
    if (data.reservas_para_retirada && data.reservas_para_retirada.length > 0) {
        reservasContainer.innerHTML = ''; // Limpa o container
        const listGroup = document.createElement('div');
        listGroup.className = 'list-group';

        data.reservas_para_retirada.forEach(reserva => {
            const item = document.createElement('div');
            item.className = 'list-group-item list-group-item-action flex-column align-items-start';
            item.innerHTML = `
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">${reserva.produto_nome} (x${reserva.quantidade})</h5>
                    <small>Cód: <strong>${reserva.codigo_retirada}</strong></small>
                </div>
                <p class="mb-1">Cliente: ${reserva.consumidor_nome}</p>
                <button class="btn btn-sm btn-success mt-2" onclick="marcarComoRetirado(${reserva.reserva_id})">Marcar como Retirado</button>
            `;
            listGroup.appendChild(item);
        });
        reservasContainer.appendChild(listGroup);
        semReservasMsg.style.display = 'none';
    } else {
        semReservasMsg.style.display = 'block';
    }

    // Popula Produtos Mais Vendidos
    const topProdutosContainer = document.getElementById('top-produtos-container');
    const semTopProdutosMsg = document.getElementById('sem-top-produtos');
    if (data.produtos_mais_vendidos && data.produtos_mais_vendidos.length > 0) {
        topProdutosContainer.innerHTML = '';
        const listGroup = document.createElement('div');
        listGroup.className = 'list-group list-group-numbered';
        data.produtos_mais_vendidos.forEach(produto => {
            const item = document.createElement('a');
            item.href = '#'; // Poderia levar para uma página de detalhes do produto
            item.className = 'list-group-item d-flex justify-content-between align-items-start';
            item.innerHTML = `
                <div class="ms-2 me-auto">
                    <div class="fw-bold">${produto.produto_nome}</div>
                </div>
                <span class="badge bg-primary rounded-pill">${produto.total_vendido} vendidos</span>
            `;
            listGroup.appendChild(item);
        });
        topProdutosContainer.appendChild(listGroup);
        semTopProdutosMsg.style.display = 'none';
    } else {
        semTopProdutosMsg.style.display = 'block';
    }
}

function marcarComoRetirado(reservaId) {
    console.log(`Marcando reserva ${reservaId} como retirado.`);
    alert(`Funcionalidade para marcar a reserva ${reservaId} como retirada ainda não implementada.`);
}