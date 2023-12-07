<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['conf_cpf'];
    $novaSenha = $_POST['nova_senha'];
    $confirmaSenha = $_POST['confirma_senha'];

    if ($novaSenha === $confirmaSenha) {
        // Verifique o CPF no banco de dados
        $query = "SELECT * FROM motorista WHERE moto_cpf = '$cpf'";
        $result = $sql->query($query);
        if ($result->num_rows > 0) {
            // CPF válido, realizar a alteração de senha
            $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT); // Criptografa a nova senha

            $query = "UPDATE motorista SET senha = '$senhaHash' WHERE moto_cpf = '$cpf'";
            if ($sql->query($query)) {
                header("Location: ../html/agradecimento_senha.html");
            } else {
                echo "Erro ao atualizar a senha: " . $sql->error;
            }
        } else {
            echo "CPF inválido. Por favor, tente novamente.";
        }
    } else {
        echo "As senhas não coincidem. Por favor, tente novamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/redef_senha.css" />
    <link rel="stylesheet" href="../css/estilo.css" />
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Alterar Senha</title>
</head>

<body>

<div style="display: flex;">

<div class="forms_redef_senha">
    <div>
        <h1>Redefinir Senha</h1>
        <form method="post" action="alt_senha.php">
            <label for="conf_cpf"><b>Confirme o CPF:</b></label><br>
            <input type="text" id="conf_cpf" name="conf_cpf" required>
            <br><br>
            <label for="nova_senha"><b>Nova Senha:</b></label><br>
            <input type="password" id="nova_senha" name="nova_senha" required>
            <br><br>
            <label for="confirma_senha"><b>Confirme a Nova Senha:</b></label><br>
            <input type="password" id="confirma_senha" name="confirma_senha" required>
            <br><br>
            <input type="submit" value="Enviar">
        </form>
    </div>
</div>
<div class="forms_redef_senha" class="logo_redef_senha">
    <img src="../img/logo_v2.png" alt="">
</div>

</div>

</body>

</html>