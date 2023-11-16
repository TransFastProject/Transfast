<?php
$btnCadEnd = filter_input(INPUT_POST, 'btnEnd', FILTER_DEFAULT);
if ($btnCadEnd) {
  include_once 'conexao.php';
  session_start();

  
  $dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  $erro = false;

  $dados_st = array_map('strip_tags', $dados_rc);
  $dados = array_map('trim', $dados_st);

  if (empty($dados['complemento'])) {
    unset($dados['complemento']);
  }

  if (in_array('', $dados) && !isset($dados['complemento'])) {
    $erro = true;
    $_SESSION['msg'] = "Necessário preencher todos os dados, com exceção do complemento";
  }

  if (!$erro) {
    $_SESSION['cep'] = $dados['cep'];
    $_SESSION['rua'] = $dados['rua'];
    $_SESSION['bairro'] = $dados['bairro'];
    $_SESSION['numero'] = $dados['numero'];
    $_SESSION['complemento'] = $dados['complemento'];
    $result_end = "UPDATE motorista SET cep='" . $_SESSION['cep'] . "', rua='" . $_SESSION['rua'] . "', bairro='" . $_SESSION['bairro'] . "', numero='" . $_SESSION['numero'] . "'";

    if (isset($dados['complemento'])) {
      $result_end .= ", complemento='" . $_SESSION['complemento'] . "'";
    }

    $result_end .= " WHERE moto_cpf='" . $_SESSION['moto_cpf'] . "'";

    $resultado_end = mysqli_query($sql, $result_end);

    if ($resultado_end && mysqli_affected_rows($sql) > 0) {
      $_SESSION['msg'] = "Dados do Motorista cadastrados com sucesso";
      header("Location: ../php/cad_veiculo.php");
      exit();
    } else {
      $_SESSION['msg'] = "Erro ao cadastrar os dados do motorista: " . mysqli_error($sql);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Cadastro de Endereço</title>
  <link rel="stylesheet" href="../css/estilo.css" />
  <link rel="stylesheet" href="../css/cadastro.css" />
  <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
</head>

<body>
  <?php
  if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
  }
  ?>
  <form action="" method="post" class="forms_cad_ende" id="cad_endereco">
    <h1>Endereço</h1>

    <div class="sem_nome">
      <div>
        <label for="" class="label_ende"><b>Rua</b></label><br />
        <input type="text" class="input_ende" id="ipt_ende1" name="rua" required /><br />
      </div>
    </div>

    <div class="sem_nome">
      <div>
        <label for="" class="label_ende"><b>Número</b></label><br />
        <input type="text" class="input_ende" id="ipt_ende2" name="numero" required /><br />
      </div>
      <div>
        <label for="" class="label_ende"><b>Complemento(Opcional)</b></label><br />
        <input type="text " class="input_ende" id="ipt_ende3" name="complemento" />
      </div>
    </div>


    <div class="sem_nome">
      <div>
        <label for=" " class="label_ende"><b>CEP</b></label><br />
        <input type="text " class="input_ende ipt_ende45" name="cep" required /><br />
      </div>
      <div>
        <label for=" " class="label_ende"><b>Bairro</b></label><br />
        <input type="text " class="input_ende ipt_ende45" name="bairro" required /><br />
      </div>
    </div>

    <br><br><br>
    <div id="btn_enviar">
      <input type="submit" value="." class="btn_forms" name="btnEnd" />
    </div>
    <p>Já possui conta? <a href="../html/login.html">Faça o Login</a></p>

  </form>
</body>

</html>