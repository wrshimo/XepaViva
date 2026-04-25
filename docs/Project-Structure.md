# 📂 Estrutura do Projeto XepaViva

Este documento descreve a organização dos diretórios e arquivos do projeto, explicando o propósito de cada um.

```
/xepaviva
│
├── 📁 analises/                 # Contém laudos e análises técnicas do projeto.
│   └── Analise-20260413.md
│
├── 📁 assets/                   # Arquivos de front-end compilados e estáticos.
│   ├── 📁 css/                   # Folhas de estilo.
│   │   ├── high-contrast.css   # Estilos para o modo de alta acessibilidade.
│   │   └── style.css           # Estilos globais e customizações do Bootstrap.
│   │
│   ├── 📁 images/                # Ícones, logos e outras imagens da UI.
│   │   ├── favicon.svg
│   │   └── logo-white.svg
│   │
│   └── 📁 js/                    # Scripts JavaScript do lado do cliente.
│       ├── app.js                # Lógica principal da aplicação (busca e renderização de dados).
│       ├── form-oferta.js        # Lógica específica para o formulário de cadastro/edição.
│       ├── high-contrast.js      # Manipula a ativação do modo de alto contraste.
│       ├── toast.js              # Gerencia a exibição de notificações (toasts).
│       └── validacao.js          # Classe para validação de formulários.
│
├── 📁 data/                     # Dados mockados para simulação do protótipo.
│   ├── ofertas.json
│   └── reservas.json
│
├── 📁 database/                 # Definição e esquema do banco de dados.
│   └── schema.sql              # Script SQL para criar a estrutura e popular as tabelas.
│
├── 📁 docs/                     # Documentação oficial do projeto.
│   ├── Jornada.md
│   ├── Project-Structure.md    # Este arquivo.
│   ├── Requisitos.md
│   ├── arquitetura.svg
│   └── UseCases.md
│
├── .gitignore                  # Especifica arquivos a serem ignorados pelo Git.
├── buscar-ofertas.php          # Página para consumidores buscarem ofertas (Template HTML).
├── cadastrar_oferta.php        # Formulário para feirantes criarem/editarem ofertas (Template HTML).
├── codigo-retirada.php         # Página que exibe o código para retirada da reserva.
├── como-funciona.php           # Página estática explicativa.
├── consumidor.php              # Painel principal do consumidor.
├── feirante.php                # Painel principal do feirante.
├── index.php                   # Página inicial (landing page).
├── login.php                   # Página de simulação de login.
├── manifest.json               # Manifesto do PWA.
├── minhas-ofertas.php          # Página para feirantes visualizarem suas ofertas (Template HTML).
├── minhas-reservas.php         # Página para consumidores visualizarem suas reservas (Template HTML).
└── sw.js                       # Service Worker (ainda como placeholder).
```

## Arquitetura de Frontend (Sprint 0)

A arquitetura atual do frontend foi projetada para ser um **protótipo de alta fidelidade e totalmente funcional**:

-   **Templates HTML (`.php`):** As páginas são arquivos PHP que atuam como templates HTML puros. Eles contêm a estrutura da página, mas nenhuma lógica de dados.
-   **Lógica em JavaScript:** Toda a interatividade, busca de dados (dos arquivos `.json`) e manipulação do DOM é realizada por JavaScript, em arquivos separados na pasta `assets/js/`.
    -   `app.js` é o orquestrador principal para páginas de listagem.
    -   `form-oferta.js` demonstra uma abordagem modular, tratando de uma funcionalidade específica.
-   **Simulação de Backend:** A interação com o "backend" é simulada através de `fetch()` para os arquivos locais `.json`, e o "salvamento" de dados é confirmado via `console.log()`. Isso permitiu validar todos os fluxos de usuário sem escrever uma linha de código de servidor.

Esta abordagem garantiu que o **Sprint 0** fosse concluído rapidamente, resultando em um protótipo robusto que serve como um "contrato" visual para o desenvolvimento do backend.

## 🏛️ Arquitetura da Aplicação

A arquitetura do XepaViva é projetada para ser uma Progressive Web App (PWA) robusta, com uma clara separação entre o cliente (frontend) e o servidor (backend), seguindo uma abordagem de *offline-first*.

![Arquitetura da Aplicação](arquitetura.svg)

### Cliente (PWA)

O lado do cliente é construído como uma PWA para garantir uma experiência de usuário rica, responsiva e funcional mesmo sem conexão com a internet.

-   **Interface do Usuário (UI):** Desenvolvida com **HTML5, CSS3, e Bootstrap 5**, focando em uma experiência mobile-first e acessível. A lógica da interface é manipulada por **Vanilla JavaScript**, que interage com o DOM e os serviços do PWA.
-   **Service Worker:** Atua como um proxy entre a aplicação, o navegador e a rede. É responsável por:
    -   **Cache:** Implementa a estratégia *Stale-While-Revalidate* para ativos estáticos (HTML, CSS, JS), servindo-os rapidamente do cache enquanto busca atualizações em segundo plano.
    -   **Offline First:** Permite que a aplicação funcione offline, interceptando requisições e servindo respostas do cache quando a rede não está disponível.
-   **Armazenamento Local (LocalStorage):** Utilizado para persistir dados gerados pelo usuário enquanto offline (como o cadastro de uma nova oferta). Esses dados são mantidos localmente até que a conexão com a internet seja restabelecida, momento em que são sincronizados com o servidor.

### Servidor (Backend)

O backend é uma API RESTful construída em **PHP 8+** puro, seguindo os princípios da Programação Orientada a Objetos (OOP) e uma arquitetura em camadas para garantir desacoplamento e manutenibilidade.

-   **Camada de Aplicação (API):** Expõe os endpoints RESTful (ex: `/ofertas`, `/usuarios`) que o cliente consome. É responsável por receber as requisições HTTP, autenticar o usuário e orquestrar a resposta.
-   **Camada de Serviço:** Contém a lógica de negócio da aplicação. Processa os dados recebidos da camada de API, aplica as regras de negócio (validações, cálculos, etc.) e coordena o acesso aos dados.
-   **Camada de Persistência:** Abstrai a comunicação com o banco de dados. Utiliza a extensão **PDO do PHP com *prepared statements*** para todas as operações de banco de dados, prevenindo vulnerabilidades como SQL Injection.
-   **Banco de Dados:** **MariaDB** é o sistema de gerenciamento de banco de dados escolhido para armazenar todos os dados da aplicação, como usuários, ofertas e reservas.

### Fluxo de Dados

1.  **Online:** O cliente envia requisições HTTP para a API RESTful no servidor. O servidor processa a requisição através de suas camadas e retorna uma resposta em formato JSON.
2.  **Offline:** Quando o cliente está offline, o Service Worker intercepta as requisições.
    -   Para leitura de dados (GET), ele retorna os dados cacheados.
    -   Para escrita de dados (POST, PUT), ele armazena a requisição no **LocalStorage**. Assim que a conexão é restaurada, o Service Worker sincroniza os dados pendentes com o servidor.
