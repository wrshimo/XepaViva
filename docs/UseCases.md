# 🎭 Casos de Uso (Use Cases) do XepaViva

*Última Atualização: 07 de junho de 2026*

**Resumo:** Este documento detalha os fluxos de negócio do sistema XepaViva. As especificações aqui contidas servem como guia para o desenvolvimento e a validação das funcionalidades, com foco na consistência dos dados e nas regras de negócio, tratando a autenticação como um pré-requisito implícito para acesso aos painéis de Feirante e Consumidor.

---

## 1. Atores

*   **Feirante:** Persona de negócio que oferta produtos na plataforma.
*   **Consumidor:** Persona de negócio que reserva produtos na plataforma.
*   **Sistema:** Entidade que executa processos automáticos.

---

## 2. Especificação dos Casos de Uso

### UC-01: Anunciar Kit Xepa

*   **Status:** ✅ **Concluído e Integrado**
*   **Atores:** Feirante
*   **Resumo:** Descreve o processo de criação de uma nova oferta de kit de alimentos na plataforma.
*   **Pré-condição:** O produto a ser anunciado não possui um registro de oferta ativo.
*   **Fluxo Principal:**
    1.  O Feirante inicia o processo de criação de uma nova oferta.
    2.  O Sistema apresenta o formulário de cadastro de oferta, contendo os campos: `nome`, `descricao`, `foto`, `preco`, `peso`, `quantidade_inicial` e `categoria`.
    3.  O Feirante preenche todos os campos obrigatórios.
    4.  O Feirante confirma a submissão do formulário.
    5.  O Sistema valida se o campo `nome` não é duplicado para o mesmo feirante.
    6.  O Sistema valida se os campos `preco`, `peso` e `quantidade_inicial` são valores numéricos positivos.
    7.  O Sistema cria um novo registro de `oferta` no banco de dados, associado ao ID do Feirante.
    8.  O campo `quantidade_disponivel` é inicializado com o mesmo valor de `quantidade_inicial`.
    9.  O campo `disponivel` é definido como `TRUE`.
    10. O Sistema exibe uma mensagem de sucesso, confirmando que a oferta foi criada.
*   **Pós-condição:** Uma nova oferta está registrada e disponível para consulta e reserva por parte dos Consumidores.
*   **Fluxos de Exceção:**
    *   **FE01.1 - Nome de oferta duplicado (Passo 5):** Se já existir uma oferta com o mesmo nome para aquele feirante, o Sistema interrompe o processo e informa ao Feirante que o nome já está em uso, sugerindo a edição da oferta existente (UC-03).
    *   **FE01.2 - Dados numéricos inválidos (Passo 6):** Se os valores para preço, peso ou quantidade não forem números positivos, o Sistema bloqueia a submissão, destaca os campos inválidos e informa ao Feirante sobre a necessidade de correção.

### UC-02: Reservar Kit

*   **Status:** ⏳ **Em Andamento**
*   **Atores:** Consumidor
*   **Resumo:** Detalha o processo de reserva de um kit de alimentos por um consumidor.
*   **Pré-condição:** A oferta-alvo da reserva possui o campo `disponivel` como `TRUE` e `quantidade_disponivel` maior que zero.
*   **Fluxo Principal:**
    1. O Consumidor seleciona uma oferta e solicita a reserva de uma ou mais unidades.
    2. O Sistema verifica em tempo real a `quantidade_disponivel` da oferta.
    3. O Sistema valida se a quantidade solicitada pelo Consumidor é menor ou igual à `quantidade_disponivel`.
    4. O Sistema cria um novo registro na tabela `reservas`, associando o ID do Consumidor e o ID da Oferta.
    5. O status da nova reserva é definido como `Pendente`.
    6. O Sistema gera um `codigo_retirada` único (formato `XV-XXXX`) e o armazena no registro da reserva.
    7. O Sistema decrementa o valor de `quantidade_disponivel` na tabela `ofertas`, subtraindo a quantidade reservada.
    8. Se a `quantidade_disponivel` da oferta chegar a zero, o Sistema atualiza o campo `disponivel` da oferta para `FALSE`.
    9. O Sistema informa ao Consumidor que a reserva foi confirmada e exibe o `codigo_retirada`.
