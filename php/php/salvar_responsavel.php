<?php
$btnCadRes = filter_input(INPUT_POST, 'btnCad', FILTER_DEFAULT);
if ($btnCadRes) {
  include 'conexao.php';
  session_start();
  $dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  $erro = false;

  $dados_st = array_map('strip_tags', $dados_rc);
  $dados = array_map('trim', $dados_st);
  $cpf = $dados['cpf'];

  function cpfExiste($cpf)
  {
    include 'conexao.php';
    $verifica_cpf = $sql->query("SELECT * FROM responsavel WHERE res_cpf='$cpf' UNION SELECT * FROM motorista WHERE moto_cpf='$cpf'");

    return $verifica_cpf->num_rows > 0;
  }

  if (cpfExiste($cpf)) {
    echo "CPF já cadastrado como motorista ou responsável";
    header("Location: ../php/cadastro_responsavel.php");
  } else {

    if (in_array('', $dados)) {
      $erro = true;
      header("Location: ../php/cadastro_responsavel.php");
    } elseif ((strlen($dados['senha'])) < 6) {
      $erro = true;
      header("Location: ../php/cadastro_responsavel.php");
    } elseif (stristr($dados['senha'], "&")) {
      $erro = true;
      header("Location: ../php/cadastro_responsavel.php");

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
      $_SESSION['res_nome'] = $dados['nome'];
      $_SESSION['res_email'] = $dados['email'];
      $_SESSION['res_senha'] = $dados['senha'];
      $_SESSION['res_genero'] = $dados['genero'];
      $_SESSION['res_telefone'] = $dados['telefone'];
      $_SESSION['res_dtnascimento'] = $dados['dtnascimento'];

      $result_responsavel = "INSERT INTO responsavel (res_cpf, nome, email, senha, genero, telefone, data_nascimento) VALUES (
          '" . $_SESSION['res_cpf'] . "',
          '" . $_SESSION['res_nome'] . "',
          '" . $_SESSION['res_email'] . "',
          '" . $_SESSION['res_senha'] . "',
          '" . $_SESSION['res_genero'] . "',
          '" . $_SESSION['res_telefone'] . "',
          '" . $_SESSION['res_dtnascimento'] . "'
      )";

      $resultado_responsavel = mysqli_query($sql, $result_responsavel);

      if ($resultado_responsavel && mysqli_affected_rows($sql) > 0) {
        header("Location: ../php/cadastro_endereco_responsavel.php");
        exit();
      } else {
        $_SESSION['msg'] = "Erro ao cadastrar o usuário: " . mysqli_error($sql);
      }
    }
  }
}
?>