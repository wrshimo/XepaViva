# Histórico de Mudanças do Projeto XepaViva

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/).

---

## [Unreleased]

### Adicionado
- Início da estrutura para autenticação de usuários (Consumidor).
- Início da estrutura para o painel de reservas do consumidor.

## [2026-05-30] - Módulo de Ofertas Concluído

### Adicionado
- **Gerenciamento Completo de Ofertas (CRUD):**
  - **API Robusta (`/api/routes/ofertas.php`):** Implementação dos endpoints `GET`, `POST`, `PUT`, e `DELETE` para manipulação de ofertas.
  - **Painel do Feirante (`/feirante/ofertas.php`):** Criação de uma interface dinâmica com JavaScript puro para consumir a API, permitindo que os feirantes listem, criem, editem e excluam suas ofertas sem recarregar a página.
  - **Modal de Formulário Único:** Utilização de um modal do Bootstrap para as ações de criação e edição, otimizando a experiência do usuário.
- **Correção e Evolução do Banco de Dados:**
  - Adição da coluna `peso` (`DECIMAL(10,3)`) na tabela `ofertas` para alinhar a implementação aos requisitos do caso de uso (UC-01).
  - Inclusão de um script `UPDATE` no `schema.sql` para inicializar dados existentes, garantindo a consistência.
- **Criação do arquivo `CHANGELOG.md`** para documentar o progresso e as versões do projeto.

### Modificado
- O modelo `Oferta.php` foi atualizado para incluir a lógica de manipulação do campo `peso`.
- O frontend foi ajustado para exibir o campo "Quantidade Disponível" como somente leitura no modo de edição, melhorando a clareza para o feirante.
