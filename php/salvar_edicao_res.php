<?php
include_once "conexao.php";
session_start();

if (!isset($_SESSION["res_cpf"])) {
    header("Location: login_responsavel.php");
    exit();
}

if (isset($_POST['submit'])) {
    // Recupera os dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $genero = $_POST["genero"];
    $rua = $_POST["rua"];
    $telefone = $_POST["telefone"];
    $nasc = $_POST["data_nascimento"];
    $cep = $_POST["cep"];
    $bairro = $_POST["bairro"];
    $numero = $_POST["numero"];
    $complemento = $_POST["complemento"];

    // Validação dos dados (adapte conforme necessário)
    // ...

    // Atualiza as informações da criança no banco de dados
    $stmt = mysqli_prepare($sql, "UPDATE responsavel SET nome=?, email=?, genero=?, rua=?, telefone=?, data_nascimento=?, cep=?, bairro=?, numero=?, complemento=? WHERE res_cpf=?");
    
    // Verifica se a preparação da declaração foi bem-sucedida
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . mysqli_error($sql));
    }

    // Bind dos parâmetros
    mysqli_stmt_bind_param($stmt, "sssssssssss", $nome, $email, $genero, $rua, $telefone, $nasc, $cep, $bairro, $numero, $complemento, $_SESSION["res_cpf"]);

    // Executa a declaração
    if (mysqli_stmt_execute($stmt)) {
        // Sucesso
        header("Location: perfilResponsavel.php");
        exit();
    } else {
        // Erro
        die("Erro na atualização: " . mysqli_error($sql));
    }
}

// Restante do código...
?>
