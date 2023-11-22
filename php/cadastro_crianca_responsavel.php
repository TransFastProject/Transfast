<?php 
$btnCadCrianca = filter_input(INPUT_POST, 'btnCad', FILTER_DEFAULT);
if ($btnCadCrianca) {
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
    $cria_id = "SELECT cria_id from crianca WHERE res_cpf='". $_SESSION['res_cpf'] ."'";
    $link_id = mysqli_query($sql,$cria_id);
    $linked_id = mysqli_fetch_assoc($link_id);
    $_SESSION['cria_id'] = $linked_id;
    $_SESSION['nome_crianca'] = $dados['nome'];
    $_SESSION['idade'] = $dados['idade'];
    $_SESSION['genero'] = $dados['genero'];
    $_SESSION['escola'] = $dados['escola'];
    $_SESSION['dtnascimento'] = $dados['dtnascimento'];
    $_SESSION['deficiencia'] = $dados['deficiencia'];

    $result_crianca = "INSERT crianca (res_cpf, trans_id, nome, idade, genero, data_nascimento, escola, deficiencia) VALUES (
          '" . $_SESSION['res_cpf'] . "',
          1,
          '" . $_SESSION['nome_crianca'] . "',
          '" . $_SESSION['idade'] . "',
          '" . $_SESSION['genero'] . "',
          '" . $_SESSION['escola'] . "',
          '" . $_SESSION['dtnascimento'] . "',
          '" . $_SESSION['deficiencia'] . "'
      )";

    $resultado_crianca = mysqli_query($sql, $result_crianca);

    if (mysqli_insert_id($sql)) {
      $_SESSION['msg'] = "Crianca cadastrado com sucesso";
      header("Location: ../html/home_responsavel.html");
      exit();
    } else {
      $_SESSION['msg'] = "Erro ao cadastrar a crianca: " . mysqli_error($sql);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Cadastro responsável</title>
  <link rel="stylesheet" href="../css/estilo.css" />
  <link rel="stylesheet" href="../css/cadastro.css" />
  <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
</head>

<body class="cad_body">
  <form action="" method="POST" class="forms_cadastro">
    <h1>Cadastre sua criança</h1>

    <div>
      <div>
        <label for="" class="label_cad"><b>Nome</b></label><br />
        <input type="text" name="nome" id="nome" class="input_cad" required /><br />
      </div>
      <div>
        <label for="" class="label_cad"><b>Idade</b></label><br />
        <input type="number" name="idade" id="idade" class="input_cad" required /><br />
      </div>
    </div>

    <div>
      <div>
        <label for="" class="label_cad" id="label_genero"><b>Gênero</b></label><span id="avisoCpf"></span><br />
        <select name="genero" id="genero" class="input_cad">
          <option value="masculino">Masculino</option>
          <option value="feminino">Feminino</option>
          <option value="outro">Outro</option>
          <option value="prefiro não dizer">Prefiro não dizer</option>
        </select>
      </div>
      <div>
        <label for="" class="label_cad"><b>Escola</b></label><br />
        <input type="text" name="escola" id="escola" class="input_cad" required /><br />
      </div>

    </div>


    <div>
      <div>
        <label for="" class="label_cad"><b>Data de Nascimento</b></label><br />
        <input type="date" name="dtnascimento" id="dtnascimento" class="input_cad" required />
      </div>
      <div>
        <label for="" class="label_cad" id="label_genero"><b>Possui deficiência?</b></label><span id="avisoCpf"></span><br />
        <select name="deficiencia" id="deficiencia" class="input_cad">
          <option value="masculino">Não possui</option>
          <option value="visual">Visual</option>
          <option value="auditiva">Auditiva</option>
          <option value="fisica">Física</option>
          <option value="cognitiva">Cognitiva</option>
        </select>
      </div>
    </div>


    <div id="btn_cadastro">
      <input type="submit" value="." name="btnCad" id="btn_fcadastro">
    </div>
    <p>Já possui conta? <a href="../html/login.html">Faça o Login</a></p>

  </form>
</body>

</html>