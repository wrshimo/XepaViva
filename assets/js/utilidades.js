/**
 * XepaViva - Módulo de Utilitários
 * Funções globais reutilizáveis
 */

class Utilidades {
  /**
   * Carrega dados de arquivo JSON
   */
  static async carregarJSON(arquivo) {
    try {
      const response = await fetch(`/data/${arquivo}`);
      if (!response.ok) {
        throw new Error(`Erro ao carregar ${arquivo}`);
      }
      return await response.json();
    } catch (erro) {
      console.error(erro);
      return null;
    }
  }

  /**
   * Formata moeda BRL
   */
  static formatarMoeda(valor) {
    return new Intl.NumberFormat('pt-BR', {
      style: 'currency',
      currency: 'BRL'
    }).format(valor);
  }

  /**
   * Formata data em português
   */
  static formatarData(data) {
    return new Intl.DateTimeFormat('pt-BR', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    }).format(new Date(data));
  }

  /**
   * Gera UUID v4 (para sincronização offline)
   */
  static gerarUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      const r = Math.random() * 16 | 0;
      const v = c === 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
  }

  /**
   * Recupera sessão do usuário do LocalStorage
   */
  static obterUsuarioSessao() {
    const usuario = localStorage.getItem('usuario_sessao');
    return usuario ? JSON.parse(usuario) : null;
  }

  /**
   * Salva sessão do usuário no LocalStorage
   */
  static salvarUsuarioSessao(usuario) {
    localStorage.setItem('usuario_sessao', JSON.stringify(usuario));
  }

  /**
   * Limpa sessão do usuário
   */
  static limparSessao() {
    localStorage.removeItem('usuario_sessao');
  }
}

// Exportar para uso global
window.Util = Utilidades;
