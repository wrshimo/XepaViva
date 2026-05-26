-- Arquivo de esquema para o banco de dados do projeto XepaViva
-- Define a estrutura do banco de dados e as tabelas necessárias.

-- Criação do banco de dados com codificação recomendada
CREATE DATABASE IF NOT EXISTS `xepaviva` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Seleciona o banco de dados para uso
USE `xepaviva`;

--
-- Estrutura da tabela `usuarios`
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
-- Estrutura da tabela `ofertas` (com coluna `peso` integrada)
--
CREATE TABLE IF NOT EXISTS `ofertas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `feirante_id` INT NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT NULL,
  `foto` VARCHAR(255) NULL,
  `preco` DECIMAL(10, 2) NOT NULL,
  `peso` DECIMAL(10, 3) NULL COMMENT 'Peso do kit em kg, conforme definido pelo feirante',
  `quantidade_inicial` INT NOT NULL,
  `quantidade_disponivel` INT NOT NULL,
  `disponivel` BOOLEAN NOT NULL DEFAULT TRUE,
  `categoria` VARCHAR(100) NULL,
  `data_criacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `data_modificacao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`feirante_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) COMMENT='Tabela de ofertas de produtos dos feirantes';

--
-- Estrutura da tabela `reservas` (com `quantidade_reservada`)
--
CREATE TABLE IF NOT EXISTS `reservas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `consumidor_id` INT NOT NULL,
  `oferta_id` INT NOT NULL,
  `quantidade_reservada` INT NOT NULL DEFAULT 1 COMMENT 'Numero de unidades/kits da oferta que foram reservados.',
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

-- Inserção de dados de exemplo (Truncando tabelas para garantir um estado limpo)
-- TRUNCATE TABLE `reservas`;
-- TRUNCATE TABLE `ofertas`;
-- TRUNCATE TABLE `usuarios`;

-- Inserindo Feirantes
INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `cpf_cnpj`, `tipo`, `localidade`) VALUES
(1, 'Seu Benedito', 'benedito@feira.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', '123.456.789-00', 'Feirante', 'Feira do Porto, Cuiabá - MT'),
(2, 'Dona Maria', 'maria@feira.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', '987.654.321-00', 'Feirante', 'Feira de Pinheiros'),
(3, 'Família Tanaka', 'tanaka@feira.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', '111.222.333-44', 'Feirante', 'Feira da Liberdade');

-- Inserindo Consumidores
INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`) VALUES
(4, 'Mariana Silva', 'mariana@email.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', 'Consumidor'),
(5, 'João Santos', 'joao@email.com', '$2y$10$KPRqt2v3vM3yXy.qCvL5V.GkTBZV0//.AR8Li5PqiePe1B.7w/khW', 'Consumidor');

-- Inserindo Ofertas
INSERT INTO `ofertas` (`id`, `feirante_id`, `nome`, `descricao`, `foto`, `preco`, `peso`, `quantidade_inicial`, `quantidade_disponivel`, `disponivel`, `categoria`) VALUES
(1, 1, 'Kit Tomate Italiano (1kg)', 'Tomates italianos maduros, perfeitos para molhos e saladas. Cultivados com carinho e sem agrotóxicos.', 'https://placehold.co/300x200/198754/FFFFFF?text=Tomate+Italiano', 5.00, 1.000, 20, 15, TRUE, 'Legumes'),
(2, 2, 'Cesta de Bananas Nanica', 'Bananas nanicas docinhas, ótimas para vitaminas ou para comer ao natural.', 'https://placehold.co/300x200/FFD700/FFFFFF?text=Banana+Nanica', 4.50, 1.500, 30, 30, TRUE, 'Frutas'),
(3, 1, 'Pé de Alface Crespa', 'Alface crespa fresquinha, colhida hoje de manhã. Crocante e saborosa.', 'https://placehold.co/300x200/228B22/FFFFFF?text=Alface+Crespa', 2.00, 0.500, 50, 25, TRUE, 'Verduras'),
(4, 3, 'Mix de Legumes Orientais', 'Um mix especial com acelga, nabo e moyashi para suas receitas orientais.', 'https://placehold.co/300x200/8B4513/FFFFFF?text=Legumes+Orientais', 8.00, 1.200, 15, 10, FALSE, 'Legumes'),
(5, 2, 'Saco de Laranjas Pêra (2kg)', 'Laranjas doces e suculentas, perfeitas para suco ou consumo in natura.', 'https://placehold.co/300x200/FF4500/FFFFFF?text=Laranja+Pera', 6.00, 2.000, 25, 0, TRUE, 'Frutas');

-- Inserindo Reservas (com `quantidade_reservada`)
INSERT INTO `reservas` (`consumidor_id`, `oferta_id`, `quantidade_reservada`, `preco`, `peso`, `status`, `codigo_retirada`) VALUES
(4, 1, 1, 5.00, 1.0, 'Pendente', 'XV-8532'),
(4, 3, 2, 2.00, 0.5, 'Confirmada', 'XV-1590'),
(5, 2, 1, 4.50, 2.0, 'Aguardando Retirada', 'XV-0482'),
(5, 4, 3, 8.00, 1.5, 'Concluida', 'XV-9217'),
(4, 5, 1, 6.00, 2.0, 'Cancelada pelo Consumidor', 'XV-3368'),
(5, 1, 1, 5.00, 1.0, 'Cancelada pelo Feirante', 'XV-7814'),
(4, 2, 4, 4.50, 2.0, 'Nao Compareceu', 'XV-5006'),
(5, 3, 1, 2.00, 0.5, 'Expirada', 'XV-2193');
