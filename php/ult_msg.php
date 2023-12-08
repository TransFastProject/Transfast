<?php
include("bd_conect.php");
session_start();

$sql = $pdo->query("SELECT * FROM chat ORDER BY chat_id DESC LIMIT 1");

$ultimaMensagem = "";
foreach ($sql->fetchAll() as $key) {
    $mensagemCompleta = $key['mensagem'];

    if (strlen($mensagemCompleta) > 18) {
    $ultimaMensagem = substr($mensagemCompleta, 0, 18) . '<strong>...</strong>';
    } else {
        $ultimaMensagem = $mensagemCompleta;
    }
}

echo $ultimaMensagem;
?>
