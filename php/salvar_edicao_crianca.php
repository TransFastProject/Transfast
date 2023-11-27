<?php
include_once "conexao.php";
session_start();

if (isset($_POST['submit'])) {
    // Recupera os dados do formulário
    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $escola = $_POST['escola'];
    $responsavel = $_POST['responsavel'];
    $data_nascimento = $_POST['data_nascimento'];
    $deficiencia = $_POST['deficiencia'];

    // Atualiza as informações da criança no banco de dados
    $stmt = mysqli_prepare($sql, "UPDATE crianca SET nome=?, genero=?, escola=?, data_nascimento=?, deficiencia=? WHERE responsavel_cpf=?");
    mysqli_stmt_bind_param($stmt, "ssssss", $nome, $genero, $escola, $data_nascimento, $deficiencia, $_SESSION['res_cpf']);
    mysqli_stmt_execute($stmt);

    // Redireciona de volta à página de edição da criança
    header("Location: perfilCrianca.php");
    exit();
}
?>
