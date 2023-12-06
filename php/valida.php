<?php
include_once("conexao.php");
session_start();
$acessar = filter_input(INPUT_POST, 'acessar', FILTER_DEFAULT);

if ($acessar) {
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_DEFAULT);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    if ((!empty($cpf)) and (!empty($senha))) {
        $result_motorista = $sql->query("SELECT * FROM motorista WHERE moto_cpf= '$cpf' LIMIT 1");
        $result_transporte = $sql ->query("SELECT * FROM transporte WHERE moto_cpf ='$cpf' LIMIT 1");

        if($cpf=="inexistente" && $senha=="admin10062022"){
            header("Location: ../php/admin_listagem.php");
        }
        else if ($result_motorista->num_rows > 0) {
            $row_usuario = mysqli_fetch_assoc($result_motorista);
            $row_transporte = mysqli_fetch_assoc($result_transporte);

            if (password_verify($senha, $row_usuario['senha'])) {
                $_SESSION['moto_cpf'] = $row_usuario['moto_cpf'];
                $_SESSION['nome'] = $row_usuario['nome'];
                $_SESSION['email'] = $row_usuario['email'];
                $_SESSION['genero'] = $row_usuario['genero'];
                $_SESSION['telefone'] = $row_usuario['telefone'];
                $_SESSION['dtnascimento'] = $row_usuario['data_nascimento'];
                $_SESSION['cep'] = $row_usuario['cep'];
                $_SESSION['rua'] = $row_usuario['rua'];
                $_SESSION['bairro'] = $row_usuario['bairro'];
                $_SESSION['numero'] = $row_usuario['numero'];
                $_SESSION['complemento'] = $row_usuario['complemento'];

                $_SESSION['trans_id'] = $row_transporte['trans_id'];
                $_SESSION['nome_transporte'] = $row_transporte['nome'];
                $_SESSION['monitor'] = $row_transporte['monitor'];
                $_SESSION['placa'] = $row_transporte['placa'];
                $_SESSION['n_assentos'] = $row_transporte['n_assentos'];
                $_SESSION['estado_transporte'] = $row_transporte['estado'];
                $_SESSION['cidade_transporte'] = $row_transporte['cidade'];
                $_SESSION['cep_transporte'] = $row_transporte['cep'];
                $_SESSION['bairro_transporte'] = $row_transporte['bairro'];
                $_SESSION['codigo'] = $row_transporte['codigo'];
                header("Location: ../php/gere_inicio.php");
                exit();
            }else{
                $_SESSION['msg'] = "<texto>Senha Incorreta </texto>";
                header("Location: ../html/login.html");
                exit();
            }
        }else{

            $result_responsavel = $sql->query("SELECT * FROM responsavel WHERE res_cpf = '$cpf' LIMIT 1");

            if ($result_responsavel->num_rows > 0) {
                $row_usuario = mysqli_fetch_assoc($result_responsavel);

                if (password_verify($senha, $row_usuario['senha'])) {
                    $_SESSION['res_cpf'] = $row_usuario['res_cpf'];
                    $_SESSION['nome'] = $row_usuario['nome'];
                    $_SESSION['email'] = $row_usuario['email'];
                    $_SESSION['genero'] = $row_usuario['genero'];
                    $_SESSION['telefone'] = $row_usuario['telefone'];
                    $_SESSION['dtnascimento'] = $row_usuario['data_nascimento'];
                    $_SESSION['cep'] = $row_usuario['cep'];
                    $_SESSION['rua'] = $row_usuario['rua'];
                    $_SESSION['bairro'] = $row_usuario['bairro'];
                    $_SESSION['numero'] = $row_usuario['numero'];
                    $_SESSION['complemento'] = $row_usuario['complemento'];
                    header('Location: ../php/home_responsavel.php');
                    exit();
                }else{
                    $_SESSION['msg'] = "<texto>Senha Incorreta </texto>";
                header("Location: ../html/login.html");
                exit();
                }
    } else {
        $_SESSION['msg'] = "<texto>CPF não encontrado</texto>";
        header("Location: ../html/login.html");
        exit();
    }
        }
}else{
    $_SESSION['msg'] = "<texto>CPF ou senha não foram preenchidos</texto>";
    header("Location: ../html/login.html");
    exit();
}
}else {
    $_SESSION['msg'] = "<texto>Página não encontrada</texto>";
    header("Location: ../html/login.html");
}
?>