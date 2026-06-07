document.addEventListener('DOMContentLoaded', function () {
    const API_URL = 'api/routes/impacto.php';

    // Paleta de cores do projeto
    const CoresProjeto = {
        sucesso: '#2ECC71',
        primaria: '#0D6EFD',
        perigo: '#DC3545',
        aviso: '#FFC107',
        info: '#0DCAF0',
        cinza: '#6C757D',
        grafico: ['#2ECC71', '#0D6EFD', '#FFC107', '#0DCAF0', '#8A2BE2', '#FF6347']
    };

    // Função para animar números
    function animarNumero(elemento, valorFinal) {
        let valorInicial = 0;
        const duracao = 1500; // ms
        const passo = (timestamp) => {
            if (!inicio) inicio = timestamp;
            const progresso = Math.min((timestamp - inicio) / duracao, 1);
            let valorCorrente = Math.floor(progresso * valorFinal);
            elemento.textContent = valorCorrente.toLocaleString('pt-BR');
            if (progresso < 1) {
                window.requestAnimationFrame(passo);
            }
        };
        let inicio;
        window.requestAnimationFrame(passo);
    }

    // Função para formatar moeda
    function formatarMoeda(valor) {
        return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    async function carregarDashboard() {
        try {
            const response = await fetch(API_URL);
            if (!response.ok) {
                throw new Error(`Erro na API: ${response.statusText}`);
            }
            const resultado = await response.json();

            if (resultado.status === 'success') {
                const dados = resultado.data;
                atualizarKPIs(dados.kpis);
                renderizarGraficos(dados.graficos);
            }

        } catch (error) {
            console.error("Falha ao carregar dados do dashboard:", error);
            // Mostrar mensagem de erro na UI, se necessário
        }
    }

    function atualizarKPIs(kpis) {
        document.getElementById('kpi-kg-salvo').textContent = kpis.alimento_salvo_kg.toFixed(2).replace('.', ',') + ' Kg';
        document.getElementById('kpi-renda-gerada').textContent = formatarMoeda(kpis.renda_gerada_reais);
        animarNumero(document.getElementById('kpi-feirantes'), kpis.feirantes_parceiros);
        animarNumero(document.getElementById('kpi-familias'), kpis.familias_impactadas);
        animarNumero(document.getElementById('kpi-reservas'), kpis.reservas_concluidas);
    }

    function renderizarGraficos(graficos) {
        renderizarGraficoCategorias(graficos.top_categorias);
        renderizarGraficoStatus(graficos.status_reservas);
    }

    function renderizarGraficoCategorias(dados) {
        const ctx = document.getElementById('chart-categorias').getContext('2d');
        const labels = dados.map(d => d.categoria);
        const valores = dados.map(d => d.kg_por_categoria);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kg Salvos',
                    data: valores,
                    backgroundColor: CoresProjeto.grafico,
                    borderColor: CoresProjeto.grafico.map(cor => cor + 'B3'), // 70% de opacidade
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` ${context.dataset.label}: ${context.parsed.y} Kg`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return value + 'Kg' }
                        }
                    }
                }
            }
        });
    }

    function renderizarGraficoStatus(dados) {
        const ctx = document.getElementById('chart-status-reservas').getContext('2d');
        const labels = dados.map(d => d.status_agrupado);
        const valores = dados.map(d => d.contagem);
        
        const coresStatus = {
            'Concluida': CoresProjeto.sucesso,
            'Aguardando Retirada': CoresProjeto.info,
            'Confirmada': CoresProjeto.primaria,
            'Pendente': CoresProjeto.aviso,
            'Cancelada': CoresProjeto.perigo,
            'Nao Compareceu': CoresProjeto.cinza,
            'Expirada': '#343a40'
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: valores,
                    backgroundColor: labels.map(label => coresStatus[label] || CoresProjeto.cinza),
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    }

    carregarDashboard();
});
