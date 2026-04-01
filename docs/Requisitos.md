# 🍎 Projeto XepaViva - Documentação de Requisitos

* **Versão:** 2.0
* **Data:** 24 de março de 2026
* **Disciplina:** Projeto Extensionista Integrador
* **Localidade de Aplicação:** Cuiabá e Várzea Grande - MT

---

## 1. Visão Geral e Objetivo

O **XepaViva** é um Progressive Web App (PWA) focado na economia circular e na redução do desperdício de alimentos. O sistema conecta feirantes a consumidores para a comercialização de excedentes de produção (a "xepa") que, embora esteticamente imperfeitos, estão aptos para o consumo. O sistema atua como uma ponte entre o excedente de produção das feiras livres e o consumidor final, combatendo o desperdício de alimentos através de tecnologia resiliente e acessível.

* **ODS Vinculada:** 12 - Consumo e Produção Responsáveis.
* **Meta da ONU:** 12.3 - Reduzir o desperdício de alimentos per capita.
* **Objetivo SMART:** Implementar um PWA funcional que conecte 30 feirantes a 200 consumidores ativos, visando reduzir em 20% o descarte de alimentos nas bancas participantes até 29/05/2026.

---

## 2. Personas e Clientes

| Papel | Persona | Dores e Necessidades |
| :--- | :--- | :--- |
| **Principal (Ofertante)** | **Seu Benedito** | Feirante em Cuiabá; precisa reduzir perdas financeiras e o descarte físico de mercadorias maduras. Necessita de uma interface clara e de fácil uso sob luz solar intensa. |
| **Secundário (Comprador)** | **Mariana** | Consumidora consciente/ONG; Busca segurança alimentar e economia local; Necessidade de alimentos acessíveis; Apoio a causas sustentáveis; Dificuldade de acesso a doações. |

---

## 3. Requisitos do Sistema

### 3.1 Requisitos Funcionais (RF)

| ID | Nome | Descrição | Prioridade |
| :--- | :--- | :--- | :--- |
| **RF01** | Cadastrar Usuário | Registro de perfis (Feirante ou Consumidor) com validação de unicidade (CPF/CNPJ). | Essencial |
| **RF02** | Efetuar Login | Autenticação simulada de usuários com acesso direto aos perfis de feirante e consumidor. | Essencial |
| **RF03** | Anunciar Kit Xepa | Feirante cadastra itens com preço, peso e categoria de perecibilidade. | Essencial |
| **RF04** | Reservar Kit | Consumidor reserva itens disponíveis para retirada física. | Essencial |
| **RF05** | Dashboard de Impacto | Exibição de métricas de alimentos salvos (kg) e economia (R$) via Chart.js. | Importante |
| **RF06** | Sincronização Offline | Envio automático de dados salvos localmente ao detectar reconexão à internet. | Importante |
| **RF07** | Alternar Modo de Alto Contraste | O sistema deve fornecer um botão de fácil acesso nas telas do feirante para ativar/desativar um modo de "Alto Contraste", otimizado para visibilidade sob luz solar direta. | Essencial |
| **RF08** | Exibir Página "Como Funciona" | O sistema deve apresentar uma página informativa que descreva o processo de uso da aplicação para os perfis de Feirante e Consumidor. | Importante |

### 3.2 Requisitos Não Funcionais (RNF)

| ID | Descrição | Categoria |
| :--- | :--- | :--- |
| **RNF01** | Interface responsiva baseada em Bootstrap 5 (Mobile-First) para todas as páginas (e.g., `index`, `login`, `como-funciona`, etc.). | Usabilidade |
| **RNF02** | PWA com Service Worker para funcionamento resiliente em baixa conexão. | Disponibilidade |
| **RNF03** | Back-end em PHP 8 puro com Arquitetura Orientada a Objetos (OO). | Portabilidade |
| **RNF04** | Segurança de dados com Prepared Statements (PDO) e LocalStorage. | Segurança |
| **RNF05** | O modo de alto contraste deve sobrescrever os estilos padrão, utilizando um esquema de cores de máxima diferenciação (fundo `#FFFFFF`, textos e bordas `#000000`), garantindo a legibilidade. | Acessibilidade |
| **RNF06** | O estado do modo de alto contraste (ativado/desativado) deve persistir no dispositivo do usuário (`LocalStorage`). | Usabilidade |

