document.addEventListener('DOMContentLoaded', () => {

    const loginFeiranteBtn = document.getElementById('login-feirante');
    const loginConsumidorBtn = document.getElementById('login-consumidor');

    if (loginFeiranteBtn) {
        loginFeiranteBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Impede a navegação direta do link

            // Mock do objeto de usuário para o Feirante
            const feiranteUser = {
                id: 1, // ID Fixo para a simulação
                nome: 'Seu Benedito',
                tipo: 'feirante'
            };

            // Salva no localStorage
            localStorage.setItem('xepa-user', JSON.stringify(feiranteUser));

            // Redireciona para o painel do feirante
            window.location.href = 'feirante.php';
        });
    }

    if (loginConsumidorBtn) {
        loginConsumidorBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Impede a navegação direta do link

            // Mock do objeto de usuário para o Consumidor
            const consumidorUser = {
                id: 2, // ID Fixo para a simulação
                nome: 'Mariana',
                tipo: 'consumidor'
            };

            // Salva no localStorage
            localStorage.setItem('xepa-user', JSON.stringify(consumidorUser));

            // Redireciona para o painel do consumidor
            window.location.href = 'consumidor.php';
        });
    }
});
