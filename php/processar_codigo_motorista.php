<?php
include_once "conexao.php";
session_start();

// Verifica se o responsável está logado
if (!isset($_SESSION["res_cpf"])) {
    header("Location: ../html/login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém o código do motorista do formulário
    $codigo_motorista = $_POST["codigo_motorista"];

    // Verifica se o código do motorista está correto (você precisa implementar essa lógica)
    $sql_verificar_codigo = "SELECT * FROM transporte WHERE codigo = ?";
    $stmt_verificar_codigo = mysqli_prepare($sql, $sql_verificar_codigo);
    mysqli_stmt_bind_param($stmt_verificar_codigo, "s", $codigo_motorista);
    mysqli_stmt_execute($stmt_verificar_codigo);
    $result_verificar_codigo = mysqli_stmt_get_result($stmt_verificar_codigo);

    if ($row_motorista = mysqli_fetch_assoc($result_verificar_codigo)) {
        // Código do motorista está correto
        $id_motorista = $row_motorista['trans_id'];  // substitua 'id' pelo nome correto do campo na tabela motorista

        // Atualiza o campo trans_id de todas as crianças do responsável
        $sql_atualizar_transporte = "UPDATE crianca SET trans_id = ? WHERE res_cpf = ?";
        $stmt_atualizar_transporte = mysqli_prepare($sql, $sql_atualizar_transporte);
        mysqli_stmt_bind_param($stmt_atualizar_transporte, "ss", $id_motorista, $_SESSION['res_cpf']);
        mysqli_stmt_execute($stmt_atualizar_transporte);

        // Redireciona o responsável para a página do motorista
        header("Location: pagina_do_motorista.php?id=$id_motorista");
        exit();
    } else {
        // Código do motorista incorreto
        echo "Código do motorista incorreto. Tente novamente.";
    }
}
?>
