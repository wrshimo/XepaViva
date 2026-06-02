document.addEventListener('DOMContentLoaded', () => {
    // Elementos da UI
    const loadingPlaceholder = document.getElementById('loading-placeholder');
    const ofertaContent = document.getElementById('oferta-content');
    const feedbackMessage = document.getElementById('feedback-message');
    
    // Campos de detalhes da oferta
    const ofertaNome = document.getElementById('oferta-nome');
    const ofertaDescricao = document.getElementById('oferta-descricao');
    const ofertaFeirante = document.getElementById('oferta-feirante');
    const ofertaCategoria = document.getElementById('oferta-categoria');
    const ofertaPreco = document.getElementById('oferta-preco');
    const ofertaDisponivel = document.getElementById('oferta-disponivel');

    // Formulário de reserva
    const formReserva = document.getElementById('form-reserva');
    const quantidadeInput = document.getElementById('quantidade');
    const submitButton = document.getElementById('submit-button');
    const submitButtonSpinner = submitButton.querySelector('.spinner-border');

    let ofertaAtual = null;

    const urlParams = new URLSearchParams(window.location.search);
    const ofertaId = urlParams.get('oferta_id');

    if (!ofertaId) {
        showFeedback('danger', 'ID da oferta não fornecido. Você será redirecionado.');
        setTimeout(() => window.location.href = 'buscar-ofertas.php', 3000);
        return;
    }

    const carregarDetalhesOferta = async () => {
        try {
            const response = await fetch(`../api/routes/ofertas.php?id=${ofertaId}`);
            const result = await response.json();

            if (response.ok && result.status === 'success' && result.data.length > 0) {
                ofertaAtual = result.data[0];
                displayOfertaDetails();
                loadingPlaceholder.classList.add('d-none');
                ofertaContent.classList.remove('d-none');
            } else {
                throw new Error(result.message || 'Oferta não encontrada ou indisponível.');
            }
        } catch (error) {
            console.error('Erro ao carregar detalhes:', error);
            loadingPlaceholder.classList.add('d-none');
            showFeedback('danger', `Não foi possível carregar a oferta. ${error.message}`);
        }
    };

    const displayOfertaDetails = () => {
        if (!ofertaAtual) return;

        ofertaNome.textContent = ofertaAtual.nome;
        ofertaDescricao.textContent = ofertaAtual.descricao || 'Sem descrição.';
        ofertaFeirante.textContent = ofertaAtual.nome_feirante || 'Desconhecido';
        ofertaCategoria.textContent = ofertaAtual.categoria;
        ofertaPreco.textContent = `R$ ${parseFloat(ofertaAtual.preco).toFixed(2).replace('.', ',')}`;
        ofertaDisponivel.textContent = `${ofertaAtual.quantidade_disponivel}`;

        quantidadeInput.max = ofertaAtual.quantidade_disponivel;
        if (parseInt(ofertaAtual.quantidade_disponivel) === 0) {
            submitButton.disabled = true;
            submitButton.textContent = 'Esgotado';
            quantidadeInput.disabled = true;
            showFeedback('warning', 'Este item está esgotado e não pode ser reservado.');
        }
    };

    const handleReservaSubmit = async (event) => {
        event.preventDefault();
        event.stopPropagation();
        
        formReserva.classList.add('was-validated');
        if (!formReserva.checkValidity()) {
            return;
        }

        // CORREÇÃO DEFINITIVA: Lendo a chave correta do localStorage.
        const usuarioLogado = JSON.parse(localStorage.getItem('xepa-user'));

        if (!usuarioLogado || !usuarioLogado.id) {
            showFeedback('danger', 'Você precisa estar logado para fazer uma reserva. Redirecionando para o login...');
            setTimeout(() => window.location.href = 'login.php', 3000);
            return;
        }
        
        const quantidade = parseInt(quantidadeInput.value);
        if (quantidade > parseInt(ofertaAtual.quantidade_disponivel)) {
            showFeedback('danger', 'A quantidade desejada é maior que o estoque disponível.');
            quantidadeInput.classList.add('is-invalid');
            return;
        }

        setSubmitButtonState(true);

        const reservaData = {
            oferta_id: ofertaAtual.id,
            consumidor_id: usuarioLogado.id,
            quantidade_reservada: quantidade
        };

        try {
            const response = await fetch('../api/routes/reservas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(reservaData)
            });

            const result = await response.json();

            if (response.ok && result.status === 'success') {
                const successMsg = result.data && result.data.codigo_retirada 
                    ? `Reserva confirmada! Seu código para retirada é <strong>${result.data.codigo_retirada}</strong>.`
                    : 'Reserva realizada com sucesso!';
                showFeedback('success', `${successMsg} Você será redirecionado...`, true);
                setTimeout(() => window.location.href = 'minhas-reservas.php', 4000);
            } else {
                throw new Error(result.message || 'Não foi possível completar a reserva.');
            }
        } catch (error) {
            console.error('Erro ao criar reserva:', error);
            showFeedback('danger', `Erro: ${error.message}`);
            setSubmitButtonState(false);
        }
    };
    
    const showFeedback = (type, message, isSticky = false) => {
        feedbackMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
        if (!isSticky) {
            setTimeout(() => feedbackMessage.innerHTML = '', 5000);
        }
    };

    const setSubmitButtonState = (isLoading) => {
        if (isLoading) {
            submitButton.disabled = true;
            submitButtonSpinner.classList.remove('d-none');
        } else {
            submitButton.disabled = false;
            submitButtonSpinner.classList.add('d-none');
        }
    };

    formReserva.addEventListener('submit', handleReservaSubmit);

    carregarDetalhesOferta();
});