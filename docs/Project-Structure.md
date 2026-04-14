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
├── 📁 docs/                     # Documentação oficial do projeto.
│   ├── Jornada.md
│   ├── Project-Structure.md    # Este arquivo.
│   ├── Requisitos.md
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