---

## 4. Casos de Uso (Use Cases)

### 4.1. Atores

*   **Feirante:** Indivíduo ou entidade que comercializa produtos em feiras livres. Seu objetivo é maximizar as vendas e reduzir o desperdício de alimentos, transformando excedentes em lucro. (Persona: Seu Benedito).
*   **Consumidor:** Indivíduo ou membro de organização que busca adquirir alimentos de qualidade por um preço acessível, motivado por economia, sustentabilidade ou necessidade social. (Persona: Mariana).

*(Nota: A autenticação bem-sucedida é uma pré-condição geral para todos os casos de uso que envolvem os atores Feirante e Consumidor.)*

### 4.2. Diagrama de Casos de Uso

O diagrama a seguir oferece uma representação visual das interações entre os atores e as principais funcionalidades do sistema XepaViva. Ele serve como um mapa funcional, ilustrando o escopo e as fronteiras da aplicação de forma clara e objetiva.

<div align="center">

![Diagrama de Casos de Uso](UseCases.png "Diagrama de Casos de Uso do XepaViva")

*Figura 1: Diagrama de Casos de Uso do XepaViva.*

</div>

### 4.3. Especificação dos Casos de Uso

**UC-01: Anunciar Kit Xepa**
*   **Atores:** Feirante.
*   **Resumo:** Permite ao feirante criar uma oferta de produtos excedentes (xepa) que ficará visível para os consumidores na plataforma.
*   **Pré-condição:** O kit de alimentos a ser anunciado foi montado e ainda não possui um anúncio ativo na plataforma.
*   **Fluxo Principal:**
    1.  O Feirante seleciona a opção "Cadastrar Oferta" ou "Anunciar Xepa".
    2.  O sistema exibe um formulário para preenchimento dos detalhes do kit.
    3.  O Feirante preenche os campos do formulário (Nome, Preço, Peso, etc.).
    4.  O Feirante submete o formulário.
    5.  O sistema valida os dados.
    6.  Se o Feirante estiver offline, o sistema armazena o anúncio no `LocalStorage` com um status "Pendente de Sincronização" e informa ao usuário que a publicação será concluída ao reconectar. (ver UC-05)
    7.  Se online, o sistema armazena o anúncio no banco de dados com o status "Disponível".
    8.  O sistema exibe uma mensagem de sucesso.
*   **Pós-condição:** Um novo anúncio de kit xepa está disponível (online) ou pendente de sincronização (offline).
*   **Fluxos Alternativos:**
    *   **FA01.1 - Cancelar Anúncio:** A qualquer momento antes de submeter (Passo 4), o Feirante pode selecionar a opção "Cancelar". O sistema descarta os dados e retorna à tela anterior.
*   **Fluxos de Exceção:**
    *   **FE01.1 - Falha na Validação (Passo 5):** Se os dados forem inválidos (e.g., preço negativo, nome em branco), o sistema não prossegue, exibe o formulário novamente destacando os campos com erros e suas respectivas mensagens de correção.
    *   **FE01.2 - Falha de Comunicação (Passo 7):** Se o Feirante estiver online, mas a comunicação com o servidor falhar, o sistema deve tratar a situação como um cenário offline: armazena os dados no `LocalStorage` e informa ao Feirante sobre a falha e a ação de contingência.

**UC-02: Reservar Kit**
*   **Atores:** Consumidor.
*   **Resumo:** Permite que um consumidor encontre e reserve um kit de alimentos para retirada futura.
*   **Pré-condição:** Existe pelo menos um kit com o status "Disponível" na plataforma.
*   **Fluxo Principal:**
    1.  O Consumidor navega pela lista de kits disponíveis.
    2.  O Consumidor seleciona um kit de interesse para ver os detalhes.
    3.  O Consumidor aciona a opção "Reservar Kit".
    4.  O sistema realiza uma verificação final de disponibilidade.
    5.  O sistema atualiza o status do kit para "Reservado", associando-o ao ID do Consumidor.
    6.  O sistema gera um comprovante de reserva (e.g., um código de retirada) para o Consumidor.
    7.  O sistema notifica o Feirante sobre a nova reserva.
