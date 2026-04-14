/**
 * Exibe uma notificação toast do Bootstrap.
 * 
 * @param {string} message A mensagem a ser exibida.
 * @param {string} type O tipo de toast (e.g., 'success', 'danger', 'info').
 */
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        console.error('Elemento #toastContainer não encontrado no DOM.');
        return;
    }

    const toastId = 'toast-' + new Date().getTime();
    const toastIcon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';

    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${toastIcon} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

    toastContainer.innerHTML += toastHTML;

    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        delay: 5000 // 5 segundos
    });

    toast.show();

    // Remove o elemento do DOM após o toast ser ocultado
    toastElement.addEventListener('hidden.bs.toast', function () {
        toastElement.remove();
    });
}
