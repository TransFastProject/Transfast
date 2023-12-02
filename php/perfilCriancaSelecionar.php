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
                    <a href="home_responsavel.html">
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
                    <a href="">
                        <i class="ph ph-van"></i>
                        <p>Seu transporte</p>
                    </a>
                </div>
                <div class="home-menu-item col">
                    <a href="">
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
                    echo "<span style='display: flex;flex-direction: row; justify-content: start; align-items: center;gap: 1vw; background-color: #3C3577; padding: 0.5vw 1vw; width: 30vw' class='rounded-4'>";
                    echo "<img src='$foto' alt='' class='rounded-4' style='width: 5vw; height: 5vw; object-fit: cover'>";
                    echo "<div class='perfil-info-usuario'>";
                    echo "<p style='margin: 0; font-size: 18px;'>$nome_crianca</p>";
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
</body>

</html>