*   **Pós-condição:** Uma reserva é criada, a disponibilidade da oferta é atualizada e o consumidor tem as informações para a retirada.
*   **Fluxos de Exceção:**
    *   **FE02.1 - Estoque insuficiente (Passo 3):** Se a quantidade solicitada for maior que a disponível, o Sistema não cria a reserva e informa ao Consumidor qual a quantidade máxima que ele pode reservar.

### UC-03: Gerenciar Ofertas

*   **Status:** ✅ **Concluído e Integrado**
*   **Atores:** Feirante
*   **Resumo:** Descreve a visualização e alteração de ofertas existentes.
*   **Pré-condição:** N/A
*   **Fluxo Principal (Edição):**
    1. O Feirante solicita a visualização de suas ofertas.
    2. O Sistema exibe a lista completa de ofertas cadastradas pelo Feirante.
    3. O Feirante seleciona a opção para editar uma oferta específica.
    4. O Sistema apresenta o mesmo formulário do UC-01, pré-preenchido com os dados da oferta selecionada.
    5. O Feirante altera os dados desejados e submete o formulário.
    6. O Sistema aplica as mesmas validações do UC-01 (exceto a de nome duplicado, se o nome não for alterado).
    7. O Sistema atualiza o registro da oferta no banco de dados com os novos dados.
    8. O Sistema registra a data da alteração no campo `data_modificacao`.
    9. O Sistema informa ao Feirante que a oferta foi atualizada com sucesso.
*   **Pós-condição:** Os dados da oferta são atualizados no sistema.
*   **Fluxos Alternativos:**
    *   **FA03.1 - Remoção de Oferta:** O Feirante seleciona a opção "Remover" em uma oferta. O Sistema verifica se existem reservas com status `Pendente` ou `Aguardando Retirada` para esta oferta. Se não houver, a oferta é removida. Se houver, a ação é bloqueada (FE03.1).
*   **Fluxos de Exceção:**
    *   **FE03.1 - Remoção de oferta com reservas ativas:** Se o Feirante tentar remover uma oferta que possua reservas ativas, o Sistema impede a remoção e exibe uma mensagem informando que é preciso primeiro cancelar as reservas pendentes.

### UC-04: Visualizar Dashboard de Impacto

*   **Status:** 📋 **Planejado**
*   **Atores:** Feirante, Consumidor
*   **Resumo:** Apresenta métricas agregadas sobre o impacto positivo gerado pela plataforma.

### UC-05: Sincronizar Dados Offline

*   **Status:** 📋 **Planejado**
*   **Atores:** Sistema
*   **Resumo:** Garante que dados criados offline (ex: novas ofertas) sejam enviados ao servidor quando a conexão é restabelecida.

### UC-06: Visualizar Painel de Controle do Feirante

*   **Status:** ✅ **Concluído e Integrado**
*   **Atores:** Feirante
*   **Resumo:** Apresenta uma visão consolidada e em tempo real dos indicadores e atividades relevantes para o Feirante.
*   **Pré-condição:** N/A
*   **Fluxo Principal:**
    1. O Feirante acessa seu painel de controle.
    2. O Sistema executa as seguintes consultas, em paralelo ou de forma otimizada:
        a. Contar o número total de ofertas ativas (`disponivel` = TRUE) para o feirante.
        b. Contar o número total de reservas com status `Pendente` ou `Aguardando Retirada`.
        c. Somar o `preco` de todas as reservas com status `Concluida`.
        d. Buscar as 5 ofertas mais recentes (ordenadas por `data_criacao` descendente).
        e. Buscar as 5 reservas mais recentes (ordenadas por `data_reserva` descendente).
    3. O Sistema exibe os resultados consolidados na interface do Feirante, preenchendo os seguintes componentes:
        *   **Métricas Principais:** Os totais calculados nas etapas 2a, 2b e 2c.
        *   **Lista de Ofertas Recentes:** Os dados da etapa 2d.
        *   **Lista de Reservas Recentes:** Os dados da etapa 2e.
*   **Pós-condição:** O Feirante tem uma visão clara e atualizada de seu desempenho e atividades recentes na plataforma.
