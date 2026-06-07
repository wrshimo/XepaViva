document.addEventListener('DOMContentLoaded', () => {
    const loadingState = document.getElementById('loading-state');
    const errorState = document.getElementById('error-state');
    const successState = document.getElementById('success-state');
    const scriptTag = document.getElementById('codigo-retirada-script') || document.querySelector('script[data-reserva-id]');
    const reservaId = scriptTag.dataset.reservaId;

    if (!reservaId || reservaId === '0') {
        loadingState.classList.add('d-none');
        errorState.classList.remove('d-none');
        console.error('ID da reserva inválido ou não fornecido.');
        return;
    }

    const fetchReservationDetails = async () => {
        try {
            // Este endpoint ainda será criado no backend
            const response = await fetch(`../api/routes/reservas.php?id=${reservaId}`);
            const result = await response.json();

            if (response.ok && result.status === 'success') {
                renderSuccessState(result.data);
            } else {
                throw new Error(result.message || 'Reserva não encontrada.');
            }

        } catch (error) {
            console.error('Falha ao buscar detalhes da reserva:', error);
            renderErrorState();
        }
    };

    const renderSuccessState = (reserva) => {
        document.getElementById('oferta-nome').textContent = reserva.oferta_nome;
        document.getElementById('feirante-nome').textContent = reserva.feirante_nome;
        document.getElementById('reserva-status').textContent = reserva.status;
        document.getElementById('codigo-retirada-text').textContent = reserva.codigo_retirada;

        // Gera o QR Code
        const qrcodeContainer = document.getElementById('qrcode');
        qrcodeContainer.innerHTML = ''; // Limpa o container caso haja algo
        new QRCode(qrcodeContainer, {
            text: reserva.codigo_retirada,
            width: 260,
            height: 260,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        loadingState.classList.add('d-none');
        successState.classList.remove('d-none');
    };

    const renderErrorState = () => {
        loadingState.classList.add('d-none');
        errorState.classList.remove('d-none');
    };

    fetchReservationDetails();
});
