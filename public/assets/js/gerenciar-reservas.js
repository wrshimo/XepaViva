document.addEventListener('DOMContentLoaded', () => {
    const tabelaReservas = document.getElementById('tabelaReservas');
    const placeholder = document.getElementById('reservas-placeholder');
    const feiranteId = document.getElementById('feiranteIdLogado')?.value;
    const filtroStatusContainer = document.getElementById('filtroStatus');

    // Modal de Confirmação
    const confirmacaoModalEl = document.getElementById('confirmacaoModal');
    const confirmacaoModal = new bootstrap.Modal(confirmacaoModalEl);
    const confirmacaoModalBody = document.getElementById('confirmacaoModalBody');
    const btnConfirmarAcao = document.getElementById('btnConfirmarAcao');

    const statusBadges = {
        'Aguardando Retirada': 'bg-warning text-dark',
        'Concluida': 'bg-success',
        'Cancelada pelo Feirante': 'bg-danger',
        'Cancelada pelo Consumidor': 'bg-danger',
        'Nao Compareceu': 'bg-secondary',
    };

    const carregarReservas = async () => {
        if (!feiranteId) {
            renderPlaceholder('error', 'ID do feirante não encontrado.');
            return;
        }

        renderPlaceholder('loading');

        const statusSelecionados = Array.from(filtroStatusContainer.querySelectorAll('input[type=checkbox]:checked'))
                                       .map(cb => cb.value.split(','))
                                       .flat();

        const params = new URLSearchParams({ feirante_id: feiranteId });
        statusSelecionados.forEach(status => params.append('status[]', status));

        try {
            const response = await fetch(`../api/routes/reservas.php?${params.toString()}`);
            if (!response.ok) throw new Error(`Erro na requisição: ${response.statusText}`);
            
            const result = await response.json();

            if (result.status === 'success' && Array.isArray(result.data)) {
                if(result.data.length > 0){
                    placeholder.style.display = 'none';
                    tabelaReservas.innerHTML = '';
                    result.data.forEach(reserva => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${reserva.cliente_nome}</td>
                            <td>${reserva.oferta_nome}</td>
                            <td>${reserva.quantidade_reservada}</td>
                            <td><strong>${reserva.codigo_retirada}</strong></td>
                            <td><span class="badge ${statusBadges[reserva.status] || 'bg-light text-dark'}">${reserva.status}</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-success action-btn" data-id="${reserva.id}" data-action="Concluida" title="Confirmar Retirada" ${reserva.status !== 'Aguardando Retirada' ? 'disabled' : ''}>
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                <button class="btn btn-sm btn-danger action-btn" data-id="${reserva.id}" data-action="Cancelada pelo Feirante" title="Cancelar Reserva" ${reserva.status !== 'Aguardando Retirada' ? 'disabled' : ''}>
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </td>
                        `;
                        tabelaReservas.appendChild(tr);
                    });
                } else {
                     renderPlaceholder('empty', 'Nenhuma reserva encontrada com os filtros selecionados.');
                }
            } else {
                throw new Error(result.message || "Falha ao decodificar a resposta do servidor.");
            }
        } catch (error) {
            console.error('Erro ao carregar reservas:', error);
            renderPlaceholder('error', `Falha ao buscar as reservas: ${error.message}`);
        }
    };

    const handleAcaoClick = (reservaId, novoStatus) => {
        if (confirmacaoModal) {
            confirmacaoModalBody.textContent = `Tem certeza que deseja marcar esta reserva como "${novoStatus}"?`;
            confirmacaoModal.show();

            // Remove o listener antigo para evitar chamadas múltiplas
            btnConfirmarAcao.replaceWith(btnConfirmarAcao.cloneNode(true));
            document.getElementById('btnConfirmarAcao').addEventListener('click', async () => {
                btnConfirmarAcao.disabled = true;
                await atualizarStatusReserva(reservaId, novoStatus);
                btnConfirmarAcao.disabled = false;
                confirmacaoModal.hide();
            });
        }
    };

    const atualizarStatusReserva = async (reservaId, novoStatus) => {
        try {
            const response = await fetch('../api/routes/reservas.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ reserva_id: reservaId, status: novoStatus })
            });
            const result = await response.json();
            if (response.ok && result.status === 'success') {
                showToast(result.message, 'success');
                await carregarReservas();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            showToast(error.message || 'Erro ao atualizar a reserva.', 'danger');
        }
    };

    const renderPlaceholder = (state, message) => {
        tabelaReservas.innerHTML = '';
        placeholder.style.display = 'block';
        switch (state) {
            case 'loading':
                placeholder.innerHTML = `<div class="spinner-border text-success" role="status"><span class="visually-hidden">Carregando...</span></div><p class="mt-2">Buscando suas reservas...</p>`;
                break;
            case 'empty':
                placeholder.innerHTML = `<div class="text-center"><i class="bi bi-search fs-1 text-muted"></i><p class="mt-2">${message}</p></div>`;
                break;
            case 'error':
                placeholder.innerHTML = `<div class="alert alert-danger">${message}</div>`;
                break;
        }
    };

    tabelaReservas.addEventListener('click', (event) => {
        const target = event.target.closest('.action-btn');
        if (target && !target.disabled) {
            const reservaId = target.dataset.id;
            const acao = target.dataset.action;
            handleAcaoClick(reservaId, acao);
        }
    });

    filtroStatusContainer.addEventListener('change', carregarReservas);

    carregarReservas();
});
