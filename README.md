# 🍎 XepaViva PWA

![Licença](https://img.shields.io/badge/license-MIT-green)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)
![PWA](https://img.shields.io/badge/PWA-Friendly-brightgreen)

O **XepaViva** é um Progressive Web App (PWA) focado na economia circular e no combate ao desperdício de alimentos. A plataforma conecta feirantes, que possuem excedentes de produção (a "xepa"), com consumidores e ONGs interessados em adquirir ou receber esses alimentos a preços acessíveis.

Este projeto foi desenvolvido como parte do **Projeto Extensionista Integrador**, com o objetivo de aplicar tecnologia para resolver um problema social e ambiental relevante, alinhado ao Objetivo de Desenvolvimento Sustentável (ODS) 12 da ONU: Consumo e Produção Responsáveis.

---

## ✨ Funcionalidades Principais

*   **Anúncio de Kits "Xepa"**: Feirantes podem cadastrar rapidamente kits de alimentos excedentes, especificando preço, peso e foto.
*   **Reserva para Consumidores**: Consumidores podem navegar pelas ofertas e reservar kits para retirada direta na feira.
*   **Funcionamento Offline**: Graças à arquitetura PWA com Service Workers, feirantes podem cadastrar ofertas mesmo em locais com baixa ou nenhuma conectividade.
*   **Dashboard de Impacto**: Visualização de métricas que mostram a quantidade de alimentos salvos e a economia gerada, engajando os usuários.
*   **Acessibilidade (A11y)**: Inclui um modo de alto contraste para garantir a usabilidade sob a luz solar intensa das feiras.

---

## 🚀 Status do Projeto

*Última atualização: 30 de maio de 2026*

| Módulo | Funcionalidade Principal | Status |
| :--- | :--- | :--- |
| **Gestão de Ofertas** | CRUD completo para Feirantes | ✅ **Concluído e Funcional** |
| **Gestão de Usuários** | Cadastro e Autenticação | ⏳ Em Andamento |
| **Gestão de Reservas**| Sistema de Reservas para Consumidores | 📋 Planejado |
| **PWA & Offline** | Implementação do Service Worker | 📋 Planejado |

---

## 🛠️ Pilha de Tecnologia (Tech Stack)

O projeto foi construído com uma filosofia de **portabilidade, resiliência e acessibilidade**.

*   **Backend**: API RESTful em **PHP 8+ (puro)**, seguindo uma arquitetura orientada a objetos, sem dependência de frameworks pesados.
*   **Frontend**: **HTML5**, **CSS3** e **Vanilla JavaScript**.
*   **UI Framework**: **Bootstrap 5** para uma interface responsiva e mobile-first.
*   **Banco de Dados**: **MariaDB** para persistência de dados no servidor e **LocalStorage** para dados offline no cliente.
*   **PWA**: Implementação com **Service Worker** para caching e funcionamento offline.
*   **Visualização de Dados**: **Chart.js** para o Dashboard de Impacto.

---

## 📚 Documentação de Engenharia

Toda a concepção arquitetural e os requisitos do projeto estão documentados na pasta `/docs`. Estes artefatos são a base para o desenvolvimento e a manutenção do sistema.

*   **[📄 Documentação de Requisitos](docs/Requisitos.md)**: Visão geral, objetivos, requisitos funcionais e não funcionais, e arquitetura da aplicação.
*   **[🎭 Casos de Uso (Use Cases)](docs/UseCases.md)**: Especificação detalhada de todas as interações do usuário com o sistema, incluindo diagramas e fluxos de exceção.
*   **[🔄 Histórico de Mudanças (Changelog)](CHANGELOG.md)**: Registro cronológico de todas as implementações e melhorias.

---

*Projeto desenvolvido para a disciplina de Projeto Extensionista Integrador. Todos os direitos reservados.*
