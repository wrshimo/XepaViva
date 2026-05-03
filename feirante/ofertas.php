<?php
// feirante/ofertas.php

session_start();

// Simulação de autenticação
$_SESSION['usuario_id'] = 1;
$_SESSION['usuario_tipo'] = 'Feirante';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Feirante') {
    // header("Location: ../login.php");
    // exit;
}

$feirante_id = $_SESSION['usuario_id'];
$titulo_pagina = "Minhas Ofertas";

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?> - XepaViva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body>

    <header>
        <!-- Menu de navegação aqui -->
    </header>

    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?php echo $titulo_pagina; ?></h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalOferta">+ Nova Oferta</button>
        </div>

        <!-- Tabela de Ofertas -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Disponível (Qtd)</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tabela-ofertas">
                    <!-- Populado via JavaScript -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal de Oferta -->
    <div class="modal fade" id="modalOferta" tabindex="-1" aria-labelledby="modalOfertaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formOferta">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalOfertaLabel">Adicionar Nova Oferta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="oferta-id">
                        <input type="hidden" id="feirante-id" value="<?php echo $feirante_id; ?>">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control" id="nome" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="preco" class="form-label">Preço (R$)</label>
                                <input type="number" class="form-control" id="preco" step="0.01" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantidade_inicial" class="form-label">Quantidade Inicial</label>
                                <input type="number" class="form-control" id="quantidade_inicial" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" rows="3"></textarea>
                        </div>
                        <div class="row">
                             <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <input type="text" class="form-control" id="categoria" placeholder="Ex: Frutas, Legumes">
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="foto" class="form-label">URL da Foto</label>
                                <input type="text" class="form-control" id="foto" placeholder="https://exemplo.com/imagem.jpg">
                            </div>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="disponivel" checked>
                            <label class="form-check-label" for="disponivel">Disponível para venda</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const feiranteId = <?php echo $feirante_id; ?>;
            const tabelaCorpo = document.getElementById('tabela-ofertas');
            const modalElement = document.getElementById('modalOferta');
            const modal = new bootstrap.Modal(modalElement);
            const formOferta = document.getElementById('formOferta');
            const modalLabel = document.getElementById('modalOfertaLabel');

            const API_URL = '../api/routes/ofertas.php';

            const carregarOfertas = async () => {
                tabelaCorpo.innerHTML = '<tr><td colspan="5" class="text-center">Carregando...</td></tr>';
                try {
                    const response = await fetch(API_URL);
                    if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
                    const data = await response.json();

                    const ofertasDoFeirante = data.registros ? data.registros.filter(o => o.feirante_id == feiranteId) : [];
                    tabelaCorpo.innerHTML = '';

                    if (ofertasDoFeirante.length > 0) {
                        ofertasDoFeirante.forEach(oferta => {
                            const tr = document.createElement('tr');
                            tr.id = `oferta-${oferta.id}`;
                            tr.innerHTML = `
                                <td>${oferta.nome}</td>
                                <td>R$ ${parseFloat(oferta.preco).toFixed(2).replace('.', ',')}</td>
                                <td>${oferta.quantidade_disponivel} / ${oferta.quantidade_inicial}</td>
                                <td>${oferta.disponivel ? '<span class="badge bg-success">Ativa</span>' : '<span class="badge bg-danger">Inativa</span>'}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="abrirModalParaEditar(${oferta.id})">Editar</button>
                                    <button class="btn btn-sm btn-danger" onclick="deletarOferta(${oferta.id})">Excluir</button>
                                </td>
                            `;
                            tabelaCorpo.appendChild(tr);
                        });
                    } else {
                        tabelaCorpo.innerHTML = '<tr><td colspan="5" class="text-center">Você ainda não cadastrou nenhuma oferta.</td></tr>';
                    }
                } catch (error) {
                    console.error('Falha ao carregar ofertas:', error);
                    tabelaCorpo.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Erro ao carregar ofertas.</td></tr>`;
                }
            };

            const resetarModal = () => {
                modalLabel.textContent = 'Adicionar Nova Oferta';
                formOferta.reset();
                document.getElementById('oferta-id').value = '';
                document.getElementById('disponivel').checked = true;
            };

            modalElement.addEventListener('hidden.bs.modal', resetarModal);

            window.abrirModalParaEditar = async (id) => {
                resetarModal();
                modalLabel.textContent = 'Editar Oferta';

                try {
                    const response = await fetch(`${API_URL}?id=${id}`);
                    if (!response.ok) throw new Error('Oferta não encontrada.');
                    const oferta = await response.json();

                    document.getElementById('oferta-id').value = oferta.id;
                    document.getElementById('nome').value = oferta.nome;
                    document.getElementById('preco').value = oferta.preco;
                    document.getElementById('quantidade_inicial').value = oferta.quantidade_inicial;
                    document.getElementById('descricao').value = oferta.descricao;
                    document.getElementById('categoria').value = oferta.categoria;
                    document.getElementById('foto').value = oferta.foto;
                    document.getElementById('disponivel').checked = oferta.disponivel;
                    
                    modal.show();
                } catch (error) {
                    alert(error.message);
                }
            };

            formOferta.addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = document.getElementById('oferta-id').value;
                const isUpdate = id !== '';

                // O 'quantidade_disponivel' não está no form, então definimos com base na lógica de negócio
                const quantidadeInicial = parseInt(document.getElementById('quantidade_inicial').value, 10);
                let quantidadeDisponivel = quantidadeInicial; // Valor padrão para criação

                if (isUpdate) {
                    // Para atualização, precisaríamos de um campo específico ou buscar o valor atual
                    // Por simplicidade, vamos manter a lógica no backend que não atualiza a qtd_disponivel no PUT de propósito
                }

                const dadosOferta = {
                    feirante_id: feiranteId,
                    nome: document.getElementById('nome').value,
                    preco: parseFloat(document.getElementById('preco').value),
                    quantidade_inicial: quantidadeInicial,
                    quantidade_disponivel: quantidadeDisponivel, // O backend irá ajustar isso melhor na atualização
                    descricao: document.getElementById('descricao').value,
                    categoria: document.getElementById('categoria').value,
                    foto: document.getElementById('foto').value,
                    disponivel: document.getElementById('disponivel').checked,
                };

                const url = isUpdate ? `${API_URL}?id=${id}` : API_URL;
                const method = isUpdate ? 'PUT' : 'POST';

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(dadosOferta)
                    });

                    const resultado = await response.json();
                    if (!response.ok)  throw new Error(resultado.mensagem || 'Ocorreu um erro.');

                    alert(resultado.mensagem);
                    modal.hide();
                    carregarOfertas(); // Recarrega a lista

                } catch (error) {
                    alert(`Erro ao salvar: ${error.message}`);
                }
            });

            window.deletarOferta = async (id) => {
                if (!confirm('Tem certeza que deseja excluir esta oferta?')) return;

                try {
                    const response = await fetch(`${API_URL}?id=${id}`, { method: 'DELETE' });
                    const resultado = await response.json();
                    if (!response.ok) throw new Error(resultado.mensagem || 'Erro ao excluir.');
                    
                    alert(resultado.mensagem);
                    carregarOfertas(); // Recarrega a lista

                } catch (error) {
                    alert(`Erro: ${error.message}`);
                }
            };

            carregarOfertas();
        });
    </script>

</body>
</html>
