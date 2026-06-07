# XepaViva API Documentation

**Versão:** 2.0.0
**Data:** 07 de junho de 2026
**Endpoint Base:** `/api/routes/`

Esta documentação descreve os endpoints da API do projeto XepaViva. Todas as requisições e respostas utilizam o formato JSON.

---

## Recurso: Painel do Feirante

**Endpoint:** `dashboard_feirante.php`

### 1. Obter Dados do Painel

Recupera uma compilação de métricas e listas de atividades recentes para um feirante específico, essencial para popular a tela inicial do painel.

- **Método:** `GET`
- **URL:** `/api/routes/dashboard_feirante.php?feirante_id={id_do_feirante}`
- **Parâmetros de URL:**
  - `feirante_id` (obrigatório): O ID do feirante cujos dados devem ser recuperados.

**Exemplo com `curl`:**
```bash
curl -X GET "http://localhost:3000/api/routes/dashboard_feirante.php?feirante_id=1"
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
  "metricas": {
    "total_ofertas_ativas": "5",
    "total_reservas_pendentes": "3",
    "faturamento_realizado": "127.50"
  },
  "ultimas_ofertas": [
    {
      "id": 12,
      "nome": "Kit de Laranjas Pera",
      "preco": "10.00"
    }
  ],
  "ultimas_reservas": [
    {
      "reserva_id": 8,
      "oferta_nome": "Cesta de Tomates",
      "status": "Aguardando Retirada",
      "codigo_retirada": "XV-A4B8"
    }
  ]
}
```

---

## Recurso: Painel do Consumidor

**Endpoint:** `dashboard_consumidor.php`

### 1. Obter Dados do Painel do Consumidor

Recupera uma compilação de métricas, listas de atividades e histórico para o consumidor atualmente logado. O acesso a este endpoint requer uma sessão de usuário ativa do tipo "Consumidor".

- **Método:** `GET`
- **URL:** `/api/routes/dashboard_consumidor.php`
- **Autenticação:** Baseada em Sessão. O `consumidor_id` é obtido automaticamente da sessão do usuário logado.

**Exemplo com `curl` (requer um cookie de sessão válido):**
```bash
# Assumindo que o cookie de sessão (ex: PHPSESSID) é gerenciado pelo cliente
curl -X GET http://localhost:3000/api/routes/dashboard_consumidor.php --cookie "PHPSESSID=seu_id_de_sessao"
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "data": {
        "kpis": {
            "economia_total_reais": 25.50,
            "alimentos_salvos_kg": 12.5,
            "total_reservas": 8
        },
        "reservas_ativas": [
            {
                "id": 15,
                "produto": "Cesta de Agrião",
                "feirante": "Seu Benedito"
            }
        ],
        "historico_reservas": [
            {
                "id": 14,
                "produto": "Kit de Laranjas Pera",
                "status": "Concluida",
                "data_reserva": "2026-06-05 10:15:00",
                "preco_final": "10.00"
            }
        ],
        "feirantes_favoritos": [
            {
                "nome_fantasia": "Seu Benedito",
                "num_reservas": "5"
            },
            {
                "nome_fantasia": "Dona Maria Orgânicos",
                "num_reservas": "3"
            }
        ]
    }
}
```

**Respostas de Erro Comuns:**
- `403 Forbidden`: Se o usuário não estiver logado como um Consumidor.
  `{"status": "error", "message": "Acesso negado."}`

---

## Recurso: Autenticação

**Endpoint:** `auth.php`

### 1. Efetuar Login

Autentica um usuário (Feirante ou Consumidor) com base no e-mail e senha. Em caso de sucesso, inicia uma sessão no servidor e retorna os dados do usuário junto com uma URL de redirecionamento para o frontend.

- **Método:** `POST`
- **URL:** `/api/routes/auth.php`
- **Corpo (raw JSON):** Objeto JSON contendo as credenciais do usuário.

