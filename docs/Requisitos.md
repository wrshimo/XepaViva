# 🍎 Projeto XepaViva - Documentação de Requisitos

* **Versão:** 1.1
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
| **Principal (Ofertante)** | **Seu Benedito** | Feirante em Cuiabá; precisa reduzir perdas financeiras e o descarte físico de mercadorias maduras. |
| **Secundário (Comprador)** | **Mariana** | Consumidora consciente/ONG; Busca segurança alimentar e economia local; Necessidade de alimentos acessíveis; Apoio a causas sustentáveis; Dificuldade de acesso a doações. |

---

## 3. Requisitos do Sistema

### 3.1 Requisitos Funcionais (RF)

| ID | Nome | Descrição | Prioridade |
| :--- | :--- | :--- | :--- |
| **RF01** | Cadastrar Usuário | Registro de perfis (Feirante ou Consumidor) com validação de unicidade (CPF/CNPJ). | Essencial |
| **RF02** | Efetuar Login | Autenticação de usuários com diferentes níveis de acesso e persistência de sessão. | Essencial |
| **RF03** | Anunciar Kit Xepa | Feirante cadastra itens com preço, peso e categoria de perecibilidade. | Essencial |
| **RF04** | Reservar Kit | Consumidor reserva itens disponíveis para retirada física. | Essencial |
| **RF05** | Dashboard de Impacto | Exibição de métricas de alimentos salvos (kg) e economia (R$) via Chart.js. | Importante |
| **RF06** | Sincronização Offline | Envio automático de dados salvos localmente ao detectar reconexão à internet. | Importante |
| **RF07** | Ajuste de Acessibilidade | Alternância para modo de "Alto Contraste" para uso em ambientes externos sob sol forte. | Importante |

### 3.2 Requisitos Não Funcionais (RNF)

| ID | Descrição | Categoria |
| :--- | :--- | :--- |
| **RNF01** | Interface responsiva baseada em Bootstrap 5 (Mobile-First). | Usabilidade |
| **RNF02** | PWA com Service Worker para funcionamento resiliente em baixa conexão. | Disponibilidade |
| **RNF03** | Back-end em PHP 8 puro com Arquitetura Orientada a Objetos (OO). | Portabilidade |
| **RNF04** | Segurança de dados com Prepared Statements (PDO) e LocalStorage. | Segurança |
| **RNF05** | As telas devem possuir um alto contraste, permitindo uma melhor acessibilidade. | Acessibilidade |

---

## 4. Engenharia de Casos de Uso

### 4.1 Atores

* **Feirante:** Responsável pela oferta e gestão de estoque.
* **Consumidor:** Responsável pela busca e reserva dos produtos.
* **Sistema:** Agente automatizador de sincronização e cálculos de métricas.

### 4.2 Atores

Relação de Casos de Uso
1. **UC01: Cadastrar Usuário** (Atores: Todos)
1. **UC02: Efetuar Login** (Atores: Todos)
1. **UC03: Anunciar Kit Xepa** (Ator: Feirante)
1. **UC04: Reservar Kit** (Ator: Consumidor)
1. **UC05: Visualizar Dashboard** (Ator: Feirante / Administrador)

### 4.3 Especificações de Casos de Uso

#### **UC01: Cadastrar Usuário**

* **Pré-condições:** O identificador único (CPF/CNPJ) e o e-mail não devem possuir registro prévio ativo na base de dados.
* **Pós-condições:** Novo perfil gerado e habilitado para transações.

#### **UC03: Anunciar Kit Xepa**

* **Atores**: Feirante.
* **Pré-condições:** O perfil do usuário deve ser "Feirante"; O item anunciado deve pertencer a uma categoria de alimentos perecíveis.
* **Pós-condições:** Oferta pública ativa com status "Disponível".

**Fluxo Principal:**
1. O feirante acessa a aba "Anunciar".
1. O sistema solicita descrição, categoria, preço e peso estimado.
1. O feirante confirma o anúncio.
1. O sistema captura a geolocalização e persiste a oferta com status "Disponível".

**Fluxo Alternativo (Offline):**
1. O sistema detecta falta de conexão.
1. O anúncio é salvo no LocalStorage com um ID temporário (UUID).
1. O sistema informa que o anúncio será publicado assim que houver rede.

