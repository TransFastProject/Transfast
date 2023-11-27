<?php
include_once "conexao.php";
session_start();

if (!isset($_SESSION["res_cpf"])) {
    header("Location: login_responsavel.php");
    exit();
}

if (isset($_POST['submit'])) {
    // Recupera os dados do formulário
    $id_crianca = $_POST['id'];
    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $escola = $_POST['escola'];
    $data_nascimento = $_POST['data_nascimento'];
    $deficiencia = $_POST['deficiencia'];

    // Validação dos dados (adapte conforme necessário)
    // ...

    // Atualiza as informações da criança no banco de dados
    $stmt = mysqli_prepare($sql, "UPDATE crianca SET nome=?, genero=?, escola=?, data_nascimento=?, deficiencia=? WHERE cria_id=? AND res_cpf=?");
    
    // Verifica se a preparação da declaração foi bem-sucedida
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . mysqli_error($sql));
    }

    // Bind dos parâmetros
    mysqli_stmt_bind_param($stmt, "sssssds", $nome, $genero, $escola, $data_nascimento, $deficiencia, $id_crianca, $_SESSION['res_cpf']);

    // Executa a declaração
    if (mysqli_stmt_execute($stmt)) {
        // Sucesso
        header("Location: perfilCrianca.php?id=" . $id_crianca);
        exit();
    } else {
        // Erro
        die("Erro na atualização: " . mysqli_error($sql));
    }
}

// Restante do código...
?>