**Exemplo com `curl`:**
```bash
curl -X POST http://localhost:3000/api/routes/auth.php -H "Content-Type: application/json" -d '{ "email": "seu.benedito@email.com", "senha": "senhaForte123" }'
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "message": "Login bem-sucedido.",
    "user": {
        "id": "1",
        "nome": "Seu Benedito",
        "tipo": "Feirante"
    },
    "redirect_url": "feirante.php"
}
```

**Resposta de Exemplo (Falha 401 Unauthorized):**
```json
{
    "status": "error",
    "message": "Email ou senha inválidos."
}
```

**Resposta de Exemplo (Falha 400 Bad Request):**
```json
{
    "status": "error",
    "message": "Email e senha são obrigatórios."
}
```

---

## Recurso: Usuários

**Endpoint:** `usuarios.php`

### 1. Criar Novo Usuário (Cadastro)

Registra um novo usuário na plataforma, seja um Consumidor ou um Feirante.

- **Método:** `POST`
- **URL:** `/api/routes/usuarios.php`
- **Corpo (raw JSON):** Objeto JSON com os dados do novo usuário.

**Exemplo com `curl`:**
```bash
curl -X POST http://localhost:3000/api/routes/usuarios.php -H "Content-Type: application/json" -d '{ \"nome\": \"Mariana Silva\", \"email\": \"mariana.silva@email.com\", \"senha\": \"senhaSegura456\", \"telefone\": \"11987654321\", \"tipo\": \"Consumidor\" }'
```

**Resposta de Exemplo (Sucesso 201 Created):**
```json
{
    "status": "success",
    "message": "Cadastro realizado com sucesso! Você será redirecionado para o login."
}
```

**Respostas de Erro Comuns:**
- **`400 Bad Request`**: Se algum campo obrigatório estiver faltando ou se o e-mail for inválido. 
  `{"status": "error", "message": "Dados inválidos ou incompletos. Por favor, preencha todos os campos corretamente."}`
- **`405 Method Not Allowed`**: Se o método da requisição não for `POST`.
- **`409 Conflict`**: Se o e-mail enviado já estiver cadastrado no sistema.
  `{"status": "error", "message": "Este endereço de e-mail já está em uso."}`

---

## Recurso: Categorias

**Endpoint:** `categorias.php`

### 1. Listar Todas as Categorias

Recupera uma lista de todas as categorias de produtos disponíveis na plataforma. Útil para popular interfaces de filtro ou formulários de criação de ofertas.

- **Método:** `GET`
- **URL:** `/api/routes/categorias.php`

**Exemplo com `curl`:**
```bash
curl -X GET http://localhost:3000/api/routes/categorias.php
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "data": [
        { "nome": "Frutas" },
        { "nome": "Verduras" },
        { "nome": "Legumes" },
        { "nome": "Outros" }
    ]
}
```

**Respostas de Erro Comuns:**
- `405 Method Not Allowed`: Se o método da requisição não for `GET`.

---

## Recurso: Ofertas

**Endpoint:** `ofertas.php`

Este recurso é utilizado para gerenciar todo o ciclo de vida das ofertas de produtos.

### 1. Listar Ofertas (Busca)

Recupera uma lista de ofertas. Possui filtros e uma lógica de negócios específica para diferentes tipos de usuário.

- **Método:** `GET`
- **URL:** `/api/routes/ofertas.php`
- **Parâmetros de URL (Opcionais):**
  - `id={id}`: Busca uma oferta específica pelo seu ID.
  - `feirante_id={id}`: Filtra as ofertas de um feirante específico.
    - **Nota:** Se este parâmetro for usado, a busca retornará **todas** as ofertas do feirante (ativas e inativas). Se for omitido (visão do consumidor), a busca retornará apenas ofertas com `disponivel=true`.
  - `q={termo}`: Filtra ofertas pelo nome ou descrição.
  - `categoria={nome_categoria}`: Filtra ofertas por categoria.
  - `disponivel={true|false}`: Filtra por status de disponibilidade (ignorado se `feirante_id` não estiver presente).

