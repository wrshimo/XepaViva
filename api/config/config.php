<?php
// api/config/config.php

/**
 * Arquivo de configuração para o banco de dados.
 * 
 * Para um ambiente de produção real, as credenciais devem ser
 * gerenciadas de forma mais segura, como através de variáveis de ambiente,
 * e este arquivo não deve ser versionado.
 */

define('DB_HOST', '127.0.0.1');       // Host do banco de dados (geralmente localhost)
define('DB_NAME', 'xepaviva');        // Nome do banco de dados
define('DB_USER', 'root');            // Usuário do banco de dados
define('DB_PASS', '');              // Senha do banco de dados
define('DB_CHARSET', 'utf8mb4');         // Charset da conexão

?>
