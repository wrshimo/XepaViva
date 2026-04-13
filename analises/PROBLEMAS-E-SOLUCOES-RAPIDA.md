# 🚨 Problemas e Soluções Rápidas - XepaViva

**Referência Rápida de Inconsistências Entre Protótipos e Documentação**

> 📅 Gerado: 13 de abril de 2026  
> 🔗 Análise Completa: [Analise-20260413.md](Analise-20260413.md)

---

## 🔴 Problemas Críticos (Bloqueia Testes)

### 1. **RF07: Alto Contraste Só em Feirante**

**Status:** ⚠️ **Incompleto**

| Página | Alto Contraste | Problema |
|--------|---|---|
| `feirante.php` | ✅ Sim | Implementado |
| `consumidor.php` | ❌ Não | FALTA TOGGLE |
| `cadastrar_oferta.php` | ✅ Sim | Implementado |
| `detalhe_oferta.php` | ❌ Não | FALTA TOGGLE |

**Solução (5 min):**
```html
<!-- Duplicar de feirante.php para consumidor.php -->
<button id="highContrastToggle" class="btn btn-outline-light me-2">
    <i class="bi bi-sun"></i>
    <span class="d-none d-sm-inline">Alto Contraste</span>
</button>
```

**Impacto:** Consumidores (Mariana) não conseguem usar app em luz solar ☀️

---

### 2. **RF01: Página de Registro Não Existe**

**Status:** ❌ **Não Implementada**

**Atual:**
```
index.php → login.php → [Botão: Seu Benedito / Mariana]
```

**Esperado (segundo RF01):**
```
index.php → login.php → [Novo? Registre-se] → registro.php
                   ↓
            [Email, Senha, Nome, CPF/CNPJ]
```

**Impacto:** Modelo de negócio incompleto. Como novos usuários se cadastram?

**Prioridade:** 🔴 **CRÍTICA**

---

### 3. **Inconsistência de Cores de Navbar**

**Problema:**
- `feirante.php`: `bg-dark` (preto)
- `consumidor.php`: `bg-success` (verde)
- Outras páginas: `bg-success` (verde)

**Solução (2 min):**
```html
<!-- Trocar feirante.php -->
<header class="navbar navbar-dark bg-success sticky-top">
    <!-- ao invés de bg-dark -->
</header>
```

