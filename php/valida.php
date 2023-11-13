<?php
include_once("conexao.php");
session_start();
$acessar = filter_input(INPUT_POST, 'acessar', FILTER_DEFAULT);

if ($acessar) {
    $moto_cpf = filter_input(INPUT_POST, 'cpf', FILTER_DEFAULT);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);

    if ((!empty($moto_cpf)) and (!empty($senha))) {
        $result_usuario = "select moto_cpf, nome, email, senha, telefone, data_nascimento, cep, rua, bairro, numero, complemento from motorista where moto_cpf= '$moto_cpf' LIMIT 1";
        $resultado_usuario = mysqli_query($sql, $result_usuario);
        if ($resultado_usuario) {
            $row_usuario = mysqli_fetch_assoc($resultado_usuario);
            if (password_verify($senha, $row_usuario['senha'])) {
                $_SESSION['moto_cpf'] = $row_usuario['moto_cpf'];
                $_SESSION['nome'] = $row_usuario['nome'];
                $_SESSION['email'] = $row_usuario['email'];
                $_SESSION['telefone'] = $row_usuario['telefone'];
                $_SESSION['dtnascimento'] = $row_usuario['data_nascimento'];
                $_SESSION['cep'] = $row_usuario['cep'];
                $_SESSION['rua'] = $row_usuario['rua'];
                $_SESSION['bairro'] = $row_usuario['bairro'];
                $_SESSION['numero'] = $row_usuario['numero'];
                $_SESSION['complemento'] = $row_usuario['complemento'];
                header("Location: ../php/gere_inicio.php");

            } else {
                $_SESSION['msg'] = "<texto>SENHA INCORRETA </texto>";
                header("Location: ../html/login.html");
            }
        }
    } else {
        $_SESSION['msg'] = "<texto>CPF INCORRETO</texto>";
        header("Location: ../html/login.html");
    }
} else {
    $_SESSION['msg'] = "<texto>Página não encontrada</texto>";
    header("Location: ../html/login.html");
}
?>