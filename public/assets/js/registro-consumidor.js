document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registro-form');
    const feedbackMessage = document.getElementById('feedback-message');

    form.addEventListener('submit', async function (event) {
        // Impede o envio tradicional do formulário
        event.preventDefault();

        const nome = document.getElementById('nome').value.trim();
        const email = document.getElementById('email').value.trim();
        const telefone = document.getElementById('telefone').value.trim();
        const senha = document.getElementById('senha').value;
        const confirmarSenha = document.getElementById('confirmar_senha').value;

        // Limpa mensagens de feedback anteriores
        feedbackMessage.innerHTML = '';
        feedbackMessage.className = '';

        // Validação no lado do cliente
        if (!nome || !email || !telefone || !senha || !confirmarSenha) {
            displayMessage('Por favor, preencha todos os campos.', 'danger');
            return;
        }

        if (senha !== confirmarSenha) {
            displayMessage('As senhas não coincidem.', 'danger');
            return;
        }

        // Prepara os dados para enviar à API
        const dadosUsuario = {
            nome: nome,
            email: email,
            telefone: telefone,
            senha: senha,
            tipo: 'Consumidor' // Define o tipo de usuário explicitamente
        };

        try {
            const response = await fetch('api/routes/usuarios.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dadosUsuario),
            });

            const result = await response.json();

            if (response.ok && result.status === 'success') {
                displayMessage(result.message + ' Você já pode fazer login.', 'success');
                form.reset(); // Limpa o formulário após o sucesso
            } else {
                // Exibe a mensagem de erro vinda da API
                displayMessage(result.message || 'Ocorreu um erro no cadastro.', 'danger');
            }
        } catch (error) {
            // Trata erros de rede ou de JSON inválido
            console.error('Erro ao enviar o formulário:', error);
            displayMessage('Não foi possível conectar ao servidor. Tente novamente mais tarde.', 'danger');
        }
    });

    function displayMessage(message, type) {
        feedbackMessage.className = `alert alert-${type} mt-3`;
        feedbackMessage.textContent = message;
    }
});