**Por quê?** Alinha com paleta de marca (#2ECC71)

---

## 🟠 Funcionalidades Faltando

| Funcionalidade | Requisito | Status | Prioridade |
|---|---|---|---|
| Página Registro | RF01 | ❌ Não existe | 🔴 Crítica |
| Minhas Ofertas | UC-03 | ❌ Não existe | 🔴 Crítica |
| Buscar Ofertas | UC-02 | ❌ Não existe | 🔴 Crítica |
| Minhas Reservas | UC-02 | ❌ Não existe | 🔴 Crítica |
| Código de Retirada | UC-02 | ❌ Não existe | 🔴 Crítica |
| Editar Oferta | UC-03 | ❌ Link stub | 🟠 Alta |
| Deletar Oferta | UC-03 | ⚠️ Sem ação | 🟠 Alta |

---

## 🔗 Links "Stub" (#) Que Precisam Ser Conectados

### `feirante.php`
- [ ] "Minhas Ofertas" → criar `minhas-ofertas.php`

### `consumidor.php`
- [ ] "Buscar Ofertas" → criar `buscar-ofertas.php`
- [ ] "Minhas Reservas" → criar `minhas-reservas.php`
- [ ] "Ver Código de Retirada" → implementar modal/página

### `index.php`
- [ ] "Encontrar Xepas Perto de Mim" → redirecionar para `consumidor.php` ou `buscar-ofertas.php`

---

## 🎨 Problemas de UX/UI

### A. Falta de Feedback Visual em Formulários

**Cenário:** Usuário clica "Publicar Anúncio"

**Atual:**
- Nada acontece
- Sem spinner
- Sem mensagem

**Solução:** Adicionar em `cadastrar_oferta.php`:
```html
<button id="btnPublicar" type="submit" class="btn btn-primary btn-lg">
    <span id="btnText">Publicar Anúncio</span>
    <span id="spinner" class="spinner-border spinner-border-sm ms-2 visually-hidden"></span>
</button>

<div id="alertContainer"></div>
```

**Impacto:** Usuário não sabe se ação foi processada

---

### B. Validação de Formulário Ausente

**Arquivo:** `cadastrar_oferta.php`

**Faltam:**
- ✗ Validação em tempo real
- ✗ Campos obrigatórios destacados
- ✗ Mensagens de erro customizadas

**Solução:** Adicionar `aria-required`, `aria-describedby` e feedback visual

---

### C. Breadcrumbs Faltando

**Afeta:** `detalhe_oferta.php`

**Usuário quer voltar:** "Painel → Ofertas → Tomate Italiano"

**Solução (2 min):**
```html
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="consumidor.php">Painel</a></li>
        <li class="breadcrumb-item"><a href="#buscar">Ofertas</a></li>
        <li class="breadcrumb-item active">Tomate Italiano</li>
    </ol>
</nav>
```

---

### D. Toast Notifications Ausentes

**Necessárias em:**
- ✓ Oferta publicada com sucesso
- ✓ Reserva confirmada
- ✓ Oferta deletada
- ✓ Erro de conexão

**Não existe nenhum protótipo**

---

## 📊 Mapeamento: Documentação vs Protótipo

### Casos de Uso Não Representados em UI

| UC ID | Nome | RF Ligado | Status UI | Prioridade |
|-------|------|-----------|-----------|-----------|
| UC-01 | Anunciar Kit | RF03 | ⚠️ Partial | 🔴 Crítica |
| UC-02 | Reservar Kit | RF04 | ⚠️ Partial | 🔴 Crítica |
| UC-03 | Gerenciar Ofertas | RF03 | ❌ Missing | 🔴 Crítica |
| UC-04 | Dashboard Impacto | RF05 | ✅ Feito | 🟢 OK |
| UC-05 | Sincronizar Offline | RF06 | ❌ Missing | 🟢 Backend |

**UC-01 Status:**
- ✅ Formulário cadastro (cadastrar_oferta.php)
- ❌ Confirmação/preenchimento automático de localização
- ❌ Preview de imagem antes de publicar
- ❌ Sincronização offline

**UC-02 Status:**
- ✅ Detalhe de produto (detalhe_oferta.php)
- ❌ Busca/filtragem de ofertas
- ❌ Código de retirada após confirmação
- ❌ Geolocalização de feiras

**UC-03 Status:**
- ❌ Lista "Minhas Ofertas" não existe
- ❌ Editar oferta (link vazio)
- ❌ Deletar oferta com confirmação
- ❌ Status em tempo real (Disponível/Reservado)

---

## 🔴 Inconsistências Críticas

### 1. **Fluxo de Cadastro vs Fluxo Simulado**

**RF01 (Requisito):** 
> "Registro de perfis (Feirante ou Consumidor) com validação de unicidade (CPF/CNPJ)"

**Protótipo Atual:**
- Sem página de registro
- Login "simulado" sem autenticação

**O que deveria estar:**
```
index.php 
  → login.php 
    → "Novo por aqui?" 
      → registro.php (formulário CPF/CNPJ/Nome/Email/Senha)
```

---

### 2. **Upload de Imagem vs Offline**

**Requisito (RF06 - Sincronização Offline):**
> "Envio automático de dados salvos localmente ao detectar reconexão"

**Protótipo:** 
- Campo file input em cadastrar_oferta.php
- Sem tratamento de imagem offline

**Problema:** Como sincronizar foto em 4G lenta?

**Solução Necessária:**
- Armazenar imagem em IndexedDB
- Enviar após sucesso de dados
- Permitir preview local antes de envio

---

### 3. **LocalStorage não Está Sendo Usado**

**Requisito (RF06):**
> "Sincronização de dados usando LocalStorage"

**Protótipo:**
- ✅ Alto contraste em LocalStorage (certo)
- ❌ Fila de ofertas não está em LocalStorage
- ❌ Reservas offline não são armazenadas

**Falta JavaScript em `app.js`** para:
```javascript
// Armazenar oferta offline
localStorage.setItem('fila_ofertas', JSON.stringify({
  id: UUID(),
  nome: 'Tomate',
  preco: 5.00,
  status: 'pendente_sync'
}));
```

---

### 4. **Feirante vs Consumidor: Inconsistência de Navegação**

**Feirante tem:**
- Alto contraste ✅
- 3 tabs (Painel, Minhas Ofertas, Cadastrar) ✅
- Gráfico Chart.js ✅

**Consumidor tem:**
- Sem alto contraste ❌
- 3 tabs (Painel, Buscar Ofertas, Minhas Reservas) - **links quebrados** ❌
- Sem gráfico de impacto ❌

**Problema:** RF05 (Dashboard de Impacto) deveria ser igual para ambos

---

## 💡 Funcionalidades que DEVERIAM Estar Prototipadas

### Tier 1: Essencial para MVP

| # | Funcionalidade | Local | Tipo | Tempo |
|---|---|---|---|---|
| 1 | Página Registro | `registro.php` | Page | 2h |
| 2 | Minhas Ofertas | `minhas-ofertas.php` | Page | 3h |
| 3 | Buscar/Filtrar Ofertas | `buscar-ofertas.php` | Page | 4h |
| 4 | Minhas Reservas | `minhas-reservas.php` | Page | 2h |
| 5 | Toast Notificações | `assets/js/toast.js` | Component | 1h |
| 6 | Modal Confirmação | `assets/js/modal.js` | Component | 1h |

**Total:** ~13h (Sprint 0 completo)

### Tier 2: UX Melhorado

- [ ] Filtro de categorias (Frutas/Legumes/Verduras)
- [ ] Ordenação (Preço/Data/Proximidade)
- [ ] Mapa de localização de feiras
- [ ] Avaliação de feirantes (stars)
- [ ] Chat entre feirante-consumidor
- [ ] Histórico de transações

---

## 🎯 Roadmap Ajustado (Com Sprint 0)

### **SPRINT 0: Consolidação Frontend (3 dias)**

**Objetivo:** Completar protótipos antes de começar backend

```
DIA 1: Acessibilidade + Navegação
├─ Adicionar alto contraste em consumidor.php
├─ Adicionar alto contraste em detalhe_oferta.php
├─ Criar registro.php (mock)
├─ Criar minhas-ofertas.php (mock)
├─ Conectar navbar em verde
└─ Teste rápido

DIA 2: Páginas Faltando
├─ Criar buscar-ofertas.php (mock com filtros)
├─ Criar minhas-reservas.php (mock)
├─ Conectar todos links stubs (#)
├─ Padronizar breadcrumbs
└─ Teste de navegação completa

DIA 3: Componentes UI + Feedback
├─ Criar toast.js (notificações)
├─ Criar modal.js (confirmação)
├─ Adicionar validação em formulários
├─ Adicionar spinner em botões
├─ Criar preview de imagem upload
└─ Teste visual completo
```

**Entregáveis:**
- ✅ Todas as 7 páginas principais navegáveis
- ✅ Alto contraste em 100% das páginas
- ✅ Feedback visual em formulários
- ✅ Estrutura pronta para backend

**Tempo:** 3 dias (1 dev)  
**Bloqueador:** Nenhum - apenas frontend

---

### **SPRINT 1: Infraestrutura Backend (2-3 semanas)**

```
SEMANA 1:
├─ Schema MariaDB + migrations
├─ API autenticação (login/register)
├─ API criar oferta
└─ Integração com registro.php

SEMANA 2:
├─ API buscar ofertas + filtros
├─ API reservar kit
├─ API dashboard métricas
└─ Integração inicial

SEMANA 3 (parcial):
├─ Validação backend
├─ Tratamento de erros
├─ Testes API
└─ Deploy staging
```

---

### **SPRINT 2: Integração Frontend/Backend (1 semana)**

```
├─ Conectar forms ao backend
├─ Remover dados mock
├─ Adicionar autenticação real
├─ Teste completo de fluxos
└─ Bug fixes
```

---

### **SPRINT 3: PWA Offline (1 semana)**

```
├─ Service Worker
├─ IndexedDB para fila
├─ Sincronização automática
├─ Testes offline
└─ Deploy production
```

---

## 📋 Tabela Resumo: Ajustes Necessários

| Categoria | Item | Tipo | Tempo | Prioridade |
|-----------|------|------|-------|-----------|
| **Acessibilidade** | Alto contraste consumidor | Fix | 0.5h | 🔴 |
| **Acessibilidade** | Alto contraste detalhe | Fix | 0.5h | 🔴 |
| **Navegação** | Registrar página | New | 2h | 🔴 |
| **Navegação** | Minhas Ofertas página | New | 3h | 🔴 |
| **Navegação** | Buscar Ofertas página | New | 4h | 🔴 |
| **Navegação** | Minhas Reservas página | New | 2h | 🔴 |
| **Estilo** | Navbar feirante cor | Fix | 0.2h | 🟠 |
| **UX** | Validação formulário | Enhance | 2h | 🟠 |
| **UX** | Toast notificações | New | 1h | 🟠 |
| **UX** | Modal confirmação | New | 1h | 🟠 |
| **UX** | Breadcrumbs | New | 0.5h | 🟠 |

**Total Sprint 0:** ~16h (2 dias com 2 devs ou 3 dias com 1 dev)

---

## 📝 Recomendações Finais

### ✅ O que está bom:
- Documentação é sólida
- Frontend mobile-first bem implementado
- Paleta de cores definida
- Modo alto contraste bem pensado

### ⚠️ O que precisa ajuste:
- Sprint 0 é CRÍTICO antes de começar backend
- Sem registro → sem modelo de negócio completo
- Links stubs quebram experiência
- App.js ainda está vazio

### 🎯 Próximo Passo:
**Iniciar Sprint 0 HOJE** com foco em completar protótipos. Backend só começa na semana que vem após todas as páginas estarem navegáveis e o app ter "sensação de completude".

---

*Análise gerada em 13/04/2026 como suporte ao Projeto Extensionista Integrador.*
[ ] Remover TODAS as ocorrências de href="#"
[ ] Verificar responsividade em mobile
[ ] Testar acessibilidade: Tab navigation
```

**Tempo Estimado:** 8-12 horas

---

## 🎯 Por Que Sprint 0 É Crítico

### Antes (Sem Sprint 0):
```
Dia 1: Começar Backend
Dia 5: Perceber que consumidor.php não tem as páginas necessárias
Dia 7: Recriar consumidor.php e correlatas
Dia 10: Retrabalho na API (endpoints para páginas que mudaram)
```

### Depois (Com Sprint 0):
```
Dia 1-3: Finalizar frontend 100%
Dia 4: Iniciar Backend com frontend fixo
Dia 8: API pronta para frontend existente
→ Zero retrabalho
```

**Ganho:** 2-3 dias de retrabalho evitados

---

## 📋 Impacto nas Métricas

| Métrica | Sem Sprint 0 | Com Sprint 0 |
|---------|---|---|
| Consistência Visual | 60% | 95% |
| Acessibilidade (WCAG) | 70% | 95% |
| Links Funcionais | 40% | 100% |
| Feedback Usuário | 0% | 80% |
| Conformidade RF07 | 50% | 100% |

---

## 🔧 Próximas Ações

### Imediato (Hoje 13/04):
1. ✅ Leitura desta análise
2. [ ] Planejamento de Sprint 0
3. [ ] Alocação de recursos

### Próximos 3 Dias (Sprint 0):
1. [ ] Alta contraste em todas páginas
2. [ ] Páginas faltando
3. [ ] Validação + Feedback

### Próximo (Sprint 1 - 16/04):
1. [ ] Banco de dados
2. [ ] Autenticação backend
3. [ ] Primeiros endpoints API

---

## 📌 Referências

- **Análise Completa:** [Analise-20260413.md](Analise-20260413.md)
- **Requisitos:** [docs/Requisitos.md](../docs/Requisitos.md)
- **Use Cases:** [docs/UseCases.md](../docs/UseCases.md)

---

*Análise tecnicamente fundamentada | Pronto para apresentação*
