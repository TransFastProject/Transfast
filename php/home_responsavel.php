<?php
session_start();
include_once "conexao.php";

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
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/responsavel.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Importe o Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Importe o Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <title>Busque seu transporte</title>

    <style>
        .transportes-item,
        .card-transporte,
        .swiper-slide {
            width: 20vw;
        }

        .swiper-slide {
            gap: 1vw;
        }

        body {
            overflow-x: hidden;
            margin: 0;
            /* Remova a margem padrão do corpo */
            padding: 0;
            /* Remova o preenchimento padrão do corpo */
        }

        .transportes-container {
            width: 90%;
            /* Defina a largura desejada para o container, pode ser em porcentagem, pixels, ou outra unidade */
            max-width: 90%;
            margin: 0 auto;
            /* Centralize o container horizontalmente */
            position: relative;
            /* Torna possível posicionar as setas em relação a este contêiner */
            overflow: hidden;
            display: flex;
            justify-content: start;
            align-items: center;
        }


        .transporte {
            width: 100%;
            position: relative;
        }

        .swiper-button-next,
        .swiper-button-prev {
            cursor: pointer;
            position: absolute;
            /* Posiciona as setas de forma absoluta em relação ao contêiner pai */
            height: 100%;
            top: 0;
            color: #fff;
        }

        .swiper-button-next {
            right: 0;
            /* Posiciona a seta 'próximo' à direita do contêiner pai */
        }

        .swiper-button-prev {
            left: 0;
            /* Posiciona a seta 'anterior' à esquerda do contêiner pai */
        }
    </style>
</head>

<body class="home-body">
    <header class="home-header row justify-content-center align-items-center g-2 col-12">
        <div class="col-4">
            <a href="">
                <img src="../img/logo_v2.png" alt="Logo Transfast" class="home-logo">
            </a>
        </div>


        <div class="home-searchbar col-4">
            <form action="" method="post">
                <input type="text" name="" id="" placeholder="Procure seu transporte..." class="searchbar">
                <label for="pesquisar"><i class="ph ph-magnifying-glass"></i></label>
                <input type="submit" id="pesquisar" name="pesquisar" style="display: none;">
            </form>
        </div>

        <div class="home-menu col-4">
            <div class="home-menu-container row justify-content-center align-items-center">
                <div class="home-menu-item col">
                    <a href="home_responsavel.html">
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
                    <a
                        href="<?php echo ($count_transporte > 0) ? 'seu_transporte_com.php?trans_id='.$trans_id_crianca.'' : '../html/seu_transporte_sem.html'; ?>">
                        <i class="ph ph-van"></i>
                        <p>Seu transporte</p>
                    </a>
                </div>
                <div class="home-menu-item col">
                    <a href="../php/perfilResponsavel.php">
                        <i class="ph ph-user"></i>
                        <p>Perfil</p>
                    </a>
                </div>
            </div>

        </div>
    </header>
    <div class="transporte">
        <div class="swiper-container transportes-container">
            <div class="swiper-wrapper" id="carrossel-container" style="position: relative;">
                <?php foreach($transportes as $index => $transporte): ?>
                    <div class="swiper-slide">
                        <a href="#" class="card-transporte card-<?php echo $index + 1; ?>"
                            data-nome="Nome: <?php echo $transporte['nome_motorista']; ?>"
                            data-bairro="Bairro: <?php echo $transporte['bairro']; ?>"
                            data-estado="Estado: <?php echo $transporte['estado']; ?>"
                            data-cidade="Cidade: <?php echo $transporte['cidade']; ?>"
                            data-monitor="Monitor: <?php echo $transporte['monitor']; ?>"
                            data-foto="<?php echo base64_encode($transporte['foto_moto']); ?>"
                            data-telefone="Telefone: <?php echo $transporte['telefone_motorista']; ?>">
                            <div class="transportes-item">
                                <img src="../img/image 5.png" alt="" class="img-transporte" style="width: 20vw">
                                <div class="transporte-info">
                                    <div class="transporte-info-i">
                                        <p>
                                            <?php echo $transporte['nome_motorista']; ?>
                                        </p>
                                        <ul>
                                            <li>
                                                <?php echo $transporte['bairro']; ?>
                                            </li>
                                            <li>
                                                <?php echo $transporte['telefone_motorista']; ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="transporte-info-i">
                                        <img src="/img/Group11.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>



    <div class="transportes" style="margin-top: 3vw;">
        <h3>Melhores avaliações</h3>
        <div class="transportes-container">
        </div>
    </div>

    <dialog id="home-dialog" class="">
        <button id="fechar-modal"><i class="ph ph-x"></i></button>
        <div class="informacoes-modal">
            <div class="modal-informacao">
                <div class="motorista">
                    <img src="/img/foto_motorista.png" alt="foto do motorista" class="foto"
                        style="border-radius: 100%; width: 8vw; height: 8vw;object-fit: cover">
                    <div class="avaliacao">
                        <i class="ph ph-star"></i>
                        <i class="ph ph-star"></i>
                        <i class="ph ph-star"></i>
                        <i class="ph ph-star"></i>
                        <i class="ph ph-star"></i>
                    </div>
                    <p>Status da vistoria:</p>
                    <p class="vistoria">
                        <?php
                        $consulta_transporte = $sql->query("SELECT * FROM vistoria WHERE moto_cpf = '".$transporte['moto_cpf']."' ");
                        $consulta_vistoria = mysqli_fetch_assoc($consulta_transporte);

                        if($consulta_vistoria['item01'] == '1' && $consulta_vistoria['item02'] == '1' && $consulta_vistoria['item03'] == '1' && $consulta_vistoria['item04'] == '1' && $consulta_vistoria['item05'] == '1' && $consulta_vistoria['item06'] == '1' && $consulta_vistoria['item07'] == '1' && $consulta_vistoria['item08'] == '1' && $consulta_vistoria['item09'] == '1' && $consulta_vistoria['item10'] == '1') {
                            echo 'Completa';
                        } else {
                            echo 'Incompleta';
                        }
                        ?>
                    </p>
                </div>
                <div class="motorista-informacoes">
                    <p class="nome"></p>
                    <p class="telefone"></p>
                    <p class="bairro"></p>
                    <p class="estado"></p>
                    <p class="cidade"></p>
                    <p class="monitor"></p>
                </div>
            </div>
            <div class="contato" style="width: 100%; display: flex; justify-content: center;">
                <a href="" class="btn-contato">
                    Entrar em contato
                    <i class="ph ph-chat-circle-dots"></i>
                </a>
            </div>
        </div>
    </dialog>

    <script src="../js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Adicione o script Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 4, // Ajuste este valor conforme necessário
            slidesPerGroup: 2, // Ajuste este valor conforme você deseja
            spaceBetween: 10, // Espaçamento entre os slides
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

        });
    </script>


</body>

</html>