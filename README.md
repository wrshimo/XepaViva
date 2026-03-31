# Projeto XepaViva

## 1. Visão Geral e Objetivo do Projeto

**XepaViva** é um Progressive Web App (PWA) projetado para fomentar a economia circular e combater o desperdício de alimentos. A aplicação conecta feirantes a consumidores para facilitar a venda de excedentes de produção — frequentemente chamados de "xepa" — que ainda estão perfeitamente aptos para o consumo, apesar de imperfeições estéticas. O sistema atua como uma ponte, transformando potenciais resíduos em recursos valiosos, abordando diretamente o Objetivo de Desenvolvimento Sustentável (ODS) 12 da ONU: Consumo e Produção Responsáveis.

*   **ODS Vinculada:** 12 - Consumo e Produção Responsáveis.
*   **Meta da ONU:** 12.3 - Reduzir pela metade o desperdício global de alimentos per capita nos níveis de varejo e consumidor.
*   **Meta SMART:** Implementar um PWA funcional conectando 30 feirantes a 200 consumidores ativos, visando reduzir o descarte de alimentos nas bancas participantes em 20% até 29 de maio de 2026.

## 2. Personas e Partes Interessadas

| Papel | Persona | Dores e Necessidades |
| :--- | :--- | :--- |
| **Principal (Ofertante)** | **Seu Benedito** | Um feirante em Cuiabá, MT, que precisa minimizar as perdas financeiras com produtos maduros não vendidos. |
| **Secundário (Comprador)** | **Mariana** | Uma consumidora consciente/voluntária de ONG que busca alimentos acessíveis, apoia a economia local e procura produtos para causas sociais. |

## 3. Requisitos do Sistema

### 3.1 Requisitos Funcionais (RF)

| ID | Nome | Descrição | Prioridade |
| :--- | :--- | :--- | :--- |
| **RF01** | Cadastro de Usuário | Criar perfis para "Feirante" ou "Consumidor" com validação única (CPF/CNPJ). | Essencial |
| **RF02** | Login de Usuário | Autenticar usuários com níveis de acesso distintos e sessões persistentes. | Essencial |
| **RF03** | Anunciar Kit "Xepa" | Permitir que feirantes listem itens com preço, peso e categoria de perecibilidade. | Essencial |
| **RF04** | Reservar Kit | Permitir que consumidores reservem kits disponíveis para retirada física. | Essencial |
| **RF05** | Dashboard de Impacto | Exibir métricas sobre alimentos salvos (kg) e economia (R$) usando Chart.js. | Importante |
| **RF06** | Sincronização Offline | Sincronizar automaticamente dados armazenados localmente quando uma conexão com a internet for restabelecida. | Importante |
| **RF07** | Modo de Acessibilidade | Alternar para um modo de "Alto Contraste" para visibilidade clara em ambientes externos e claros. | Importante |

### 3.2 Requisitos Não Funcionais (RNF)

| ID | Descrição | Categoria |
| :--- | :--- | :--- |
| **RNF01** | Interface responsiva e mobile-first usando Bootstrap 5. | Usabilidade |
| **RNF02** | PWA com um Service Worker para desempenho resiliente offline e com baixa conectividade. | Disponibilidade |
| **RNF03** | Backend construído com PHP 8 puro usando arquitetura Orientada a Objetos. | Portabilidade |
| **RNF04** | Segurança de dados usando Prepared Statements (PDO) e aproveitando o LocalStorage para dados offline. | Segurança |
| **RNF05** | Telas de alto contraste para garantir a acessibilidade. | Acessibilidade |

## 4. Arquitetura da Aplicação

A aplicação segue um padrão de **Arquitetura em Camadas**, com ênfase no desacoplamento e na resiliência offline.

*   **Camada de Apresentação (Frontend)**: Construída com HTML5, CSS3 e **Bootstrap 5**. Utiliza JavaScript Baunilha (Vanilla) para manipulação do DOM e **Chart.js** para visualização de dados.
*   **Camada de Serviço PWA**: Consiste no `manifest.json` e em um **Service Worker**. Implementa uma estratégia de cache *Stale-While-Revalidate* para ativos estáticos e *Network-First* para dados críticos.
*   **Camada de Aplicação (Backend)**: Uma API RESTful desenvolvida em **PHP 8.x** usando Programação Orientada a Objetos (POO), evitando frameworks pesados para manter a portabilidade.
*   **Camada de Persistência (Dados)**: Um banco de dados relacional **MariaDB** para armazenamento centralizado e **LocalStorage** para persistência temporária no lado do cliente durante estados offline.

## 5. Experiência do Usuário (UX) e Visual

*   **Paleta de Cores**:
    *   **Primária (Verde Xepa)**: `#2ECC71` - Simboliza frescor e sustentabilidade.
    *   **Secundária (Laranja Cenoura)**: `#E67E22` - Usada para alertas e botões de chamada para ação.
    *   **Fundo (Cinza Claro)**: `#F8F9FA` - Garante uma leitura confortável.
    *   **Texto (Escuro)**: `#2C3E50` - Fornece tipografia nítida e clara.
*   **Tipografia e Interface**:
    *   **Fonte**: Sans-serif (ex: Roboto) para legibilidade em telas de dispositivos móveis.
    *   **Componentes**: Botões com um tamanho mínimo de **44px** para facilitar o toque.
    *   **Modo de Alto Contraste**: Um tema especial com fundo branco puro e bordas pretas espessas para excelente visibilidade sob luz solar direta.

*Esta documentação foi gerada como um artefato do "Projeto Extensionista Integrador."*
