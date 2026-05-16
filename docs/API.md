# XepaViva API Documentation

**Versão:** 1.0.0
**Endpoint Base:** `/api/routes/`

Esta documentação descreve os endpoints disponíveis para a API do projeto XepaViva. Todos os endpoints retornam respostas no formato JSON.

---

## Recurso: Ofertas

O recurso `ofertas` é utilizado para gerenciar os anúncios de produtos dos feirantes.

**Endpoint:** `ofertas.php`

### 1. Listar Todas as Ofertas

Recupera uma lista de todas as ofertas cadastradas.

- **Método:** `GET`
- **URL:** `/api/routes/ofertas.php`

**Exemplo com `curl`:**
```bash
curl -X GET http://localhost:3000/api/routes/ofertas.php
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
[
    {
        "id": "1",
        "produto": "Tomate Italiano",
        "descricao": "Tomates maduros, ótimos para molho.",
        "preco": "5.99",
        "quantidade_disponivel": "10",
        "unidade_medida": "kg",
        "peso": "1.0",
        "data_colheita": "2026-05-28",
        "feirante_id": "1"
    }
]
```

---

### 2. Obter uma Oferta Específica

Recupera os detalhes de uma única oferta pelo seu ID.

- **Método:** `GET`
- **URL:** `/api/routes/ofertas.php?id={id_da_oferta}`

**Exemplo com `curl`:**
```bash
curl -X GET http://localhost:3000/api/routes/ofertas.php?id=1
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "id": "1",
    "produto": "Tomate Italiano",
    "descricao": "Tomates maduros, ótimos para molho.",
    "preco": "5.99",
    "quantidade_disponivel": "10",
    "unidade_medida": "kg",
    "peso": "1.0",
    "data_colheita": "2026-05-28",
    "feirante_id": "1"
}
```

---

### 3. Criar uma Nova Oferta

Cadastra uma nova oferta no sistema. Os dados devem ser enviados no corpo da requisição em formato JSON.

- **Método:** `POST`
- **URL:** `/api/routes/ofertas.php`
- **Cabeçalho:** `Content-Type: application/json`
- **Corpo (raw JSON):** Objeto JSON com os detalhes da oferta.

**Exemplo com `curl`:**
```bash
curl -X POST http://localhost:3000/api/routes/ofertas.php -H "Content-Type: application/json" -d '{ "produto": "Cenoura", "descricao": "Cenouras frescas da horta", "preco": "3.00", "quantidade_disponivel": "25", "unidade_medida": "kg", "peso": "1.0", "data_colheita": "2026-05-29", "feirante_id": 1 }'
```

**Resposta de Exemplo (Sucesso 201 Created):**
```json
{
    "status": "success",
    "message": "Oferta criada com sucesso.",
    "id": 3 
}
```

---

### 4. Atualizar uma Oferta Existente

Atualiza os dados de uma oferta já existente. Todos os campos da oferta, incluindo o `id`, devem ser enviados no corpo da requisição.

- **Método:** `PUT`
- **URL:** `/api/routes/ofertas.php`
- **Cabeçalho:** `Content-Type: application/json`
- **Corpo (raw JSON):** Objeto JSON com todos os dados da oferta a ser atualizada.

**Exemplo com `curl`:**
```bash
curl -X PUT http://localhost:3000/api/routes/ofertas.php -H "Content-Type: application/json" -d '{ "id": 3, "produto": "Cenoura Orgânica", "descricao": "Cenouras frescas e orgânicas", "preco": "4.50", "quantidade_disponivel": "20", "unidade_medida": "kg", "peso": "1.0", "data_colheita": "2026-05-29", "feirante_id": 1 }'
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "message": "Oferta atualizada com sucesso."
}
```

---

### 5. Excluir uma Oferta

Remove uma oferta do sistema. O ID da oferta a ser removida deve ser enviado no corpo da requisição.

- **Método:** `DELETE`
- **URL:** `/api/routes/ofertas.php`
- **Cabeçalho:** `Content-Type: application/json`
- **Corpo (raw JSON):** Objeto JSON contendo o `id` da oferta a ser excluída.

**Exemplo com `curl`:**
```bash
curl -X DELETE http://localhost:3000/api/routes/ofertas.php -H "Content-Type: application/json" -d '{ "id": 3 }'
```

**Resposta de Exemplo (Sucesso 200 OK):**
```json
{
    "status": "success",
    "message": "Oferta excluída com sucesso."
}
```
