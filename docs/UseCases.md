# 🎭 Casos de Uso (Use Cases) do XepaViva

**Status do Protótipo (Sprint 0):** ✅ Todos os fluxos principais descritos neste documento foram prototipados e são totalmente navegáveis na aplicação de frontend, utilizando dados simulados (`.json`).

---

## 1. Atores

*   **Feirante:** Indivíduo ou entidade que comercializa produtos em feiras livres. (Persona: Seu Benedito).
*   **Consumidor:** Indivíduo ou membro de organização que busca adquirir alimentos a um preço acessível. (Persona: Mariana).

*(Nota: A autenticação bem-sucedida é uma pré-condição geral para todos os casos de uso que envolvem os atores Feirante e Consumidor.)*

## 2. Diagrama de Casos de Uso

<div align="center">

![Diagrama de Casos de Uso](UseCases.png "Diagrama de Casos de Uso do XepaViva")

*Figura 1: Diagrama de Casos de Uso do XepaViva.*

</div>

## 3. Especificação dos Casos de Uso

**UC-01: Anunciar Kit Xepa**
*   **Status do Protótipo:** ✅ **Prototipado.** O formulário é funcional, com validação e submissão simulada (dados exibidos no console).
*   **Atores:** Feirante.
*   **Resumo:** Permite ao feirante criar uma oferta de produtos excedentes (xepa) que ficará visível para os consumidores na plataforma.
*   **Pré-condição:** O kit de alimentos a ser anunciado foi montado e ainda não possui um anúncio ativo.
*   **Fluxo Principal:**
    1.  O Feirante seleciona a opção "Cadastrar Oferta".
    2.  O sistema exibe um formulário para preenchimento dos detalhes do kit.
    3.  O Feirante preenche os campos do formulário (Nome, Preço, Peso, etc.).
    4.  O Feirante submete o formulário.
    5.  O sistema valida os dados.
    6.  Se o Feirante estiver offline, o sistema armazena o anúncio no `LocalStorage` (simulado no protótipo).
    7.  Se online, o sistema armazena o anúncio no banco de dados (simulado no protótipo).
    8.  O sistema exibe uma mensagem de sucesso.
*   **Pós-condição:** Um novo anúncio de kit xepa está disponível (online) ou pendente de sincronização (offline).
*   **Fluxos de Exceção:**
    *   **FE01.1 - Falha na Validação (Passo 5):** Se os dados forem inválidos, o sistema não prossegue e destaca os campos com erros.

**UC-02: Reservar Kit**
*   **Status do Protótipo:** ✅ **Parcialmente Prototipado.** O fluxo de busca e visualização está completo. A lógica de reserva foi simulada, mas agora precisa ser implementada para refletir o novo modelo de dados.
*   **Atores:** Consumidor.
*   **Resumo:** Permite que um consumidor encontre, reserve um kit de alimentos e receba um código único para retirada.
*   **Pré-condição:** Existe pelo menos uma oferta com `quantidade_disponivel` > 0.
*   **Fluxo Principal:**
    1.  O Consumidor navega pela lista de ofertas disponíveis (`buscar-ofertas.php`).
    2.  O Consumidor seleciona uma oferta de interesse para ver os detalhes.
    3.  O Consumidor aciona a opção "Reservar Kit".
    4.  O sistema valida a disponibilidade da oferta no banco de dados.
    5.  O sistema cria um novo registro na tabela `reservas` com o status inicial **`Pendente`**.
    6.  O sistema gera um **`codigo_retirada`** único (formato `XV-XXXX`) e o associa à reserva.
    7.  O sistema exibe o `codigo_retirada` e os detalhes da reserva para o Consumidor, com o status **`Aguardando Retirada`**.
    8.  O sistema decrementa a `quantidade_disponivel` na tabela `ofertas`.
    9.  O sistema notifica o Feirante sobre a nova reserva (mecanismo a ser definido: webhook, push, etc.).
*   **Pós-condição:** A reserva foi criada, a quantidade da oferta foi atualizada e o consumidor possui um código para a retirada.
*   **Fluxos de Exceção e Alternativos:**
    *   **FE02.1 - Oferta Indisponível (Passo 4):** Se, no momento da reserva, a `quantidade_disponivel` for zero, o sistema informa ao Consumidor que o item não está mais disponível e não prossegue.
    *   **FA02.1 - Cancelamento pelo Consumidor:** O Consumidor pode, a qualquer momento antes da retirada, cancelar a reserva. O status da reserva é alterado para **`Cancelada pelo Consumidor`** e a `quantidade_disponivel` na oferta é incrementada de volta.
    *   **FA02.2 - Cancelamento pelo Feirante:** O Feirante pode cancelar uma reserva. O status é alterado para **`Cancelada pelo Feirante`**, a `quantidade_disponivel` é incrementada e o Consumidor deve ser notificado.
    *   **FA02.3 - Conclusão da Retirada:** O Feirante, ao receber o `codigo_retirada`, marca a reserva como **`Concluida`**. A `data_retirada_efetiva` é registrada.
    *   **FA02.4 - Não Comparecimento:** Após um período definido, se o Consumidor não retirar o kit, o Feirante pode marcar a reserva como **`Nao Compareceu`**.

**UC-03: Gerenciar Ofertas**
*   **Status do Protótipo:** ✅ **Prototipado.** A página `minhas-ofertas.php` lista as ofertas do feirante, permitindo acesso para edição e remoção (simulada).
*   **Atores:** Feirante.
*   **Resumo:** Permite ao Feirante visualizar, editar ou remover os anúncios que ele publicou.
*   **Pré-condição:** O Feirante possui um ou mais anúncios.
*   **Fluxo Principal (Remover Oferta):**
    1.  O Feirante acessa a seção "Minhas Ofertas".
    2.  O sistema exibe a lista de todos os anúncios do Feirante.
    3.  O Feirante seleciona a opção "Remover" em uma oferta.
    4.  O sistema solicita uma confirmação.
    5.  O Feirante confirma a remoção.
    6.  O sistema remove o anúncio (simulado).
*   **Fluxos Alternativos:**
    *   **FA03.1 - Editar Oferta (inicia no Passo 3):** O Feirante seleciona "Editar". O sistema o direciona para o formulário (UC-01) pré-preenchido.

**UC-04: Visualizar Dashboard de Impacto**
*   **Status do Protótipo:** ✅ **Prototipado.** Os painéis exibem dados de impacto carregados de arquivos `.json`.
*   **Atores:** Feirante, Consumidor.
*   **Resumo:** Apresenta um painel visual com métricas sobre o impacto gerado.
*   **Fluxo Principal:**
    1.  O usuário acessa a seção "Painel".
    2.  O sistema coleta os dados simulados.
    3.  O sistema renderiza os gráficos com os dados.

**UC-05: Sincronizar Dados Offline**
*   **Status do Protótipo:** 🟡 **Parcialmente Prototipado.** A lógica de *salvar* dados offline (UC-01) está simulada no console. A sincronização automática ao reconectar (`online` event) aguarda o desenvolvimento do backend.
*   **Atores:** Sistema.
*   **Resumo:** Garante que as ações realizadas offline sejam enviadas ao servidor ao restabelecer a conexão.
*   **Pré-condição:** O dispositivo recuperou a conexão com a internet E existem ações pendentes no `LocalStorage`.
*   **Fluxo Principal:**
    1.  O sistema detecta o evento de reconexão (`online`).
    2.  O sistema verifica o `LocalStorage` por itens pendentes.
    3.  Para cada item, o sistema envia a requisição para a API.
    4.  Após a confirmação, o sistema remove o item da fila local.
