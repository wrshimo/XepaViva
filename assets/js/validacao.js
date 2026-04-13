/**
 * XepaViva - Módulo de Validação de Formulários
 * Fornece feedback visual em tempo real
 */

class ValidadorFormulario {
  constructor(selectorForm = 'form') {
    this.forms = document.querySelectorAll(selectorForm);
    this.init();
  }

  init() {
    this.forms.forEach(form => {
      this.configurarForm(form);
    });
  }

  /**
   * Configura listeners de validação para um formulário
   */
  configurarForm(form) {
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
      // Validar ao sair do campo (blur)
      input.addEventListener('blur', () => this.validarCampo(input));
      
      // Limpar erro ao digitar novamente
      input.addEventListener('input', () => {
        if (input.classList.contains('is-invalid')) {
          input.classList.remove('is-invalid');
          this.removerMensagemErro(input);
        }
      });
    });

    // Validar ao submeter
    form.addEventListener('submit', (e) => {
      if (!this.validarForm(form)) {
        e.preventDefault();
      }
    });
  }

  /**
   * Valida um campo individual
   */
  validarCampo(input) {
    let mensagem = '';

    if (input.hasAttribute('required') && !input.value.trim()) {
      mensagem = 'Este campo é obrigatório';
    } else if (input.type === 'email' && input.value && !this.isValidEmail(input.value)) {
      mensagem = 'Email inválido';
    } else if (input.name === 'preco' && input.value && input.value < 0) {
      mensagem = 'Preço não pode ser negativo';
    } else if (input.name === 'peso' && input.value && input.value <= 0) {
      mensagem = 'Peso deve ser maior que zero';
    }

    if (mensagem) {
      this.mostrarErro(input, mensagem);
      return false;
    } else {
      this.mostrarSucesso(input);
      return true;
    }
  }

  /**
   * Valida todos os campos do formulário
   */
  validarForm(form) {
    const inputs = form.querySelectorAll('[required]');
    let valido = true;

    inputs.forEach(input => {
      if (!this.validarCampo(input)) {
        valido = false;
      }
    });

    return valido;
  }

  /**
   * Mostra erro em um campo
   */
  mostrarErro(input, mensagem) {
    input.classList.remove('is-valid');
    input.classList.add('is-invalid');
    
    this.removerMensagemErro(input);
    
    const feedback = document.createElement('div');
    feedback.className = 'invalid-feedback d-block';
    feedback.textContent = mensagem;
    feedback.setAttribute('aria-live', 'polite');
    
    input.parentElement.insertBefore(feedback, input.nextSibling);
  }

  /**
   * Mostra sucesso em um campo
   */
  mostrarSucesso(input) {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    this.removerMensagemErro(input);
  }

  /**
   * Remove mensagens de erro/sucesso
   */
  removerMensagemErro(input) {
    const feedback = input.nextElementSibling;
    if (feedback && (feedback.classList.contains('invalid-feedback') || 
                     feedback.classList.contains('valid-feedback'))) {
      feedback.remove();
    }
  }

  /**
   * Valida formato de email
   */
  isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  }
}

// Inicializar validação ao carregar DOM
document.addEventListener('DOMContentLoaded', () => {
  new ValidadorFormulario();
});
