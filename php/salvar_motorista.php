<?php
$btnCadMoto = filter_input(INPUT_POST, 'btnCad', FILTER_DEFAULT);
if ($btnCadMoto) {
  include 'conexao.php';
  session_start();
  $dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  $erro = false;

  $dados_st = array_map('strip_tags', $dados_rc);
  $dados = array_map('trim', $dados_st);
  $cpf = $dados['cpf'];
  $dataUsuario = $dados['dtnascimento'];

  function cpfExiste($cpf)
  {
    include 'conexao.php';
    $verifica_cpf = $sql->query("SELECT * FROM motorista WHERE moto_cpf='$cpf' UNION SELECT * FROM responsavel WHERE res_cpf='$cpf'");

    return $verifica_cpf->num_rows > 0;
  }
  function verificaIdade($dataUsuario){
    $dataAtual = new DateTime();
    $dataNascimento = new DateTime($dataUsuario);
    $diferenca = $dataAtual->diff($dataNascimento);

    $idade = $diferenca->y;

    if($idade >= 18 && $idade <= 100){
      echo "Você tem a idade suficiente para realizar o cadastro";
      return true;
    }else{
      echo "Idade acima ou abaixo do permitido para cadastrar";
      return false;
    }
  }
  if (cpfExiste($cpf)) {
    echo "CPF já cadastrado como motorista ou responsável";
    header("Location: ../php/cadastro.php");
  } else {
    if (in_array('', $dados)) {
      $erro = true;
      header("Location: ../php/cadastro.php");
    } elseif ((strlen($dados['senha'])) < 6) {
      $erro = true;
      header("Location: ../php/cadastro.php");
    } elseif (stristr($dados['senha'], "&")) {
      $erro = true;
      header("Location: ../php/cadastro.php");
    } else {
      $result_motorista = "SELECT moto_cpf FROM motorista WHERE email='" . $dados['email'] . "'";
      $resultado_motorista = mysqli_query($sql, $result_motorista);
      if (($resultado_motorista) and ($resultado_motorista->num_rows != 0)) {
        $erro = true;
        header("Location: ../php/cadastro.php");
      }
    }
    if (!$erro) {
      if (verificaIdade($dataUsuario)){
      $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
      $_SESSION['moto_cpf'] = $cpf;
      $_SESSION['nome'] = $dados['nome'];
      $_SESSION['email'] = $dados['email'];
      $_SESSION['senha'] = $dados['senha'];
      $_SESSION['genero'] = $dados['genero'];
      $_SESSION['telefone'] = $dados['telefone'];
      $_SESSION['dtnascimento'] = $dataUsuario;

      $result_motorista = "INSERT INTO motorista (moto_cpf, nome, email, senha, genero, telefone, data_nascimento) VALUES (
          '" . $_SESSION['moto_cpf'] . "',
          '" . $_SESSION['nome'] . "',
          '" . $_SESSION['email'] . "',
          '" . $_SESSION['senha'] . "',
          '" . $_SESSION['genero'] . "',
          '" . $_SESSION['telefone'] . "',
          '" . $_SESSION['dtnascimento'] . "'
      )";

      $resultado_motorista = mysqli_query($sql, $result_motorista);

      $create_vistoria = $sql->query("INSERT INTO vistoria(moto_cpf, item01, item02, item03, item04, item05, item06, item07, item08, item09, item10) VALUES ('" . $_SESSION['moto_cpf'] . "', '0','0','0','0','0','0','0','0','0','0')");

      if ($resultado_motorista && mysqli_affected_rows($sql) > 0) {
        header("Location: ../php/cad_endereco.php");
        exit();
      } else {
        $_SESSION['msg'] = "Erro ao cadastrar o usuário: " . mysqli_error($sql);
      }
    } else {
      header("Location: ../php/cadastro.php");
      exit();
    }
  } else {
    header("Location: ../php/cadastro.php");
    exit();
  }
}
}
?>