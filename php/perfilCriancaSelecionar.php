<?php
include_once "conexao.php";
session_start();

// Verifica se o responsável está logado
if (!isset($_SESSION["res_cpf"])) {
    header("Location: ../html/login.html"); // Redireciona para a página de login do responsável se não estiver logado
    exit();
}

// Recupera as informações das crianças associadas ao responsável
$stmt = mysqli_prepare($sql, "SELECT * FROM crianca WHERE res_cpf = ?");
mysqli_stmt_bind_param($stmt, "s", $_SESSION['res_cpf']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Consulta para obter os transportes e informações do motorista associado
$sqlConsultaTransportes = "SELECT t.*, m.nome AS nome_motorista, m.telefone AS telefone_motorista, m.foto AS foto_moto FROM transporte t
                           JOIN motorista m ON t.moto_cpf = m.moto_cpf"; // Ajuste este valor conforme necessário
$resultTransportes = mysqli_query($sql, $sqlConsultaTransportes);

// Transforma os resultados em um array associativo
$transportes = [];
while ($row = mysqli_fetch_assoc($resultTransportes)) {
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
            <a href="../html/home_responsavel.html">
                <img src="../img/logo_v2.png" alt="Logo Transfast" class="home-logo">
            </a>
            <span style="display: flex;flex-direction: row; justify-content: center; align-items: center; gap: 2vw;">
                <a href="perfilResponsavel.php" style="text-decoration: none; color: #fff;">RESPONSÁVEL</a>
                <a href="perfilCriancaSelecionar.php"
                    style="padding: 1vw 1.5vw; background-color: #3C3577; border-radius: 1vw;text-decoration: none;color: #fff;">CRIANÇA</a>
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
                    <a href="chatt.php">
                        <i class="ph ph-chat-circle-dots"></i>
                        <p>Mensagens</p>
                    </a>
                </div>
                <div class="home-menu-item col">
                <a href="<?php echo ($count_transporte > 0) ? 'seu_transporte_com.php?trans_id='.$trans_id_crianca.'' : '../html/seu_transporte_sem.html'; ?>">
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
        <h3 style="font-weight: 600;">SELECIONE A CRIANÇA</h3>
        <div class="perfil-container"
            style="width:50vw; display: flex;flex-direction: column; justify-content: center; align-items: center;gap: 1vw; margin-top: 2vw;">
            <div class="criancas" style="overflow-y: auto; width: 35vw; max-height: 20vw; display: flex;flex-direction: column; justify-content: start; align-items: center;gap: 1vw;">
            <?php
                while ($row_crianca = mysqli_fetch_assoc($result)) {
                    $nome_crianca = $row_crianca['nome'];
                    $foto = $row_crianca['foto'];
                    $id_crianca = $row_crianca['cria_id']; // Supondo que há um campo 'id' na sua tabela

                    echo "<a href='../php/perfilCrianca.php?id=$id_crianca'>"; // Adicione o id da criança à URL
                    echo "<span style='display: flex;flex-direction: row; justify-content: start; align-items: center;gap: 1vw; background-color: #3C3577; color: white;padding: 0.5vw 1vw; width: 30vw' class='rounded-4'>";
                    if(!empty($foto)){
                    echo "<img src='$foto' alt='' class='rounded-4' style='width: 5vw; height: 5vw; object-fit: cover'>";
                    }else{
                    echo "<img src='../img/fundo_foto_padrao.png' alt='' class='rounded-4' style='width: 5vw; height: 5vw; object-fit: cover'>";
                    }
                    echo "<div class='perfil-info-usuario'>";
                    echo "<p style='margin: 0; font-size: 18px; color=white;'>$nome_crianca</p>";
                    echo "</div>";
                    echo "</span>";
                    echo "</a>";
                }
            ?>
            </div>
            
            <span
                style="display: flex;flex-direction: row; justify-content: start; align-items: center;gap: 1vw; background-color: #3C3577; padding: 0.5vw 1vw; margin-top: 3vw;"
                class="rounded-4">
                <a href="adicionarCrianca.php" style="margin: 0; font-size: 25px; font-weight: 600; text-decoration: none; color: #fff">+</a>
            </span>
        </div>
    </div>
    <div class="home-menu-mobile col-4">
        <div class="home-menu-container-mobile row justify-content-center align-items-center">
            <div class="home-menu-item col">
                <a href="home_responsavel.php">
                    <i class="ph ph-house"></i>
                    <p>Início</p>
                </a>
            </div>
            <div class="home-menu-item col">
                <a href="chat.html">
                    <i class="ph ph-chat-circle-dots"></i>
                    <p>Mensagens</p>
                </a>
            </div>
            <div class="home-menu-item col">
                <a href="<?php echo ($count_transporte > 0) ? 'seu_transporte_com.php?trans_id='.$trans_id_crianca.'' : '../html/seu_transporte_sem.html'; ?>">
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
</body>

</html>