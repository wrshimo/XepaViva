<?php
// 1. Inicia ou resume a sessão existente.
session_start();

// 2. Limpa todas as variáveis da sessão.
// Isso remove todos os dados que armazenamos, como ID, nome e tipo do usuário.
$_SESSION = array();

// 3. Se a sessão usa cookies (padrão), destrói o cookie da sessão.
// Isso força o navegador a "esquecer" a sessão na próxima visita.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Finalmente, destrói a sessão no servidor.
// Isso invalida o ID da sessão e limpa os dados do lado do servidor.
session_destroy();

// 5. Redireciona o usuário para a página de login.
// O usuário agora está efetivamente desconectado.
header("Location: login.php");
exit();
?>