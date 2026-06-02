document.addEventListener('DOMContentLoaded', () => {
    // Elementos da UI
    const reservationsContainer = document.getElementById('reservations-container');
    const loadingSpinner = document.getElementById('loading-spinner');
    const noReservationsMessage = document.getElementById('no-reservations-message');
    const filterContainer = document.getElementById('filtroStatusConsumidor');

    // Pega o ID do consumidor do localStorage
    const usuarioLogado = JSON.parse(localStorage.getItem('xepa-user'));

    if (!usuarioLogado || !usuarioLogado.id) {
        console.error('Usuário não está logado.');
        reservationsContainer.innerHTML = '<p class="text-danger text-center">Você precisa estar logado para ver suas reservas. Redirecionando...</p>';
        setTimeout(() => { window.location.href = 'login.php'; }, 3000);
        return;
    }
    const consumidorId = usuarioLogado.id;

    const getStatusInfo = (status) => {
        const statusLower = status.toLowerCase();
        switch (statusLower) {
            case 'aguardando retirada':
                return { badgeClass: 'bg-warning text-dark', text: 'Aguardando Retirada', cardClass: 'status-aguardando' };
            case 'concluida':
                return { badgeClass: 'bg-success', text: 'Concluída', cardClass: 'status-concluida' };
            case 'cancelada pelo consumidor':
            case 'cancelada pelo feirante':
            case 'expirada':
            case 'nao compareceu':
                return { badgeClass: 'bg-danger', text: 'Cancelada/Expirada', cardClass: 'status-cancelada' };
            default:
                return { badgeClass: 'bg-secondary', text: status, cardClass: 'status-desconhecido' };
        }
    };

    const renderReservas = (reservas) => {
        reservationsContainer.innerHTML = ''; // Limpa o container
        reservas.forEach(reserva => {
            const statusInfo = getStatusInfo(reserva.status);
            
            const card = document.createElement('div');
            card.className = `col-md-6 col-lg-4 mb-4`;
            
            // REMOVIDA a linha que exibia a imagem
            card.innerHTML = `
                <div class="card h-100 shadow-sm reservation-card ${statusInfo.cardClass}">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title mb-1">${reserva.oferta_nome}</h5>
                            <span class="badge ${statusInfo.badgeClass} ms-2">${statusInfo.text}</span>
                        </div>
                        <p class="card-text text-muted small mb-2">Vendido por: ${reserva.feirante_nome}</p>
                        <ul class="list-unstyled flex-grow-1 small">
                            <li><strong>Cód. da Reserva:</strong> <span class="text-primary font-monospace">${reserva.codigo_retirada}</span></li>
                            <li><strong>Quantidade:</strong> ${reserva.quantidade_reservada}</li>
                            <li><strong>Valor Total:</strong> R$ ${reserva.valor_total.replace('.', ',')}</li>
                            <li><strong>Data:</strong> ${reserva.data_reserva_formatada}</li>
                        </ul>
                         ${reserva.status.toLowerCase() === 'aguardando retirada' ? `<a href="codigo-retirada.php?reserva_id=${reserva.id}" class="btn btn-sm btn-success mt-auto">Ver Código QR</a>` : ''}
                    </div>
                </div>
            `;
            reservationsContainer.appendChild(card);
        });
    };

    const fetchAndRenderReservas = async () => {
        loadingSpinner.style.display = 'block';
        noReservationsMessage.classList.add('d-none');
        reservationsContainer.innerHTML = '';

        const checkedBoxes = filterContainer.querySelectorAll('input[type="checkbox"]:checked');
        let statusQuery = '';
        checkedBoxes.forEach(checkbox => {
            const statuses = checkbox.value.split(',');
            statuses.forEach(status => {
                statusQuery += `&status[]=${encodeURIComponent(status)}`;
            });
        });

        const apiUrl = `../api/routes/reservas.php?consumidor_id=${consumidorId}${statusQuery}`;

        try {
            const response = await fetch(apiUrl);
            const result = await response.json();

            if (response.ok && result.status === 'success' && result.data.length > 0) {
                renderReservas(result.data);
            } else {
                noReservationsMessage.classList.remove('d-none');
            }
        } catch (error) {
            console.error('Erro ao buscar reservas:', error);
            noReservationsMessage.textContent = 'Ocorreu um erro ao carregar suas reservas. Tente novamente mais tarde.';
            noReservationsMessage.classList.remove('d-none');
        } finally {
            loadingSpinner.style.display = 'none';
        }
    };

    filterContainer.addEventListener('change', fetchAndRenderReservas);

    fetchAndRenderReservas();
});