*   **Pós-condição:** O kit selecionado está associado ao Consumidor, e o Feirante é notificado da reserva.
*   **Fluxos Alternativos:**
    *   **FA02.1 - Desistir da Reserva:** Após ver os detalhes (Passo 2), o Consumidor pode optar por não reservar e voltar à lista de kits.
*   **Fluxos de Exceção:**
    *   **FE02.1 - Kit Indisponível (Passo 4):** Se, no momento da confirmação, outro consumidor já tiver reservado o kit, o sistema informa ao Consumidor que o item não está mais disponível, atualiza a interface e sugere outros kits semelhantes.
    *   **FE02.2 - Falha na Reserva (Passo 5):** Se ocorrer um erro no servidor ao tentar atualizar o status do kit, o sistema informa ao Consumidor que não foi possível concluir a reserva no momento e sugere tentar novamente. O status do kit não deve ser alterado.

**UC-03: Gerenciar Ofertas**
*   **Atores:** Feirante.
*   **Resumo:** Permite ao Feirante visualizar, editar ou remover os anúncios que ele publicou.
*   **Pré-condição:** O Feirante possui um ou mais anúncios (kits) com status "Disponível" ou "Reservado".
*   **Fluxo Principal (Remover Oferta):**
    1.  O Feirante acessa a seção "Minhas Ofertas".
    2.  O sistema exibe a lista de todos os anúncios do Feirante.
    3.  O Feirante seleciona a opção "Remover" em uma oferta com status "Disponível".
    4.  O sistema solicita uma confirmação para evitar remoção acidental.
    5.  O Feirante confirma a remoção.
    6.  O sistema remove o anúncio do banco de dados.
*   **Pós-condição:** A oferta não está mais visível para os consumidores.
*   **Fluxos Alternativos:**
    *   **FA03.1 - Editar Oferta (inicia no Passo 3):** O Feirante seleciona "Editar". O sistema o direciona para o formulário de anúncio (UC-01) pré-preenchido com os dados da oferta.
    *   **FA03.2 - Cancelar Remoção (Passo 5):** O Feirante decide não remover a oferta e cancela a operação. O sistema retorna à lista de ofertas.
*   **Fluxos de Exceção:**
    *   **FE03.1 - Tentar Remover Oferta Reservada (Passo 3):** Se o Feirante tentar remover uma oferta com status "Reservado", o sistema exibe uma mensagem informando que não é possível remover uma oferta já reservada e sugere entrar em contato com o consumidor se necessário.

**UC-04: Visualizar Dashboard de Impacto**
*   **Atores:** Feirante, Consumidor.
*   **Resumo:** Apresenta um painel visual com métricas sobre o impacto gerado pelo uso do aplicativo.
*   **Pré-condição:** Nenhuma. O dashboard pode ser visualizado a qualquer momento.
*   **Fluxo Principal:**
    1.  O usuário acessa a seção "Painel" ou "Dashboard".
    2.  O sistema coleta os dados de transações concluídas associadas ao usuário.
    3.  O sistema renderiza os gráficos com os dados coletados (kg de alimentos, R$ economizados).
*   **Pós-condição:** O usuário visualiza seus dados de impacto.
*   **Fluxos Alternativos:**
    *   **FA04.1 - Usuário Sem Transações:** Se o usuário ainda não tiver transações (Passo 2), o sistema exibe o dashboard com os valores zerados e uma mensagem motivacional para realizar a primeira venda ou reserva.

**UC-05: Sincronizar Dados Offline**
*   **Atores:** Sistema.
*   **Resumo:** Garante que as ações realizadas offline sejam enviadas ao servidor ao restabelecer a conexão.
*   **Pré-condição:** O dispositivo recuperou a conexão com a internet E existem ações pendentes no `LocalStorage`.
*   **Fluxo Principal:**
    1.  O sistema detecta o evento de reconexão (`online`).
    2.  O sistema verifica o `LocalStorage` por itens marcados como "Pendente de Sincronização".
    3.  Para cada item, o sistema envia a requisição correspondente para a API do backend.
    4.  Após a confirmação do servidor (HTTP 200/201), o sistema remove o item do `LocalStorage` ou atualiza seu status para "Sincronizado".
