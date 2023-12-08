<?php
session_start();

// Verifica se existe um parâmetro 'session_to_destroy' na URL
if (isset($_GET['session_to_destroy'])) {
    // Obtém o valor do parâmetro
    $sessionToDestroy = $_GET['session_to_destroy'];

    // Destroi a sessão específica
    unset($_SESSION[$sessionToDestroy]);

    // Opcional: Destroi todas as sessões caso necessário
    // session_destroy();
}

// Redireciona o usuário para a página inicial
header("Location: ../index.html");
?>
