# 🍎 Projeto XepaViva - Documentação de Requisitos

* **Versão:** 2.1
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

Os detalhes sobre os atores, o diagrama de casos de uso e a especificação completa de cada fluxo de interação (principal, alternativo e de exceção) foram movidos para um documento dedicado, visando a modularidade e a clareza da documentação.

**Para a especificação detalhada, consulte:**

➡️ **[Documento de Casos de Uso (UseCases.md)](UseCases.md)**

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
