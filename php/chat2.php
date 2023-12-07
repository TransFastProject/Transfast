<?php
include("bd_conect.php");
session_start();
// Consulta ao banco de dados para obter as mensagens
$sql = $pdo->query("SELECT * FROM chat WHERE moto_cpf='".$_SESSION['moto_cpf']."'");

// Exibir as mensagens do chat
foreach ($sql->fetchAll() as $key) {
    // Adicione estas linhas para depuração
    
    if (isset($key['tipo']) && $key['tipo'] === 'motorista') {
        echo '<div class="chat-right" style="width: 100%; display: flex; justify-content: end; align-items: center; border-radius: 0 2vw 2vw 0; justify-content: end; margin-bottom: 10px;">';
        echo '<div class="chat-right-item" style="max-width: 27vw; width: auto; padding: 10px; background-color: #1E184C; display: flex; justify-content: start; align-items: center; border-radius: 1vw; word-wrap: break-word;">';
        echo '<p style="margin: 0; font-size: 14px; overflow: hidden; ">' . $key['mensagem'] . '</p>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="chat-left" style="width: 100%; display: flex; justify-content: start; align-items: center; justify-content: start; margin-bottom: 10px;">';
        echo '<div class="chat-left-item" style="max-width: 27vw; width: auto; padding: 10px; background-color: #1E184C; display: flex; justify-content: start; align-items: center; border-radius: 1vw; word-wrap: break-word;">';
        echo '<p style="margin: 0; font-size: 14px; overflow: hidden;">' . $key['mensagem'] . '</p>';
        echo '</div>';
        echo '</div>';
    }
}
?>

