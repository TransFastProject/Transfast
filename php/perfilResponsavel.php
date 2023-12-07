<?php
include_once "conexao.php";
session_start();

// Verifica se o responsável está logado
if(!isset($_SESSION["res_cpf"])) {
  header("Location: ../html/login.html");
  exit();
}

// Recupera informações do responsável
$stmt = mysqli_prepare($sql, "SELECT * FROM responsavel WHERE res_cpf = ?");
mysqli_stmt_bind_param($stmt, "s", $_SESSION['res_cpf']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if($row_responsavel = mysqli_fetch_assoc($result)) {
  // Preencha as variáveis com as informações do responsável
  $nome = $row_responsavel['nome'];
  $email = $row_responsavel['email'];
  $genero = $row_responsavel['genero'];
  $telefone = $row_responsavel['telefone'];
  $foto = $row_responsavel['foto'];
  $rua = $row_responsavel['rua'];
  $cep = $row_responsavel['cep'];
  $bairro = $row_responsavel['bairro'];
  $numero = $row_responsavel['numero'];
  $complemento = $row_responsavel['complemento'];
  $nasc = $row_responsavel['data_nascimento'];
  // Adicione mais campos conforme necessário
} else {
  echo "Responsável não encontrado.";
  exit();
}

// Lista de opções para o campo de gênero
$opcoes_genero = array("Masculino", "Feminino", "Outro", "Prefiro não dizer");

// Lista de opções para o campo de deficiência
$opcoes_deficiencia = array("Nenhuma", "Visual", "Auditiva", "Física", "Cognitiva");

// Consulta para obter os transportes e informações do motorista associado
$sqlConsultaTransportes = "SELECT t.*, m.nome AS nome_motorista, m.telefone AS telefone_motorista, m.foto AS foto_moto FROM transporte t
                           JOIN motorista m ON t.moto_cpf = m.moto_cpf"; // Ajuste este valor conforme necessário
$resultTransportes = mysqli_query($sql, $sqlConsultaTransportes);

// Transforma os resultados em um array associativo
$transportes = [];
while($row = mysqli_fetch_assoc($resultTransportes)) {
  $transportes[] = $row;
}

// Consulta para verificar se pelo menos uma criança associada ao responsável possui o campo trans_id preenchido
$sql_verificar_transporte = "SELECT COUNT(*) AS count_transporte, GROUP_CONCAT(trans_id) AS trans_ids FROM crianca WHERE res_cpf = ? AND trans_id IS NOT NULL AND trans_id NOT IN ('0', '1')";
$stmt_verificar_transporte = mysqli_prepare($sql, $sql_verificar_transporte);
mysqli_stmt_bind_param($stmt_verificar_transporte, "s", $_SESSION['res_cpf']);
mysqli_stmt_execute($stmt_verificar_transporte);
$result_verificar_transporte = mysqli_stmt_get_result($stmt_verificar_transporte);
$row_verificar_transporte = mysqli_fetch_assoc($result_verificar_transporte);
$count_transporte = $row_verificar_transporte['count_transporte'];
$trans_ids_crianca = $row_verificar_transporte['trans_ids'];

// Inicializa $trans_id_crianca como vazio
$trans_id_crianca = "";

// Verifica se pelo menos uma criança associada ao responsável possui o campo trans_id preenchido
if($count_transporte > 0) {
  // Se há pelo menos uma criança com trans_id, obtenha o primeiro trans_id (considerando que todas têm o mesmo trans_id)
  $trans_id_crianca = explode(",", $trans_ids_crianca)[0];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/responsavel.css">
  <link rel="stylesheet" href="../css/seuTransporte.css">
  <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <title>Seu perfil</title>

  <style>
    .campo-perfil {
      border-style: solid;
      color: #fff;
      padding: 0;
      border-bottom-width: 1px;
      border-top-width: 0;
      border-right-width: 0;
      border-left-width: 0;
    }
  </style>
</head>

<body class="home-body"
  style="display: flex; height: 100%; flex-direction: column; justify-content: center; align-items: center;">
  <header class="home-header row justify-content-center align-items-center g-2 col-12"
    style="position: absolute;top: 0;padding: 0 2vw;">
    <span class="col-6"
      style="display: flex;flex-direction: row; justify-content: start; align-items: center; gap: 4vw;">
      <a href="home_responsavel.php">
        <img src="../img/logo_v2.png" alt="Logo Transfast" class="home-logo">
      </a>
      <span style="display: flex;flex-direction: row; justify-content: center; align-items: center; gap: 2vw;">
        <a href="perfilResponsavel.php"
          style="padding: 1vw 1.5vw; background-color: #3C3577; border-radius: 1vw;text-decoration: none;color: #fff;">RESPONSÁVEL</a>
        <a href="perfilCriancaSelecionar.php" style="text-decoration: none; color: #fff;">CRIANÇA</a>
      </span>
    </span>


    <div class="home-menu col-6">
      <div class="home-menu-container row justify-content-center align-items-center">
        <div class="home-menu-item col">
          <a href="home_responsavel.php">
            <i class="ph ph-house"></i>
            <p>Início</p>
          </a>
        </div>
        <div class="home-menu-item col">
          <a href="">
            <i class="ph ph-chat-circle-dots"></i>
            <p>Mensagens</p>
          </a>
        </div>
        <div class="home-menu-item col">
          <a
            href="<?php echo ($count_transporte > 0) ? 'seu_transporte_com.php?trans_id='.$trans_id_crianca.'' : '../html/seu_transporte_sem.html'; ?>">
            <i class="ph ph-van"></i>
            <p>Seu transporte</p>
          </a>
        </div>
        <div class="home-menu-item col">
          <a href="perfilResponsavel.php">
            <i class="ph ph-user"></i>
            <p>Perfil</p>
          </a>
        </div>
      </div>

    </div>
  </header>

  <div class="semTransporte">
    <h3 style="font-weight: 600;">SEU PERFIL</h3>
    <div class="perfil-container"
      style="width:50vw; display: flex;flex-direction: column; justify-content: center; align-items: start;gap: 3vw;">
      <form action="salvar_edicao_res.php" method="post" enctype="multipart/form-data"
        style="display: flex;flex-direction: column; justify-content: center; align-items: start;gap: 3vw;">
        <span style="display: flex;flex-direction: row; justify-content: start; align-items: center;gap: 2vw;">
          <div class="fotoPerfil-div"
            style="display: flex; flex-direction: column; justify-content: center; align-items: center">
            <?php if(!empty($foto)): ?>
              <img id="previewFoto" src="<?php echo $foto; ?>" class="rounded-circle"
                style="width: 8vw; height: 8vw; object-fit: cover;">
            <?php else: ?>
              <img id="previewFoto" src="../img/fundo_foto_padrao.png" class="rounded-circle"
                style="width: 8vw; height: 8vw; object-fit: cover;">
            <?php endif; ?>
            <label for="novaFotoPerfil" style="position: absolute; cursor: pointer;" id="novaFotoPerfil-label"><i
                class="ph ph-pencil" style="font-size: 3vw"></i></label>
            <input type="file" id="novaFotoPerfil" name="novaFotoPerfil" style="display: none;" accept="image/*"
              onchange="previewImagem(this);">
          </div>

          <div class="perfil-info-usuario">
            <p style="margin: 0; font-size: 25px;"><input type="text" name="nome" value="<?php echo $nome; ?>"
                style="background: none; font-size: 25px; color: #fff; border: none; outline: none;"></p>
            <p style="margin: 0; font-size: 25px;"><input type="text" name="email" value="<?php echo $email; ?>"
                style="background: none; font-size: 25px; color: #fff; border: none; outline: none;"></p>
          </div>
        </span>
        <div class="perfil-info"
          style="width: 100%;display: flex;flex-direction: column; justify-content: center; align-items: center; gap: 1vw;">
          <span
            style="display: flex;flex-direction: row; justify-content: space-between; align-items: center; width: 100%;">
            <span style="width: 36vw;">
              <p class="campo-perfil"
                style="display: flex;flex-direction: row; justify-content: start; align-items: center; height: 2vw;">
                Rua: <input type="text" name="rua" value="<?php echo $rua; ?>"
                  style="background: none; color: #fff; border: none; outline: none;"></p>
              <p></p>
            </span>
            <span style="width: 10vw;">
              <p class="campo-perfil"
                style="display: flex;flex-direction: row; justify-content: start; align-items: center; white-space: nowrap; height: 2vw;">
                Nº: <input type="text" name="numero" value="<?php echo $numero; ?>"
                  style="background: none; color: #fff; border: none; outline: none;"></p>
              <p></p>
            </span>
          </span>
          <span
            style="display: flex;flex-direction: row; justify-content: space-between; align-items: center; width: 100%;">
            <span style="width: 23vw;">
              <p class="campo-perfil"
                style="display: flex;flex-direction: row; justify-content: start; align-items: center; white-space: nowrap; height: 2vw;">
                Bairroº: <input type="text" name="bairro" value="<?php echo $bairro; ?>"
                  style="background: none; color: #fff; border: none; outline: none;"></p>
              <p></p>
            </span>
            <span style="width: 23vw;">
              <p class="campo-perfil"
                style="display: flex;flex-direction: row; justify-content: start; align-items: center; height: 2vw;">
                CEP: <input type="text" name="cep" value="<?php echo $cep; ?>"
                  style="background: none; color: #fff; border: none; outline: none;"></p>
              <p></p>
            </span>
          </span>
          <span
            style="display: flex;flex-direction: row; justify-content: space-between; align-items: center; width: 100%;">
            <span style="width: 23vw;">
              <p
                style="border-style: solid; color: #fff; padding: 0; border-bottom-width: 1px; border-top-width: 0; border-right-width: 0; border-left-width: 0; height: 2vw; display: flex;flex-direction: row; justify-content: start; align-items: center; gap: 10px">
                Gênero:
                <!-- Campo de Seleção para Gênero -->
                <select name="genero" class="campo-perfil"
                  style="background: none; width: 23vw; border: none; outline: none; -moz-appearance: none; -webkit-appearance: none;">
                  <?php
                  foreach($opcoes_genero as $opcao) {
                    $selected = ($genero == $opcao) ? "selected" : "";
                    echo "<option value=\"$opcao\" style=\"background-color: #1E184C;\" $selected>$opcao</option>";
                  }
                  ?>
                </select>
              </p>
            </span>
            <span style="width: 23vw;">
              <p class="campo-perfil"
                style="display: flex;flex-direction: row; justify-content: start; align-items: center; height: 2vw;">
                Complemento: <input type="text" name="complemento" value="<?php echo $complemento; ?>"
                  style="background: none; color: #fff; border: none; outline: none;"></p>
              <p></p>
            </span>
          </span>
          <span
            style="display: flex;flex-direction: row; justify-content: space-between; align-items: center; width: 100%; gap: 3vw;">
            <span style="width: 23vw;">
              <p class="campo-perfil"
                style="display: flex;flex-direction: row; justify-content: start; align-items: center; height: 2vw; white-space: nowrap;">
                Data de nascimento: <input type="text" name="data_nascimento" value="<?php echo $nasc; ?>"
                  style="background: none; color: #fff; border: none; outline: none;"></p>
              <p></p>
            </span>
            <span style="width: 23vw;">
              <p class="campo-perfil"
                style="display: flex;flex-direction: row; justify-content: start; align-items: center; height: 2vw;">
                Contato: <input type="text" name="telefone" value="<?php echo $telefone; ?>"
                  style="background: none; color: #fff; border: none; outline: none;"></p>
              <p></p>
            </span>
          </span>
        </div>

        <div class="salvar"
          style="width: 100%; display: flex; flex-direction:column; justify-content: center; align-items:center; gap: 1vw;">
          <input type="submit"
            style="border: none; width: 12vw; height: 2.5vw;  border-radius: 1vw; text-align: center; display: flex; justify-content: center; align-items: center;"
            name="submit" value="Salvar">

        </div>
      </form>
    </div>
    <div class="salvar"
      style="width: 100%; display: flex; flex-direction:column; justify-content: center; align-items:center; gap: 1vw;">
      <button onclick="location.href='home_responsavel.php'"
        style="border: none; width: 12vw; height: 2.5vw;  border-radius: 1vw; text-align: center; display: flex; justify-content: center; align-items: center; margin-top:1vw; margin-left:-1vw">Voltar</button>
    </div>
  </div>

  <script>
    function previewImagem(input) {
      var preview = document.getElementById('previewFoto');
      var file = input.files[0];
      var reader = new FileReader();

      reader.onloadend = function () {
        preview.src = reader.result;
      };

      if (file) {
        reader.readAsDataURL(file);
      } else {
        preview.src = "../img/fundo_foto_padrao.png";
      }
    }
  </script>

</body>

</html>