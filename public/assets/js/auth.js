document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const errorContainer = document.getElementById('loginError');

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            // 1. Impede o envio tradicional do formulário que recarrega a página.
            e.preventDefault();
            
            // Limpa erros anteriores.
            errorContainer.textContent = '';
            errorContainer.style.display = 'none';

            // 2. Coleta os dados do formulário.
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;

            try {
                // 3. Envia os dados para a API de autenticação usando fetch.
                const response = await fetch('./api/routes/auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, senha })
                });

                const result = await response.json();

                // 4. Processa a resposta da API.
                if (response.ok && result.status === 'success') {
                    // SUCESSO!
                    // 5. Salva os dados do usuário no localStorage.
                    localStorage.setItem('xepa-user', JSON.stringify(result.user));

                    // 6. Redireciona o navegador para a URL fornecida pela API.
                    window.location.href = result.redirect_url;
                } else {
                    // ERRO!
                    // 7. Exibe a mensagem de erro retornada pela API.
                    throw new Error(result.message || 'Erro desconhecido.');
                }
            } catch (error) {
                errorContainer.textContent = error.message;
                errorContainer.style.display = 'block';
            }
        });
    }
});