**Exemplo (Consumidor buscando por "tomate"):**
```bash
curl -X GET "http://localhost:3000/api/routes/ofertas.php?q=tomate"
```

**Exemplo (Feirante buscando suas próprias ofertas):**
```bash
curl -X GET "http://localhost:3000/api/routes/ofertas.php?feirante_id=1"
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "data": [
        {
            "id": "5",
            "nome": "Tomate Italiano (cesta)",
            "descricao": "Cerca de 500g de tomate italiano maduro.",
            "preco": "8.50",
            "disponivel": true,
            "feirante_id": "1"
        }
    ]
}
```

### 2. Criar Nova Oferta

Cadastra uma nova oferta para um feirante.

- **Método:** `POST`
- **URL:** `/api/routes/ofertas.php`
- **Corpo (raw JSON):** Objeto JSON com os detalhes da nova oferta.

**Exemplo com `curl`:**
```bash
curl -X POST http://localhost:3000/api/routes/ofertas.php \
-H "Content-Type: application/json" \
-d '{ \"feirante_id\": 1, \"nome\": \"Cesta de Agrião\", \"descricao\": \"Maço de agrião fresco, hidropônico\", \"preco\": 4.00, \"quantidade_inicial\": 15, \"categoria\": \"Verduras\" }'
```

**Resposta de Exemplo (Sucesso 201 Created):**
```json
{
    "status": "success",
    "message": "Oferta criada com sucesso.",
    "id": 15
}
```

### 3. Atualizar Oferta

Modifica os dados de uma oferta existente. Apenas os campos enviados no corpo da requisição serão alterados.

- **Método:** `PUT`
- **URL:** `/api/routes/ofertas.php?id={id_da_oferta}`
- **Corpo (raw JSON):** Objeto JSON com os campos a serem atualizados.

**Exemplo com `curl` (alterando o preço e a quantidade):**
```bash
curl -X PUT http://localhost:3000/api/routes/ofertas.php?id=15 \
-H "Content-Type: application/json" \
-d '{ \"preco\": 3.50, \"quantidade_disponivel\": 10 }'
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "message": "Oferta atualizada com sucesso."
}
```

### 4. Excluir Oferta

Remove permanentemente uma oferta do sistema.

- **Método:** `DELETE`
- **URL:** `/api/routes/ofertas.php?id={id_da_oferta}`

**Exemplo com `curl`:**
```bash
curl -X DELETE http://localhost:3000/api/routes/ofertas.php?id=15
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "message": "Oferta excluída com sucesso."
}
```

---

## Recurso: Reservas

**Endpoint:** `reservas.php`

Gerencia a criação, consulta e atualização de reservas.

### 1. Criar Nova Reserva

Um consumidor cria uma reserva para uma oferta específica.

- **Método:** `POST`
- **URL:** `/api/routes/reservas.php`
- **Corpo (raw JSON):** Objeto com os detalhes da reserva.

**Exemplo com `curl`:**
```bash
curl -X POST http://localhost:3000/api/routes/reservas.php \
-H "Content-Type: application/json" \
-d '{ \"consumidor_id\": 2, \"oferta_id\": 5, \"quantidade_reservada\": 1 }'
```

**Resposta de Exemplo (Sucesso 201 Created):**
```json
{
    "status": "success",
    "message": "Reserva criada com sucesso.",
    "data": {
        "reserva_id": 9,
        "codigo_retirada": "XV-F9E2"
    }
}
```

**Respostas de Erro Comuns:**
- `400 Bad Request`: Dados incompletos.
- `503 Service Unavailable`: Não foi possível criar a reserva (ex: estoque indisponível).

### 2. Buscar/Listar Reservas

Recupera informações de reservas com base em diferentes parâmetros. É obrigatório o uso de ao menos um dos seguintes filtros.