*   **Pós-condição:** Os dados do cliente e do servidor estão consistentes.
*   **Fluxos de Exceção:**
    *   **FE05.1 - Falha na Sincronização (Passo 4):** Se o servidor retornar um erro para uma requisição (e.g., HTTP 4xx/5xx), o item não é removido do `LocalStorage`. O sistema pode tentar a sincronização novamente em um momento posterior (e.g., usando uma estratégia de backoff exponencial).
    *   **FE05.2 - Dados Conflitantes (Passo 4):** Se o servidor detectar um conflito (e.g., tentativa de editar um item que foi removido), a API deve retornar um erro específico (e.g., HTTP 409 Conflict). O sistema no cliente deve então marcar o item local como inválido e notificar o usuário, se necessário.

---

## 5. User Experience (UX) e Padrão Visual

### 5.1 Paleta de Cores
A escolha cromática visa remeter ao frescor dos alimentos e à urgência do combate ao desperdício.

*   **Primária (Verde Xepa)**: #2ECC71 - Simboliza frescor, sustentabilidade e "item liberado".
*   **Secundária (Laranja Cenoura)**: #E67E22 - Cor de destaque para alertas, botões de ação e energia.
*   **Fundo (Cinza Claro)**: #F8F9FA - Garante conforto visual na leitura.
*   **Contraste (Preto Texto)**: #2C3E50 - Tipografia nítida para leitura rápida.

### 5.2 Tipografia e Interface
*   **Fonte**: Sans-serif (Roboto ou Segoe UI) para legibilidade em telas móveis.
*   **Componentes**: Botões com tamanho mínimo de **44px** para facilitar o toque por feirantes em movimento.
*   **Modo de Alto Contraste**: Interface com fundo branco puro (`#FFFFFF`), textos e ícones em preto (`#000000`), e bordas pretas espessas (2px) em todos os elementos interativos (botões, inputs, cards). O acionamento será feito por um botão no cabeçalho, identificado por um ícone (`bi-sun`), e o estado será salvo no `LocalStorage` para persistir entre as sessões.

---

## 6. Arquitetura da Aplicação

A aplicação segue o padrão de **Arquitetura em Camadas** com foco em desacoplamento e resiliência offline.

*   **Camada de Apresentação (Frontend)**: Construída com HTML5, CSS3 e **Bootstrap 5**. Utiliza JavaScript Vanilla para manipulação do DOM e **Chart.js** para visualização de dados.
*   **Camada de Serviços PWA**: Composta pelo `manifest.json` e pelo **Service Worker**. Implementa a estratégia de cache *Stale-While-Revalidate* para ativos estáticos e *Network-First* para dados críticos.
*   **Camada de Aplicação (*Backend*)**: API RESTful desenvolvida em **PHP 8.x** utilizando Programação Orientada a Objetos (POO). Não utiliza frameworks pesados para manter a portabilidade.
*   **Camada de Persistência (Dados)**: Banco de dados relacional **MariaDB** para armazenamento centralizado e **LocalStorage** para persistência temporária no dispositivo do usuário durante estados offline.

---

## 7. Segurança e Dados

*   **Proteção**: Uso de `password_hash` para senhas e *Prepared Statements* (PDO) contra SQL Injection.
*   **Privacidade**: Dados de geolocalização são utilizados apenas para o mapeamento da oferta, não sendo armazenados históricos de rastreio dos usuários.

---

## 8. Cronograma e Riscos

*   **Execução:** 09/03/2026 a 29/05/2026.
*   **Ponto de Atenção:** Baixa conectividade 4G nas feiras de Várzea Grande.
*   **Mitigação:** Sincronização assíncrona baseada em UUIDs únicos gerados localmente.

---

*Documentação gerada como artefato do Projeto Extensionista Integrador.*
