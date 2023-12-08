<?php
include("bd_conect.php");
include("conexao.php");

// Inicie a sessão para acessar as variáveis de sessão
session_start();

// Verifique se a sessão está configurada e se o responsável está logado
if (!isset($_SESSION["res_cpf"])) {
  header("Location: ../html/login.html"); // Redireciona para a página de login do responsável se não estiver logado
  exit();
}

// Agora você tem acesso a $_SESSION["res_cpf"] para identificar o responsável logado
$responsavelCpf = $_SESSION["res_cpf"];

// Consulta para obter moto_cpf usando res_cpf
$query = "SELECT t.moto_cpf
          FROM responsavel r
          JOIN crianca c ON r.res_cpf = c.res_cpf
          JOIN transporte t ON c.trans_id = t.trans_id
          WHERE r.res_cpf = :res_cpf";

// Prepara a consulta
$stmt = $pdo->prepare($query);

// Associa o valor do CPF do responsável à consulta
$stmt->bindParam(":res_cpf", $responsavelCpf, PDO::PARAM_STR);

// Executa a consulta
$stmt->execute();

// Obtém o resultado da consulta
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se a consulta retornou algum resultado
if ($resultado) {
  // O valor de moto_cpf está na variável $resultado['moto_cpf']
  $motoCpf = $resultado['moto_cpf'];
} else {
  echo "Não foi possível encontrar o motorista associado ao responsável.";
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
if ($count_transporte > 0) {
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
  <link rel="stylesheet" href="../css/chat.css">
  <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
  <script src="https://unpkg.com/@phosphor-icons/web"></script>

  <title>Seu transporte</title>
</head>

<body class="home-body"
  style="display: flex; height: 100%; flex-direction: column; justify-content: center; align-items: center;">
  <header class="home-header row justify-content-center align-items-center g-2 col-12"
    style="position: absolute;top: 0;padding: 0 2vw;">
    <a href="home_responsavel.php" class="col-6">
      <img src="/img/logo_v2.png" alt="Logo Transfast" class="home-logo">
    </a>

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
            href="<?php echo ($count_transporte > 0) ? 'seu_transporte_com.php?trans_id=' . $trans_id_crianca . '' : '../html/seu_transporte_sem.html'; ?>">
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

  <!--- janela do chat (o fundo onde fica tudo do chat) ----------->
  <div class="chat-container"
    style="width: 60vw; height: 38vw; display: flex; flex-direction: row; justify-content: center; align-items: center; color: #fff; border-radius: 2vw; margin-top: 3vw;">
    <!-- na div acima, a parte lateral erquerda do chat--------->

    <div class="chat"
      style="height: 100%; width: 100%; background-color: #F5F5F5; display: flex; flex-direction: column; justify-content: center; align-items: center; border-radius: 0 2vw 2vw 0;">

      <div id="chat-header" class="chat-header"
        style="display: flex; width: 100%; height: 3vw; background-color: #E4E4E4; justify-content: start; align-items: center; padding: 2vw; border-radius: 0 2vw 0 0;">
        <span style="display: flex;flex-direction: row;justify-content: center;align-items: center; gap: 10px;">

          <?php
          include("bd_conect.php");
          include("conexao.php");

          // Consulta para obter informações do motorista (nome e foto) pelo moto_cpf específico
          $sqlConsultaMotorista = "SELECT m.nome AS nome_motorista, m.foto AS foto_motorista FROM motorista m WHERE m.moto_cpf = '123.456.789-12'";

          $stmtConsultaMotorista = $pdo->prepare($sqlConsultaMotorista);
          $stmtConsultaMotorista->execute();
          $rowConsultaMotorista = $stmtConsultaMotorista->fetch(PDO::FETCH_ASSOC);

          // Verifica se a consulta retornou algum resultado
          if ($rowConsultaMotorista) {
            // Verifica se há uma foto disponível
            if ($rowConsultaMotorista['foto_motorista'] !== null) {
              // Exibe a foto do motorista
              $fotoMotoristaBase64 = base64_encode($rowConsultaMotorista['foto_motorista']);
              echo '<img src="data:image/jpeg;base64,' . $fotoMotoristaBase64 . '" alt="Foto do motorista" style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">';
            } else {
              // Caso não haja foto, exiba uma mensagem ou imagem padrão
              echo 'Sem foto disponível';
            }

            // Exibe o nome do motorista
            echo '<p style="text-transform: capitalize; margin: 0; color: #1E184C; font-weight: 500; font-size: 18px;">' . $rowConsultaMotorista['nome_motorista'] . '</p>';
          } else {
            // Se não encontrar o motorista, você pode lidar com isso de acordo com a sua lógica
            echo '<p style="margin: 0; color: #1E184C; font-weight: 500; font-size: 18px;">Motorista não encontrado</p>';
          }
          ?>


        </span>
      </div>

      <!-------- Acima, aparecerá só quando clicar no perfil ------->

      <div id="chat" class="chat-mensagens"
        style=" display: flex; height: 100%; width: 100%; flex-direction: column; justify-content: start; align-items: center; padding: 2vw; overflow-y: auto; ">
        <div class="chat-right"
          style="width: 100%; display: flex; justify-content: flex-end; align-items: center; border-radius: 0 2vw 2vw 0; margin-bottom: 10px;">
          <div class="chat-right-item"
            style="max-width: 27vw; width: auto; padding: 10px; background-color: #1E184C; display: flex; justify-content: flex-start; align-items: center; border-radius: 1vw; word-wrap: break-word;">
            <p style="margin: 0; font-size: 14px; overflow: hidden;">Olá, Quero fechar contrato!</p>
          </div>
        </div>
        <div class="chat-left"
          style="width: 100%; display: flex; justify-content: flex-start; align-items: center; margin-bottom: 10px;">
          <div class="chat-left-item"
            style="max-width: 27vw; width: auto; padding: 10px; background-color: #1E184C; display: flex; justify-content: flex-start; align-items: center; border-radius: 1vw; word-wrap: break-word;">
            <p style="margin: 0; font-size: 14px; overflow: hidden;">Olá</p>
          </div>
        </div>
        <div class="chat-left"
          style="width: 100%; display: flex; justify-content: flex-start; align-items: center; margin-bottom: 10px;">
          <div class="chat-left-item"
            style="max-width: 27vw; width: auto; padding: 10px; background-color: #1E184C; display: flex; justify-content: flex-start; align-items: center; border-radius: 1vw; word-wrap: break-word;">
            <p style="margin: 0; font-size: 14px; overflow: hidden;">Ok, irei te mandar o Código do transporte</p>
          </div>
        </div>
        <div class="chat-left"
          style="width: 100%; display: flex; justify-content: flex-start; align-items: center; margin-bottom: 10px;">
          <div class="chat-left-item"
            style="max-width: 27vw; width: auto; padding: 10px; background-color: #1E184C; display: flex; justify-content: flex-start; align-items: center; border-radius: 1vw; word-wrap: break-word;">
            <p style="margin: 0; font-size: 14px; overflow: hidden;">Código: 8uGA35Gw</p>
          </div>
        </div>
      </div>

      <form method="POST" action="javascript:void(0);" onsubmit="return enviarMensagem();">
        <div id="chat-bottom" class="chat-bottom" style="display: flex;">
          <input name="mensagem" type="text" placeholder="Escreva sua mensagem">
          <button type="submit"><i class="ph ph-paper-plane"></i></button>
        </div>
      </form>
    </div>
  </div>

</html>