- **Método:** `GET`
- **URL:** `/api/routes/reservas.php`
- **Parâmetros de URL:**
  - `id={id}`: Busca uma reserva específica pelo ID.
  - `codigo_retirada={codigo}`: Busca uma reserva específica pelo código de retirada.
  - `consumidor_id={id}`: Lista todas as reservas de um consumidor.
  - `feirante_id={id}`: Lista todas as reservas de um feirante.
  - `status[]={status}`: (Opcional) Pode ser combinado com `consumidor_id` ou `feirante_id` para filtrar por status (ex: `Pendente`, `Concluida`).

**Exemplo (Listar para um feirante):**
```bash
curl -X GET "http://localhost:3000/api/routes/reservas.php?feirante_id=1"
```

**Resposta de Exemplo (Listagem):**
```json
{
    "status": "success",
    "data": [
        {
            "id": "9",
            "cliente_nome": "Mariana Silva",
            "oferta_nome": "Tomate Italiano (cesta)",
            "quantidade_reservada": "1",
            "codigo_retirada": "XV-F9E2",
            "status": "Pendente",
            "data_reserva": "2026-06-07 15:30:00"
        }
    ]
}
```

**Exemplo (Buscar por código):**
```bash
curl -X GET "http://localhost:3000/api/routes/reservas.php?codigo_retirada=XV-F9E2"
```

**Resposta de Exemplo (Busca Única):**
```json
{
    "status": "success",
    "data": {
         "id": "9",
         "oferta_nome": "Tomate Italiano (cesta)",
         "feirante_nome": "Seu Benedito",
         "consumidor_nome": "Mariana Silva",
         "status": "Pendente"
    }
}
```

### 3. Atualizar Status de uma Reserva

Permite que um Feirante altere o status de uma reserva (ex: de "Pendente" para "Concluída" ou "Cancelada").

- **Método:** `PUT`
- **URL:** `/api/routes/reservas.php`
- **Corpo (raw JSON):** Objeto JSON com o `reserva_id` e o novo `status`.

**Exemplo com `curl`:**
```bash
curl -X PUT http://localhost:3000/api/routes/reservas.php \
-H "Content-Type: application/json" \
-d '{ \"reserva_id\": 9, \"status\": \"Concluida\" }'
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "message": "Status da reserva atualizado com sucesso."
}
```

---

## Recurso: Impacto

**Endpoint:** `impacto.php`

### 1. Obter Dados de Impacto Global

Recupera os principais indicadores de performance (KPIs) e dados agregados que demonstram o impacto total da plataforma XepaViva. Este endpoint é público e ideal para ser usado em uma página inicial ou dashboard de impacto.

- **Método:** `GET`
- **URL:** `/api/routes/impacto.php`
- **Autenticação:** Nenhuma.

**Exemplo com `curl`:**
```bash
curl -X GET http://localhost:3000/api/routes/impacto.php
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "data": {
        "kpis": {
            "alimento_salvo_kg": 150.75,
            "renda_gerada_reais": 1250.50,
            "feirantes_parceiros": 15,
            "reservas_concluidas": 210,
            "familias_impactadas": 85
        },
        "graficos": {
            "status_reservas": [
                {
                    "status_agrupado": "Concluida",
                    "contagem": "210"
                },
                {
                    "status_agrupado": "Pendente",
                    "contagem": "15"
                },
                {
                    "status_agrupado": "Cancelada",
                    "contagem": "35"
                }
            ],
            "top_categorias": [
                {
                    "categoria": "Frutas",
                    "kg_por_categoria": "70.5"
                },
                {
                    "categoria": "Legumes",
                    "kg_por_categoria": "45.2"
                },
                {
                    "categoria": "Verduras",
                    "kg_por_categoria": "35.05"
                }
            ]
        }
    }
}
```

**Respostas de Erro Comuns:**
- `503 Service Unavailable`: Se houver um erro ao conectar com o banco de dados ou ao executar as consultas.
