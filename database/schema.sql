-- Arquivo de esquema para o banco de dados do projeto XepaViva
-- Define a estrutura do banco de dados e as tabelas necessárias.

-- Criação do banco de dados com codificação recomendada
CREATE DATABASE IF NOT EXISTS `xepaviva` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Seleciona o banco de dados para uso
USE `xepaviva`;

--
-- Estrutura da tabela `usuarios`
--
-- Esta tabela armazena informações sobre os usuários da plataforma,
-- consolidando dados de feirantes e consumidores.
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL COMMENT 'Senha com hash usando bcrypt',
  `cpf_cnpj` VARCHAR(20) NULL,
  `tipo` ENUM('Feirante', 'Consumidor') NOT NULL,
  `localidade` VARCHAR(255) NULL,
  `data_cadastro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) COMMENT='Tabela consolidada de usuários (Feirantes e Consumidores)';

--
-- Inserção de dados iniciais na tabela `usuarios`
--
-- Senha inicial para todos os usuários: 'xepaviva'
-- Hash (bcrypt): $2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW
--

-- Inserindo Feirantes
INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `cpf_cnpj`, `tipo`, `localidade`) VALUES
(1, 'Seu Benedito', 'benedito@feira.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', '123.456.789-00', 'Feirante', 'Feira do Porto, Cuiabá - MT'),
(2, 'Dona Maria', 'maria@feira.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', '987.654.321-00', 'Feirante', 'Feira de Pinheiros'),
(3, 'Família Tanaka', 'tanaka@feira.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', '111.222.333-44', 'Feirante', 'Feira da Liberdade');

-- Inserindo Consumidores
INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`) VALUES
(4, 'Mariana Silva', 'mariana@email.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', 'Consumidor'),
(5, 'João Santos', 'joao@email.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', 'Consumidor');


--
-- Estrutura da tabela `ofertas`
--
-- Armazena as ofertas de 'xepa' anunciadas pelos feirantes.
--

CREATE TABLE IF NOT EXISTS `ofertas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `feirante_id` INT NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT NULL,
  `foto` VARCHAR(255) NULL,
  `preco` DECIMAL(10, 2) NOT NULL,
  `quantidade_inicial` INT NOT NULL,
  `quantidade_disponivel` INT NOT NULL,
  `disponivel` BOOLEAN NOT NULL DEFAULT TRUE,
  `categoria` VARCHAR(100) NULL,
  `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `data_modificacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`feirante_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) COMMENT='Tabela de ofertas de produtos dos feirantes';

--
-- Inserção de dados iniciais na tabela `ofertas`
--

INSERT INTO `ofertas` (`id`, `feirante_id`, `nome`, `descricao`, `foto`, `preco`, `quantidade_inicial`, `quantidade_disponivel`, `disponivel`, `categoria`) VALUES
(1, 1, 'Kit Tomate Italiano (1kg)', 'Tomates italianos maduros, perfeitos para molhos e saladas. Cultivados com carinho e sem agrotóxicos.', 'https://placehold.co/300x200/198754/FFFFFF?text=Tomate+Italiano', 5.00, 20, 15, TRUE, 'Legumes'),
(2, 2, 'Cesta de Bananas Nanica', 'Bananas nanicas docinhas, ótimas para vitaminas ou para comer ao natural.', 'https://placehold.co/300x200/FFD700/FFFFFF?text=Banana+Nanica', 4.50, 30, 30, TRUE, 'Frutas'),
(3, 1, 'Pé de Alface Crespa', 'Alface crespa fresquinha, colhida hoje de manhã. Crocante e saborosa.', 'https://placehold.co/300x200/228B22/FFFFFF?text=Alface+Crespa', 2.00, 50, 25, TRUE, 'Verduras'),
(4, 3, 'Mix de Legumes Orientais', 'Um mix especial com acelga, nabo e moyashi para suas receitas orientais.', 'https://placehold.co/300x200/8B4513/FFFFFF?text=Legumes+Orientais', 8.00, 15, 10, FALSE, 'Legumes'),
(5, 2, 'Saco de Laranjas Pêra (2kg)', 'Laranjas doces e suculentas, perfeitas para suco ou consumo in natura.', 'https://placehold.co/300x200/FF4500/FFFFFF?text=Laranja+Pera', 6.00, 25, 0, TRUE, 'Frutas');

--
-- Estrutura da tabela `reservas`
--
-- Registra as reservas de ofertas feitas pelos consumidores.
--

CREATE TABLE IF NOT EXISTS `reservas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `consumidor_id` INT NOT NULL,
  `oferta_id` INT NOT NULL,
  `preco` DECIMAL(10, 2) NOT NULL COMMENT 'Preço da oferta no momento da reserva',
  `peso` DECIMAL(10, 3) NULL COMMENT 'Peso aproximado do kit em kg',
  `status` ENUM(
    'Pendente',
    'Confirmada',
    'Aguardando Retirada',
    'Concluida',
    'Cancelada pelo Consumidor',
    'Cancelada pelo Feirante',
    'Nao Compareceu',
    'Expirada'
  ) NOT NULL DEFAULT 'Pendente' COMMENT 'Ciclo de vida da reserva',
  `codigo_retirada` VARCHAR(10) NOT NULL COMMENT 'Código para retirada (formato XV-XXXX)',
  `data_reserva` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `data_retirada_prevista` DATETIME NULL,
  `data_retirada_efetiva` DATETIME NULL,
  FOREIGN KEY (`consumidor_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`oferta_id`) REFERENCES `ofertas`(`id`) ON DELETE CASCADE
) COMMENT='Tabela de reservas de ofertas';

--
-- Inserção de dados de exemplo na tabela `reservas`
-- (Usando códigos de retirada aleatórios para simular um ambiente real)
--

INSERT INTO `reservas` (`consumidor_id`, `oferta_id`, `preco`, `peso`, `status`, `codigo_retirada`) VALUES
(4, 1, 5.00, 1.0, 'Pendente', 'XV-8532'),
(4, 3, 2.00, 0.5, 'Confirmada', 'XV-1590'),
(5, 2, 4.50, 2.0, 'Aguardando Retirada', 'XV-0482'),
(5, 4, 8.00, 1.5, 'Concluida', 'XV-9217'),
(4, 5, 6.00, 2.0, 'Cancelada pelo Consumidor', 'XV-3368'),
(5, 1, 5.00, 1.0, 'Cancelada pelo Feirante', 'XV-7814'),
(4, 2, 4.50, 2.0, 'Nao Compareceu', 'XV-5006'),
(5, 3, 2.00, 0.5, 'Expirada', 'XV-2193');
