# 🍎 Projeto XepaViva - Documentação de Requisitos

* **Versão:** 2.2
* **Data:** 16 de abril de 2026
* **Disciplina:** Projeto Extensionista Integrador
* **Localidade de Aplicação:** Cuiabá e Várzea Grande - MT

---

## 1. Visão Geral e Objetivo

O **XepaViva** é um Progressive Web App (PWA) focado na economia circular e na redução do desperdício de alimentos. O sistema conecta feirantes a consumidores para a comercialização de excedentes de produção (a "xepa") que, embora esteticamente imperfeitos, estão aptos para o consumo.

* **ODS Vinculada:** 12 - Consumo e Produção Responsáveis.
* **Meta da ONU:** 12.3 - Reduzir o desperdício de alimentos per capita.
* **Objetivo SMART:** Implementar um PWA funcional que conecte 30 feirantes a 200 consumidores ativos, visando reduzir em 20% o descarte de alimentos nas bancas participantes até 29/05/2026.

---

## 2. Personas e Clientes

| Papel | Persona | Dores e Necessidades |
| :--- | :--- | :--- |
| **Principal (Ofertante)** | **Seu Benedito** | Feirante em Cuiabá; precisa reduzir perdas financeiras e o descarte físico de mercadorias maduras. Necessita de uma interface clara e de fácil uso sob luz solar intensa. |
| **Secundário (Comprador)** | **Mariana** | Consumidora consciente/ONG; Busca segurança alimentar e economia local; Necessidade de alimentos acessíveis; Apoio a causas sustentáveis. |

---

## 3. Requisitos do Sistema

### 3.1 Requisitos Funcionais (RF)

| ID | Nome | Descrição | Prioridade |
| :--- | :--- | :--- | :--- |
| **RF01** | Cadastrar Usuário | Registro de perfis (Feirante ou Consumidor) com validação de unicidade (CPF/CNPJ). | Essencial |
| **RF02** | Efetuar Login | Autenticação de usuários com acesso aos perfis de feirante e consumidor. | Essencial |
| **RF03** | Anunciar Kit Xepa | Feirante cadastra itens com preço, peso e categoria de perecibilidade. | Essencial |
| **RF04** | Reservar Kit | Consumidor reserva itens disponíveis para retirada física. | Essencial |
| **RF05** | Dashboard de Impacto | Exibição de métricas de alimentos salvos (kg) e economia (R$) via Chart.js. | Importante |
| **RF06** | Sincronização Offline | Envio automático de dados salvos localmente ao detectar reconexão à internet. | Importante |
| **RF07** | Alternar Modo de Alto Contraste | O sistema deve fornecer um botão de fácil acesso para ativar/desativar um modo de "Alto Contraste". | Essencial |
| **RF08** | Exibir Página "Como Funciona" | O sistema deve apresentar uma página informativa que descreva o processo de uso da aplicação. | Importante |

### 3.2 Requisitos Não Funcionais (RNF)

| ID | Descrição | Categoria |
| :--- | :--- | :--- |
| **RNF01** | Interface responsiva baseada em Bootstrap 5 (Mobile-First). | Usabilidade |
| **RNF02** | PWA com Service Worker para funcionamento resiliente em baixa conexão. | Disponibilidade |
| **RNF03** | Back-end em PHP 8 puro com Arquitetura Orientada a Objetos (OO). | Portabilidade |
| **RNF04** | Segurança de dados com Prepared Statements (PDO) e LocalStorage. | Segurança |
| **RNF05** | O modo de alto contraste deve usar um esquema de cores de máxima diferenciação (fundo `#FFFFFF`, textos `#000000`). | Acessibilidade |
| **RNF06** | O estado do modo de alto contraste deve persistir no dispositivo do usuário (`LocalStorage`). | Usabilidade |

---

## 4. Casos de Uso (Use Cases)

Para a especificação detalhada dos fluxos de interação, consulte: ➡️ **[Documento de Casos de Uso (UseCases.md)](UseCases.md)**

---

## 4.1. Ciclo de Vida da Reserva

A entidade `Reserva` é central para o fluxo de negócio do XepaViva. Seu ciclo de vida, desde a criação até a conclusão ou cancelamento, é governado por uma máquina de estados finitos. A compreensão deste fluxo é crucial para a correta implementação das regras de negócio.

Para a especificação detalhada dos estados e das transições, consulte: ➡️ **[Documento de Ciclo de Vida da Reserva (States.md)](States.md)**

---

## 5. User Experience (UX) e Padrão Visual

### 5.1 Paleta de Cores
*   **Primária (Verde Xepa)**: #2ECC71
*   **Secundária (Laranja Cenoura)**: #E67E22
*   **Fundo (Cinza Claro)**: #F8F9FA
*   **Contraste (Preto Texto)**: #2C3E50

### 5.2 Tipografia e Interface
*   **Fonte**: Sans-serif (Roboto ou Segoe UI).
*   **Componentes**: Botões com tamanho mínimo de **44px**.
*   **Modo de Alto Contraste**: Fundo branco (`#FFFFFF`), textos e ícones em preto (`#000000`), e bordas pretas (2px).

