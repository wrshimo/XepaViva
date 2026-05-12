# ✅ Entrega da Fase 1 e Próximos Passos

**Guia Rápido para Continuidade do Projeto XepaViva**

> 📅 **Data do Documento:** 30 de maio de 2026
> 🔗 **Análise Completa:** [Analise.md](Analise.md)

---

## 🚀 O Que Foi Entregue na Fase 1 (Concluído)

A Fase 1 do projeto (Março-Maio de 2026) foi concluída com sucesso, resultando na entrega de um **Módulo de Gerenciamento de Ofertas** 100% funcional.

### Checklist de Entregas Técnicas:

- **[✅] API RESTful para Ofertas:**
  - **Localização:** `api/routes/ofertas.php`
  - **Funcionalidades:** Suporta `GET`, `POST`, `PUT`, `DELETE`.
  - **Segurança:** Utiliza PDO com *prepared statements*.

- **[✅] Modelo de Dados de Oferta:**
  - **Localização:** `api/models/Oferta.php`
  - **Padrão:** Código em PHP 8+, orientado a objetos, encapsulando a lógica de negócio.

- **[✅] Interface do Feirante Integrada:**
  - **Localização:** `feirante/ofertas.php`
  - **Funcionalidade:** Painel reativo que consome a API para realizar o CRUD de ofertas sem recarregar a página.

- **[✅] Base de Dados Operacional:**
  - **Localização:** `database/schema.sql`
  - **Status:** Contém o esquema atualizado e funcional das tabelas `usuarios` e `ofertas`.

---

## 🧠 Conhecimento Essencial para a Próxima Equipe

Para dar continuidade ao projeto, entenda os seguintes pontos da arquitetura:

1.  **Backend é uma API Pura:** Não há HTML sendo gerado pelo PHP. A API em `api/` apenas recebe e envia dados em formato JSON.
2.  **Frontend é Independente:** As páginas em `feirante/` são as consumidoras da API. A lógica de cliente está em `assets/js/app.js` e é toda em JavaScript puro.
3.  **Como Adicionar Novas Funcionalidades (Exemplo: Reservas):**
    - **Passo 1 (Backend):** Crie um novo arquivo de rota (`api/routes/reservas.php`).
    - **Passo 2 (Backend):** Crie um novo modelo (`api/models/Reserva.php`).
    - **Passo 3 (Frontend):** Crie a nova página para o usuário (ex: `consumidor/reservas.php`).
    - **Passo 4 (Frontend):** Adicione a lógica de `fetch()` no JavaScript para consumir a nova API de reservas.

---

## 🎯 Checklist para a Fase 2 (Próximos Passos)

O objetivo da Fase 2 é construir as funcionalidades para o **Consumidor**, conectando-o às ofertas criadas pelos feirantes na Fase 1.

### **Sprint 2: Módulo de Usuários e Autenticação**

- [ ] **Backend: CRUD de Usuários (RF01)**
  - [ ] Criar a rota `api/routes/usuarios.php`.
  - [ ] Implementar as funções de `criar`, `ler`, `atualizar` e `deletar` no modelo `Usuario.php`.

- [ ] **Backend: Sistema de Login (RF02)**
  - [ ] Criar um endpoint `api/routes/auth.php`.
  - [ ] Implementar a função de login que verifica o email e a senha (usando `password_verify`).
  - [ ] **Recomendação:** Utilizar JWT (JSON Web Tokens) para gerenciar as sessões de usuário.

- [ ] **Frontend: Telas de Cadastro e Login**
  - [ ] Criar a página de `login.php` com um formulário.
  - [ ] Criar a página de `cadastro.php` com um formulário.
  - [ ] Implementar a lógica de `fetch()` para conectar os formulários aos endpoints da API.

### **Sprint 3: Módulo de Reservas**

- [ ] **Backend: CRUD de Reservas (RF04)**
  - [ ] Criar a rota `api/routes/reservas.php`.
  - [ ] Implementar a lógica para um consumidor criar uma reserva vinculada a uma oferta.
  - [ ] **Importante:** A criação de uma reserva deve, atomicamente, decrementar a `quantidade_disponivel` na tabela `ofertas`.

- [ ] **Frontend: Fluxo do Consumidor**
  - [ ] Criar a página `consumidor/buscar_ofertas.php` que lista todas as ofertas disponíveis (consumindo `GET /api/routes/ofertas.php`).
  - [ ] Adicionar botões de "Reservar" nas ofertas.
  - [ ] Criar a página `consumidor/minhas_reservas.php` para listar as reservas do usuário logado.

### **Sprint 4: PWA e Finalização**

- [ ] **Ativar o Service Worker (RNF02):**
  - [ ] Configurar o `sw.js` para fazer o cache de assets estáticos (CSS, JS, imagens).
  - [ ] Implementar uma estratégia de cache (ex: Stale-While-Revalidate).

- [ ] **Implementar Dashboard de Impacto (RF05):**
  - [ ] Criar um endpoint na API que retorne as métricas (total de peso economizado, etc.).
  - [ ] Utilizar Chart.js no frontend para exibir os gráficos.

---

## ✅ Conclusão

A base do XepaViva está construída e validada. Este documento fornece o roteiro para transformar o sistema em uma plataforma completa, agregando as funcionalidades do consumidor. A arquitetura em camadas (Frontend/Backend) permite que as próximas equipes trabalhem em paralelo com clareza nos objetivos.
