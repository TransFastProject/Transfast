<?php
$btnCadVeiculo = filter_input(INPUT_POST, 'btnVeiculo', FILTER_DEFAULT);
if ($btnCadVeiculo) {
  include_once 'conexao.php';
  session_start();

  $dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  $erro = false;

  $dados_st = array_map('strip_tags', $dados_rc);
  $dados = array_map('trim', $dados_st);

  if (in_array('', $dados)) {
    $erro = true;
    $_SESSION['msg'] = "Necessário preencher todos os dados";
  }

  if (!$erro) {
    function gerarCodigo() {
      $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      $codigo = '';
      
      for ($i = 0; $i < 8; $i++) {
          $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
      }
      
      return $codigo;
  }
  
  // Exemplo de uso
  $codigo_gerado = gerarCodigo();
    $trans_id = "SELECT trans_id from transporte WHERE moto_cpf='". $_SESSION['moto_cpf'] ."'";
    $link_id = mysqli_query($sql,$trans_id);
    $linked_id = mysqli_fetch_assoc($link_id);
    $_SESSION['trans_id'] = $linked_id;
    $_SESSION['nome_transporte'] = $dados['nome'];
    $_SESSION['monitor'] = "";
    $_SESSION['placa'] = $dados['placa'];
    $_SESSION['n_assentos'] = $dados['n_assento'];
    $_SESSION['estado_transporte'] = $dados['estado'];
    $_SESSION['cidade_transporte'] = $dados['cidade'];
    $_SESSION['cep_transporte'] = $dados['cep'];
    $_SESSION['bairro_transporte'] = $dados['bairro'];
    $_SESSION['codigo'] = $codigo_gerado;

    $result_veiculo = "INSERT INTO transporte (moto_cpf, nome, monitor, placa, n_assentos, estado, cidade, cep, bairro, codigo) VALUES (
          '" . $_SESSION['moto_cpf'] . "',
          '" . $_SESSION['nome_transporte'] . "',
          '" . $_SESSION['monitor'] . "',
          '" . $_SESSION['placa'] . "',
          '" . $_SESSION['n_assentos'] . "',
          '" . $_SESSION['estado_transporte'] . "',
          '" . $_SESSION['cidade_transporte'] . "',
          '" . $_SESSION['cep_transporte'] . "',
          '" . $_SESSION['bairro_transporte'] . "',
          '" . $_SESSION['codigo'] . "'
      )";

    $resultado_veiculo = mysqli_query($sql, $result_veiculo);

    if (mysqli_insert_id($sql)) {
      $_SESSION['msg'] = "Veiculo cadastrado com sucesso";
      header("Location: ../php/gere_inicio.php");
      exit();
    } else {
      $_SESSION['msg'] = "Erro ao cadastrar o veiculo: " . mysqli_error($sql);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Cadastro de Veiculo</title>
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
    <h1>Veiculo</h1>

    <div class="sem_nome">
      <div>
        <label for="" class="label_ende"><b>Nome do Transporte</b></label><br />
        <input type="text" class="input_ende" id="ipt_ende1" name="nome" required /><br />
      </div>
    </div>



    <br /><br /><br />

    <div class="sem_nome">
      <div>
        <label for=" " class="label_ende"><b>Placa</b></label><br />
        <input type="text " class="input_ende ipt_ende45" name="placa" required /><br />
      </div>
      <div>
        <label for=" " class="label_ende" name="n_assento"><b>N° de Assentos</b></label><br />
        <input type="number" class="input_ende ipt_ende45" name="n_assento" required /><br />
      </div>
    </div>

    <br /><br /><br />

    <div class="sem_nome">
      <div>
        <label for="" class="label_ende"><b>Estado</b></label><br />
        <input type="text " class="input_ende ipt_ende45" name="estado" required /><br />
      </div>
      <div>
        <label for="" class="label_ende"><b>Cidade</b></label><br />
        <input type="text " class="input_ende ipt_ende45" name="cidade" required /><br />
      </div>
    </div>

    <br /><br /><br />

    <div class="sem_nome">
      <div>
        <label for="" class="label_ende"><b>CEP</b></label><br />
        <input type="text" class="input_ende" id="ipt_ende2" name="cep" required /><br />
      </div>
      <div>
        <label for=" " class="label_ende"><b>Bairro</b></label><br />
        <input type="text " class="input_ende" id="ipt_ende3" name="bairro" required />
      </div>
    </div>

    <br><br><br>
    <div id="btn_enviar">
      <input type="submit" value="." class="btn_forms" name="btnVeiculo" />
    </div>
    <p>Já possui conta? <a href="../html/login.html">Faça o Login</a></p>

  </form>
</body>

</html>