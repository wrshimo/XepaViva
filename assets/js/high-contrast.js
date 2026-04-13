/**
 * XepaViva - Módulo de Alto Contraste
 * Gerencia o estado do modo de alto contraste via LocalStorage
 */

class AltoContrasteManager {
  constructor() {
    this.storageKey = 'highContrast';
    this.init();
  }

  /**
   * Inicializa o gerenciador de alto contraste
   */
  init() {
    // Aplicar estado salvo ao carregar página
    const highContrastEnabled = localStorage.getItem(this.storageKey) === 'true';
    if (highContrastEnabled) {
      this.ativar();
    }

    // Encontrar todos os botões de toggle
    const toggleButtons = document.querySelectorAll('#highContrastToggle');
    toggleButtons.forEach(btn => {
      btn.addEventListener('click', () => this.toggle());
    });
  }

  /**
   * Ativa o modo de alto contraste
   */
  ativar() {
    document.body.classList.add('high-contrast');
    localStorage.setItem(this.storageKey, 'true');
    this.atualizarBotoes();
  }

  /**
   * Desativa o modo de alto contraste
   */
  desativar() {
    document.body.classList.remove('high-contrast');
    localStorage.setItem(this.storageKey, 'false');
    this.atualizarBotoes();
  }

  /**
   * Alterna entre ativo/inativo
   */
  toggle() {
    if (document.body.classList.contains('high-contrast')) {
      this.desativar();
    } else {
      this.ativar();
    }
  }

  /**
   * Atualiza visual dos botões de toggle
   */
  atualizarBotoes() {
    const toggleButtons = document.querySelectorAll('#highContrastToggle');
    const ativo = document.body.classList.contains('high-contrast');
    
    toggleButtons.forEach(btn => {
      if (ativo) {
        btn.classList.add('active');
        btn.setAttribute('aria-pressed', 'true');
        btn.title = 'Desativar Alto Contraste';
      } else {
        btn.classList.remove('active');
        btn.setAttribute('aria-pressed', 'false');
        btn.title = 'Ativar Alto Contraste';
      }
    });
  }
}

// Inicializar assim que DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
  new AltoContrasteManager();
});
