// public/assets/js/dashboard-consumidor.js

document.addEventListener('DOMContentLoaded', () => {
    carregarDadosDashboard();
});

async function carregarDadosDashboard() {
    try {
        const response = await fetch('api/routes/dashboard_consumidor.php');
        if (!response.ok) {
            if (response.status === 403) {
                window.location.href = 'login.html';
                return;
            }
            // Tenta obter mais detalhes do erro do corpo da resposta, se possível
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
        console.error('Falha na requisição para o dashboard:', error);
        // O erro de sintaxe "missing )" provavelmente acontece aqui ao tentar fazer JSON.parse() de uma resposta de erro que não é JSON.
        document.querySelector('main').innerHTML = '<div class="alert alert-danger">Erro de comunicação ao buscar dados do painel. Verifique o console para detalhes técnicos.</div>';
    }
}

function popularDados(data) {
    // Popula os KPIs
    document.getElementById('kpi-economia-total').textContent = `R$ ${data.kpis.economia_total_reais.toFixed(2).replace('.', ',')}`;
    // CORREÇÃO: Removido o `_` extra que causava o erro de sintaxe.
    document.getElementById('kpi-kg-salvos').textContent = `${data.kpis.alimentos_salvos_kg.toFixed(1).replace('.', ',')} Kg`;
    document.getElementById('kpi-total-reservas').textContent = data.kpis.total_reservas;

    // Popula as Reservas Ativas
    const ativasContainer = document.getElementById('reservas-ativas-container');
    const ativasSection = document.getElementById('reservas-ativas-section');
    if (data.reservas_ativas && data.reservas_ativas.length > 0) {
        ativasContainer.innerHTML = '';
        data.reservas_ativas.forEach(reserva => {
            const card = `
                <div class="card mb-3 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h5 class="card-title mb-1">${reserva.produto}</h5>
                            <p class="card-text mb-0"><small class="text-muted">Feirante: ${reserva.feirante}</small></p>
                        </div>
                        <a href="codigo-retirada.php?reserva_id=${reserva.id}" class="btn btn-success mt-2 mt-md-0" style="min-height: 44px; min-width: 44px;">Ver Código</a>
                    </div>
                </div>
            `;
            ativasContainer.innerHTML += card;
        });
        ativasSection.style.display = 'block';
    } else {
        ativasSection.style.display = 'none';
    }

    // Popula o Histórico de Reservas
    const historicoBody = document.getElementById('historico-table-body');
    const semHistoricoInfo = document.getElementById('sem-historico');
    const historicoTable = document.getElementById('historico-table-container');
    if (data.historico_reservas && data.historico_reservas.length > 0) {
        historicoBody.innerHTML = '';
        data.historico_reservas.forEach(item => {
            const statusClass = getStatusClass(item.status);
            const row = `
                <tr>
                    <td>${item.produto}</td>
                    <td>${new Date(item.data_reserva).toLocaleDateString('pt-BR')}</td>
                    <td><span class="badge ${statusClass}">${item.status}</span></td>
                    <td>R$ ${parseFloat(item.preco_final).toFixed(2).replace('.', ',')}</td>
                    <td><a href="reserva-detalhe.html?id=${item.id}" class="btn btn-sm btn-outline-primary">Ver</a></td>
                </tr>
            `;
            historicoBody.innerHTML += row;
        });
        semHistoricoInfo.style.display = 'none';
        historicoTable.style.display = 'block';
    } else {
        semHistoricoInfo.style.display = 'block';
        historicoTable.style.display = 'none';
    }

    // Popula Feirantes Favoritos
    const favoritosContainer = document.getElementById('feirantes-favoritos-container');
    const favoritosSection = document.getElementById('favoritos-section');
    if (data.feirantes_favoritos && data.feirantes_favoritos.length > 0) {
        favoritosContainer.innerHTML = '';
        data.feirantes_favoritos.forEach(feirante => {
            const card = `
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-shop fs-2 text-muted"></i>
                            <h5 class="card-title mt-2">${feirante.nome_fantasia}</h5>
                            <p class="card-text"><span class="badge bg-light text-dark">${feirante.num_reservas} compras</span></p>
                        </div>
                    </div>
                </div>
            `;
            favoritosContainer.innerHTML += card;
        });
        favoritosSection.style.display = 'block';
    } else {
        favoritosSection.style.display = 'none';
    }
}

function getStatusClass(status) {
    switch (status) {
        case 'Concluida':
            return 'bg-success';
        case 'Pendente':
        case 'Aguardando Retirada':
            return 'bg-warning text-dark';
        case 'Cancelada':
        case 'Expirada':
        case 'Nao Compareceu':
            return 'bg-danger';
        default:
            return 'bg-secondary';
    }
}