**Fluxo de Exceção:**
1. Dados obrigatórios ausentes: o sistema destaca os campos e impede o envio.
1. Falha no GPS: o sistema solicita que o feirante selecione manualmente a feira cadastrada.

#### **UC04: Reservar Kit**

* **Atores**: Consumidor.
* **Pré-condições:** O kit deve possuir estoque disponível (Qtd > 0); O horário da reserva deve respeitar o limite operacional da feira; O consumidor deve estar abaixo do limite diário de reservas pendentes.
* **Pós-condições:** Estoque decrementado e código de retirada gerado para o usuário.

**Fluxo Principal:**
1. O consumidor visualiza a lista de kits disponíveis.
1. Seleciona um kit e clica em "Reservar".
1. O sistema valida o estoque em tempo real.
1. O sistema decrementa o estoque e gera um código de retirada.

**Fluxo Alternativo (Reserva de último item):**
1. Dois usuários tentam reservar o mesmo item simultaneamente.
1. O sistema processa o primeiro pedido e informa ao segundo que o item "Esgotou durante o processo".

**Fluxo de Exceção:**
1. Usuário atinge o limite diário de reservas: o sistema bloqueia a ação e informa a regra de negócio.

#### **UC05: Visualizar Dashboard**

* **Pré-condições:** Deve existir histórico de transações concluídas no banco de dados para o período selecionado.
* **Pós-condições:** Projeção visual de indicadores para suporte à tomada de decisão.

---

## 5. User Experience (UX) e Padrão Visual

### 5.1 Paleta de Cores
A escolha cromática visa remeter ao frescor dos alimentos e à urgência do combate ao desperdício.

* **Primária (Verde Xepa)**: #2ECC71 - Simboliza frescor, sustentabilidade e "item liberado".
* **Secundária (Laranja Cenoura)**: #E67E22 - Cor de destaque para alertas, botões de ação e energia.
* **Fundo (Cinza Claro)**: #F8F9FA - Garante conforto visual na leitura.
* **Contraste (Preto Texto)**: #2C3E50 - Tipografia nítida para leitura rápida.

### 5.2 Tipografia e Interface
* **Fonte**: Sans-serif (Roboto ou Segoe UI) para legibilidade em telas móveis.
* **Componentes**: Botões com tamanho mínimo de **44px** para facilitar o toque por feirantes em movimento.
* **Modo de Alto Contraste**: Interface com fundo branco puro e bordas pretas espessas para visibilidade sob luz solar direta.

---

## 6. Arquitetura da Aplicação

A aplicação segue o padrão de **Arquitetura em Camadas** com foco em desacoplamento e resiliência offline.

* **Camada de Apresentação (Frontend)**: Construída com HTML5, CSS3 e **Bootstrap 5**. Utiliza JavaScript Vanilla para manipulação do DOM e **Chart.js** para visualização de dados.
* **Camada de Serviços PWA**: Composta pelo `manifest.json` e pelo **Service Worker**. Implementa a estratégia de cache *Stale-While-Revalidate* para ativos estáticos e *Network-First* para *dados críticos.
* **Camada de Aplicação (*Backend*)**: API RESTful desenvolvida em **PHP 8.x** utilizando Programação Orientada a Objetos (POO). Não utiliza frameworks pesados para manter a portabilidade.
* **Camada de Persistência (Dados)**: Banco de dados relacional **MariaDB** para armazenamento centralizado e **LocalStorage** para persistência temporária no dispositivo do usuário durante estados offline.

---

## 7. Segurança e Dados

* **Proteção**: Uso de `password_hash` para senhas e *Prepared Statements* (PDO) contra SQL Injection.
* **Privacidade**: Dados de geolocalização são utilizados apenas para o mapeamento da oferta, não sendo armazenados históricos de rastreio dos usuários.

---

## 8. Cronograma e Riscos

* **Execução:** 09/03/2026 a 29/05/2026.
* **Ponto de Atenção:** Baixa conectividade 4G nas feiras de Várzea Grande.
* **Mitigação:** Sincronização assíncrona baseada em UUIDs únicos gerados localmente.

---

*Documentação gerada como artefato do Projeto Extensionista Integrador.*