<?php
include_once "conexao.php";
session_start();

if (!isset($_SESSION["res_cpf"])) {
    header("Location: login_responsavel.php");
    exit();
}

if (isset($_POST['submit'])) {
    // Inicializa as variáveis para a foto de perfil
    $caminhoDestino = null;

    // Processar a nova foto de perfil, se fornecida
    if ($_FILES['novaFotoPerfil']['error'] == UPLOAD_ERR_OK) {
        $nomeArquivo = $_FILES['novaFotoPerfil']['name'];
        $caminhoTemporario = $_FILES['novaFotoPerfil']['tmp_name'];
        $caminhoDestino = '../img_usuarios/' . $nomeArquivo; // Especifique o caminho onde deseja salvar o arquivo

        // Move o arquivo para o destino
        move_uploaded_file($caminhoTemporario, $caminhoDestino);
    }

    // Atualiza o caminho da foto de perfil no banco de dados, se fornecido
    if ($caminhoDestino !== null) {
        $sqlUpdateFoto = "UPDATE responsavel SET foto = ? WHERE res_cpf = ?";
        $stmtUpdateFoto = $sql->prepare($sqlUpdateFoto);
        $stmtUpdateFoto->bind_param("ss", $caminhoDestino, $_SESSION['res_cpf']);
        if (!$stmtUpdateFoto->execute()) {
            die('Erro ao atualizar a foto de perfil: ' . $stmtUpdateFoto->error);
        }
        $stmtUpdateFoto->close();
    }

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

    // Atualiza as informações do responsável no banco de dados
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
