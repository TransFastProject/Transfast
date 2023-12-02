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

    // Inicializa as variáveis para a foto de perfil
    $caminhoDestino = null;

    // Processar a nova foto de perfil, se fornecida
    if ($_FILES['novaFotoPerfil']['error'] == UPLOAD_ERR_OK) {
        $nomeArquivo = $_FILES['novaFotoPerfil']['name'];
        $caminhoTemporario = $_FILES['novaFotoPerfil']['tmp_name'];
        $caminhoDestino = '../img_usuarios/' . $nomeArquivo; // Especifique o caminho onde deseja salvar o arquivo

        // Move o arquivo para o destino
        if (!move_uploaded_file($caminhoTemporario, $caminhoDestino)) {
            die('Erro ao mover o arquivo para o destino.');
        }
    }

    // Insere a nova criança no banco de dados
    $sqlInsertCrianca = "INSERT INTO crianca (res_cpf, nome, genero, escola, data_nascimento, deficiencia, foto) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtInsertCrianca = $sql->prepare($sqlInsertCrianca);
    $stmtInsertCrianca->bind_param("sssssss", $_SESSION['res_cpf'], $nome, $genero, $escola, $data_nascimento, $deficiencia, $caminhoDestino);
    
    if (!$stmtInsertCrianca->execute()) {
        die('Erro ao inserir a nova criança: ' . $stmtInsertCrianca->error);
    }
    
    $stmtInsertCrianca->close();

    // Redireciona de volta à página principal do responsável
    header("Location: perfilCriancaSelecionar.php");
    exit();
}
?>
