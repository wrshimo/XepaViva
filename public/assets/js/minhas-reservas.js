document.addEventListener('DOMContentLoaded', () => {
    const reservationsContainer = document.getElementById('reservations-container');
    const loadingSpinner = document.getElementById('loading-spinner');
    const noReservationsMessage = document.getElementById('no-reservations-message');

    // 1. Pega os dados do usuário do localStorage
    const usuarioLogado = JSON.parse(localStorage.getItem('xepa-user'));

    // 2. Verifica se o usuário está logado
    if (!usuarioLogado || !usuarioLogado.id) {
        console.error('Usuário não está logado.');
        loadingSpinner.style.display = 'none';
        noReservationsMessage.textContent = 'Você precisa estar logado para ver suas reservas. Redirecionando para o login...';
        noReservationsMessage.classList.remove('d-none');
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 3000);
        return;
    }

    const consumidorId = usuarioLogado.id;

    // 3. Busca as reservas na API
    const fetchReservas = async () => {
        try {
            const response = await fetch(`../api/routes/reservas.php?consumidor_id=${consumidorId}`);
            const result = await response.json();

            loadingSpinner.style.display = 'none';

            if (response.ok && result.status === 'success' && result.data.length > 0) {
                renderReservas(result.data);
            } else {
                // Nenhuma reserva encontrada, mantém a mensagem original visível
                noReservationsMessage.classList.remove('d-none');
            }
        } catch (error) {
            console.error('Erro ao buscar reservas:', error);
            loadingSpinner.style.display = 'none';
            noReservationsMessage.textContent = 'Ocorreu um erro ao carregar suas reservas. Tente novamente mais tarde.';
            noReservationsMessage.classList.remove('d-none');
        }
    };

    // 4. Renderiza os cards de reserva na página
    const renderReservas = (reservas) => {
        reservationsContainer.innerHTML = ''; // Limpa o container
        reservas.forEach(reserva => {
            const card = document.createElement('div');
            card.className = 'col-md-6 col-lg-4 mb-4';
            card.innerHTML = `
                <div class="card h-100 shadow-sm reservation-card">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${reserva.oferta_nome}</h5>
                        <p class="card-text text-muted">Vendido por: ${reserva.feirante_nome}</p>
                        <ul class="list-unstyled flex-grow-1">
                            <li><strong>Cód. da Reserva:</strong> <span class="text-primary font-monospace">${reserva.codigo_retirada}</span></li>
                            <li><strong>Status:</strong> <span class="fw-bold">${reserva.status}</span></li>
                            <li><strong>Quantidade:</strong> ${reserva.quantidade_reservada}</li>
                            <li><strong>Valor Total:</strong> R$ ${reserva.valor_total.replace('.', ',')}</li>
                            <li><strong>Data:</strong> ${reserva.data_reserva_formatada}</li>
                        </ul>
                        <a href="codigo-retirada.php?reserva_id=${reserva.id}" class="btn btn-success mt-auto">Ver Código de Retirada</a>
                    </div>
                </div>
            `;
            reservationsContainer.appendChild(card);
        });
    };

    // 5. Inicia o processo
    fetchReservas();
});
