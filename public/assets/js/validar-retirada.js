document.addEventListener('DOMContentLoaded', () => {
    const validationContainer = document.getElementById('validation-container');
    const codigoInput = document.getElementById('codigo-input');
    const validarBtn = document.getElementById('validar-btn');
    const startScanBtn = document.getElementById('start-scan-btn');
    const scannerSection = document.getElementById('scanner-section');
    const stopScanBtn = document.getElementById('stop-scan-btn');
    const resultSection = document.getElementById('result-section');

    let html5QrcodeScanner;

    const onScanSuccess = (decodedText, decodedResult) => {
        stopScanner();
        codigoInput.value = decodedText;
        buscarReserva(decodedText);
    };

    const startScanner = () => {
        html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            onScanSuccess,
            (errorMessage) => { /* ignore errors */ }
        ).then(() => {
            validationContainer.classList.add('scan-active');
            scannerSection.classList.remove('d-none');
        }).catch(err => {
            console.error(`Não foi possível iniciar o scanner: ${err}`);
            alert('Não foi possível acessar a câmera. Verifique as permissões do seu navegador.');
        });
    };

    const stopScanner = () => {
        if (html5QrcodeScanner && html5QrcodeScanner.isScanning) {
            html5QrcodeScanner.stop().then(() => {
                validationContainer.classList.remove('scan-active');
                scannerSection.classList.add('d-none');
            }).catch(err => {
                console.error("Falha ao parar o scanner", err);
            });
        }
    };

    const buscarReserva = async (codigo) => {
        resultSection.innerHTML = `<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Buscando...</span></div><p class="mt-2">Buscando reserva...</p></div>`;
        
        if (!codigo) {
            resultSection.innerHTML = renderError('Por favor, insira um código válido.');
            return;
        }

        try {
            // Este endpoint será criado no backend
            const response = await fetch(`../api/routes/reservas.php?codigo_retirada=${codigo.trim()}`);
            const result = await response.json();

            if (result.status === 'success') {
                resultSection.innerHTML = renderSuccess(result.data);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            resultSection.innerHTML = renderError(error.message || 'Não foi possível encontrar a reserva.');
        }
    };

    const confirmarEntrega = async (reservaId) => {
        resultSection.querySelector('button').disabled = true;
        resultSection.querySelector('button').innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Confirmando...`;

        try {
            const response = await fetch(`../api/routes/reservas.php`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ reserva_id: reservaId, status: 'Concluida' })
            });

            const result = await response.json();
            if (result.status === 'success') {
                resultSection.innerHTML = `<div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i>Entrega confirmada com sucesso!</div>`;
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            resultSection.innerHTML = renderError('Falha ao confirmar a entrega. Tente novamente.');
        }
    };

    const renderError = (message) => {
        return `<div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>${message}</div>`;
    }

    const renderSuccess = (reserva) => {
        if (reserva.status !== 'Aguardando Retirada') {
            return `<div class="alert alert-warning"><i class="bi bi-info-circle-fill me-2"></i>Esta reserva não está aguardando retirada. Status atual: <strong>${reserva.status}</strong></div>`;
        }

        return `
            <div class="card shadow-sm">
                <div class="card-header">Reserva Encontrada</div>
                <div class="card-body">
                    <p><strong>Cliente:</strong> ${reserva.cliente_nome}</p>
                    <p><strong>Produto:</strong> ${reserva.oferta_nome}</p>
                    <p><strong>Quantidade:</strong> ${reserva.quantidade_reservada} unidade(s)</p>
                    <div class="d-grid">
                        <button class="btn btn-success btn-lg" onclick="confirmarEntrega(${reserva.id})">Confirmar Entrega</button>
                    </div>
                </div>
            </div>
        `;
    }

    // Event Listeners
    validarBtn.addEventListener('click', () => buscarReserva(codigoInput.value));
    startScanBtn.addEventListener('click', startScanner);
    stopScanBtn.addEventListener('click', stopScanner);

    // Permite validar apertando Enter
    codigoInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            buscarReserva(codigoInput.value);
        }
    });

    // Expor a função para o HTML
    window.confirmarEntrega = confirmarEntrega;
});
