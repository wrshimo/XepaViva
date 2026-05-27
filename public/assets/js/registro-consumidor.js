document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registro-form');
    const feedback = document.getElementById('feedback-message');
    const senha = document.getElementById('senha');
    const confirmarSenha = document.getElementById('confirmar_senha');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Limpa mensagens anteriores
        feedback.innerHTML = '';
        feedback.className = '';

        // Validação de senha
        if (senha.value !== confirmarSenha.value) {
            displayMessage('As senhas não coincidem.', 'danger');
            return;
        }

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Adiciona o tipo de usuário manualmente para o cadastro de consumidor
        data.tipo = 'Consumidor'; 

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.status === 'success') {
                displayMessage(result.message, 'success');
                form.reset();
                // Redireciona para o login após 2 segundos
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
            } else {
                displayMessage(result.message || 'Ocorreu um erro no cadastro.', 'danger');
            }
        } catch (error) {
            console.error('Erro ao enviar o formulário:', error);
            displayMessage('Não foi possível conectar ao servidor. Tente novamente mais tarde.', 'danger');
        }
    });

    function displayMessage(message, type) {
        feedback.className = `alert alert-${type}`;
        feedback.textContent = message;
    }
});
