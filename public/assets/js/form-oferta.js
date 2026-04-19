/**
 * XepaViva - Lógica do Formulário de Cadastro/Edição de Oferta
 * Gerencia o preenchimento de dados em modo de edição e a submissão (simulada).
 */

document.addEventListener('DOMContentLoaded', () => {
    // Elementos do formulário
    const form = document.getElementById('formCadastrarOferta');
    if (!form) return; // Sai se não estiver na página certa

    const pageTitle = document.querySelector('title');
    const formTitle = document.getElementById('form-title');
    const submitButton = document.getElementById('btnPublicar');
    const previewFoto = document.getElementById('previewFoto');
    const inputFoto = document.getElementById('produtoFoto');
    const hiddenIdInput = document.querySelector('input[name="oferta_id"]');

    const feiranteIdLogado = 1; // Simulação do ID do feirante

    // Utilitários
    const params = new URLSearchParams(window.location.search);
    const ofertaId = params.get('id') ? parseInt(params.get('id')) : null;
    const modoEdicao = ofertaId !== null;

    /**
     * Preenche o formulário com os dados da oferta em modo de edição.
     */
    const preencherFormulario = async () => {
        if (!modoEdicao) {
            document.body.classList.remove('loading');
            return;
        }

        pageTitle.textContent = 'Editar Oferta | XepaViva';
        formTitle.textContent = 'Editar Oferta';
        submitButton.textContent = 'Salvar Alterações';
        
        const data = await fetchJsonData('data/ofertas.json');
        const oferta = data.ofertas.find(o => o.id === ofertaId && o.feirante_id === feiranteIdLogado);

        if (oferta) {
            hiddenIdInput.value = oferta.id;
            document.getElementById('produtoNome').value = oferta.nome;
            document.getElementById('produtoDescricao').value = oferta.descricao;
            document.getElementById('produtoPreco').value = oferta.preco;
            document.getElementById('produtoPeso').value = oferta.peso;
            document.getElementById('produtoCategoria').value = oferta.categoria;
            if (oferta.foto) {
                previewFoto.src = oferta.foto;
                previewFoto.style.display = 'block';
            }
        } else {
            console.error('Oferta não encontrada ou não pertence ao feirante.');
            showToast('Oferta não encontrada.', 'danger');
            // Redireciona para evitar formulário vazio em modo de edição inválido
            setTimeout(() => { window.location.href = 'minhas-ofertas.php'; }, 2000);
        }
        document.body.classList.remove('loading');
    };

    /**
     * Lida com a submissão do formulário.
     */
    const handleFormSubmit = (event) => {
        event.preventDefault();
        const validador = new ValidadorFormulario('#formCadastrarOferta');
        if (!validador.validarForm(form)) {
            showToast('Por favor, corrija os erros indicados.', 'danger');
            return;
        }

        const formData = {
            id: modoEdicao ? ofertaId : new Date().getTime(), // Simula novo ID
            feirante_id: feiranteIdLogado,
            nome: document.getElementById('produtoNome').value,
            descricao: document.getElementById('produtoDescricao').value,
            preco: document.getElementById('produtoPreco').value,
            peso: document.getElementById('produtoPeso').value,
            categoria: document.getElementById('produtoCategoria').value,
            foto: previewFoto.src, // Pega a foto do preview
            disponivel: true,
            reservas: modoEdicao ? 0 : 0 // Exemplo
        };

        // --- PONTO CHAVE DO SPRINT 0 ---
        console.log('--- Simulação de Envio para Backend ---');
        console.log('Dados capturados do formulário:', formData);
        // Em um cenário real, aqui seria a chamada para a API (fetch)
        // que salvaria os dados no servidor (e no ofertas.json).

        const originalText = submitButton.textContent;
        submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...`;
        submitButton.disabled = true;

        // Simula a chamada de API
        setTimeout(() => {
            const successMessage = modoEdicao ? 'Oferta atualizada com sucesso!' : 'Oferta publicada com sucesso!';
            showToast(successMessage, 'success');
            // Redireciona após a mensagem de sucesso
            setTimeout(() => { window.location.href = 'minhas-ofertas.php'; }, 1500);
        }, 1000);
    };

    /**
     * Lida com o preview da imagem.
     */
    const handleFotoPreview = () => {
        const file = inputFoto.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewFoto.src = e.target.result;
                previewFoto.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    };

    // Inicialização
    document.body.classList.add('loading');
    form.addEventListener('submit', handleFormSubmit);
    inputFoto.addEventListener('change', handleFotoPreview);
    preencherFormulario();
});
