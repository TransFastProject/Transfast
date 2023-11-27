<?php
include_once "conexao.php";
session_start();

// Verifica se o responsável está logado
if (!isset($_SESSION["res_cpf"])) {
    header("Location: ../html/login.html"); // Redireciona para a página de login do responsável se não estiver logado
    exit();
}

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Recupera os dados do formulário
    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $escola = $_POST['escola'];
    $data_nascimento = $_POST['data_nascimento'];
    $deficiencia = $_POST['deficiencia'];

    // Insere a nova criança no banco de dados
    $stmt = mysqli_prepare($sql, "INSERT INTO crianca (res_cpf, nome, genero, escola, data_nascimento, deficiencia) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssss", $_SESSION['res_cpf'], $nome, $genero, $escola, $data_nascimento, $deficiencia);
    mysqli_stmt_execute($stmt);

    // Redireciona de volta à página principal do responsável
    header("Location: perfilCriancaSelecionar.php");
    exit();
}
?>