<?php
$btnCadRes = filter_input(INPUT_POST, 'btnCad', FILTER_DEFAULT);
if ($btnCadRes) {
  include_once 'conexao.php';
  session_start();
  $dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  $erro = false;

  $dados_st = array_map('strip_tags', $dados_rc);
  $dados = array_map('trim', $dados_st);
  $_SESSION['res_cpf'] = $dados['cpf'];

  if (in_array('', $dados)) {
    $erro = true;
  } elseif ((strlen($dados['senha'])) < 6) {
    $erro = true;
  } elseif (stristr($dados['senha'], "&")) {
    $erro = true;

  } else {
    $result_responsavel = "SELECT res_cpf FROM responsavel WHERE res_cpf='" . $dados['cpf'] . "'";
    $resultado_responsavel = mysqli_query($sql, $result_responsavel);
    if (($resultado_responsavel) and ($resultado_responsavel->num_rows != 0)) {
      $erro = true;
      header("Location: ../php/cadastro_responsavel.php");
    }

    $result_responsavel = "SELECT res_cpf FROM responsavel WHERE email='" . $dados['email'] . "'";
    $resultado_responsavel = mysqli_query($sql, $result_responsavel);
    if (($resultado_responsavel) and ($resultado_responsavel->num_rows != 0)) {
      $erro = true;
      header("Location: ../php/cadastro_responsavel.php");
    }
  }
  if (!$erro) {
    $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
    $_SESSION['res_cpf'] = $dados['cpf'];
    $_SESSION['nome'] = $dados['nome'];
    $_SESSION['email'] = $dados['email'];
    $_SESSION['senha'] = $dados['senha'];
    $_SESSION['genero'] = $dados['genero'];
    $_SESSION['telefone'] = $dados['telefone'];
    $_SESSION['dtnascimento'] = $dados['dtnascimento'];

    $result_responsavel = "INSERT INTO responsavel (res_cpf, nome, email, senha, genero, telefone, data_nascimento) VALUES (
          '" . $_SESSION['res_cpf'] . "',
          '" . $_SESSION['nome'] . "',
          '" . $_SESSION['email'] . "',
          '" . $_SESSION['senha'] . "',
          '" . $_SESSION['genero'] . "',
          '" . $_SESSION['telefone'] . "',
          '" . $_SESSION['dtnascimento'] . "'
      )";
    
    $resultado_responsavel = mysqli_query($sql, $result_responsavel);
    
    if ($resultado_responsavel && mysqli_affected_rows($sql) > 0) {
      header("Location:../php/cadastro_endereco_responsavel.php");
      exit();
    } else {
      $_SESSION['msg'] = "Erro ao cadastrar o usuário: " . mysqli_error($sql);
    }
  }
}
?>