---

## 6. Arquitetura da Aplicação

A aplicação segue uma **Arquitetura em Camadas** e foi desenvolvida em duas fases estratégicas:

### Fase 1: Protótipo de Frontend (Sprint 0 - Concluído)

Para garantir o alinhamento e validar todos os fluxos de usuário antes do desenvolvimento do backend, foi criado um protótipo de alta fidelidade. A arquitetura desta fase é:

*   **Camada de Apresentação (Frontend Puro)**: Construída com HTML5, CSS3 e **Bootstrap 5**. Os arquivos `.php` serviram como **templates HTML estáticos**, sem processamento no lado do servidor.
*   **Lógica de UI e Simulação**: Toda a interatividade foi implementada com **JavaScript Vanilla**. Scripts como `app.js` e `form-oferta.js` manipulam o DOM e simulam o comportamento do backend, buscando dados de arquivos `data/*.json` locais via `fetch()`.

Este protótipo funcional serviu como um "contrato" visual, garantindo que a API a ser construída na fase seguinte atenderia precisamente às necessidades da interface.

### Fase 2: Backend e Integração (Sprints 1 em diante)

A arquitetura final da aplicação integrada seguirá o seguinte modelo:

*   **Camada de Apresentação (Frontend)**: A mesma estrutura de HTML/CSS/JS do protótipo, mas os `fetch()` serão redirecionados dos arquivos `.json` para os endpoints da API RESTful.
*   **Camada de Serviços PWA**: Composta pelo `manifest.json` e pelo **Service Worker**. Implementará a estratégia de cache *Stale-While-Revalidate* para ativos estáticos e *Network-First* para dados da API.
*   **Camada de Aplicação (Backend)**: Uma **API RESTful** desenvolvida em **PHP 8.x** puro, utilizando Programação Orientada a Objetos (POO) para encapsular as regras de negócio.
*   **Camada de Persistência (Dados)**: Banco de dados relacional **MariaDB** para armazenamento centralizado e **LocalStorage** para persistência temporária no cliente (essencial para a funcionalidade offline).

### 6.1 Modelo de Dados

A persistência dos dados no MariaDB é estruturada em torno de três tabelas principais, que representam as entidades centrais do sistema:

*   **`usuarios`**: Tabela consolidada que armazena os dados de **Feirantes** e **Consumidores**, diferenciados pela coluna `tipo`.
*   **`ofertas`**: Contém todos os kits de "xepa" anunciados pelos feirantes, incluindo detalhes como preço, quantidade e status de disponibilidade.
*   **`reservas`**: Registra o ciclo de vida de uma reserva feita por um consumidor, com status detalhados (de 'Pendente' a 'Concluída' ou 'Cancelada') e um `codigo_retirada` único.

---

## 7. Segurança e Dados

*   **Proteção**: Uso de `password_hash` para senhas e *Prepared Statements* (PDO) contra SQL Injection.
*   **Privacidade**: Dados de geolocalização são usados apenas para o mapeamento da oferta, sem armazenar históricos de rastreio.

---

## 8. Cronograma e Riscos

*   **Período de Execução:** 09/03/2026 a 29/05/2026.
*   **Ponto de Atenção Crítico:** Baixa conectividade 4G nas feiras, o que pode impactar a experiência do usuário em tempo real.
*   **Estratégia de Mitigação:** Implementação de um Service Worker robusto com estratégia de cache e sincronização assíncrona de dados para garantir o funcionamento offline.

### 8.1 Fases do Projeto

| Fase | Sprint | Foco Principal | Período Previsto |
| :--- | :--- | :--- | :--- |
| **Fase 1** | Sprint 0 | Prototipação e Validação de UI/UX (Frontend estático) | 09/03 a 20/03 |
| **Fase 2** | Sprint 1 | Desenvolvimento do Backend (API) e DB - **Módulo de Ofertas** | 23/03 a 17/04 |
| **Fase 2** | Sprint 2 | Desenvolvimento do Backend (API) e DB - Módulos de Usuários e Reservas | 20/04 a 08/05 |
| **Fase 3** | Sprint 3 | Integração Frontend + Backend, PWA e Testes | 11/05 a 29/05 |

### 8.2 Status das Entregas (Atualizado em 30/05/2026)

| Requisito Associado | Entrega | Status | Data de Conclusão |
| :--- | :--- | :--- | :--- |
| **RF03** | **Módulo de Gerenciamento de Ofertas (CRUD Completo)** | ✅ **Concluído** | 30/05/2026 |
| **RF01, RF02** | Módulo de Cadastro e Autenticação de Usuários | ⏳ Em Andamento | - |
| **RF04** | Módulo de Reservas de Kits | 📋 Planejado | - |
| **RF05** | Dashboard de Impacto | 📋 Planejado | - |

---

*Documentação gerada como artefato do Projeto Extensionista Integrador.*
