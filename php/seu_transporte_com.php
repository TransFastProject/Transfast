<?php
session_start();
include('conexao.php');

// Verifica se o parâmetro trans_id está presente na URL
if (isset($_GET['trans_id'])) {
    // Obtém o trans_id da URL
    $trans_id_motorista = $_GET['trans_id'];

    // Consulta para obter informações do transporte e do motorista associado
    $sql_obter_info_motorista = "SELECT t.*, m.nome AS nome_motorista, m.telefone AS telefone_motorista, m.foto AS foto_motorista
                                  FROM transporte t
                                  JOIN motorista m ON t.moto_cpf = m.moto_cpf
                                  WHERE t.trans_id = ?";
    $stmt_obter_info_motorista = mysqli_prepare($sql, $sql_obter_info_motorista);

    // Verifica se a preparação da declaração foi bem-sucedida
    if ($stmt_obter_info_motorista) {
        mysqli_stmt_bind_param($stmt_obter_info_motorista, "i", $trans_id_motorista);
        mysqli_stmt_execute($stmt_obter_info_motorista);
        $result_obter_info_motorista = mysqli_stmt_get_result($stmt_obter_info_motorista);

        // Verifica se a execução da preparação foi bem-sucedida
        if ($result_obter_info_motorista) {
            // Exemplo de exibição das informações do motorista
            if ($row_info_motorista = mysqli_fetch_assoc($result_obter_info_motorista)) {
                // Exiba as informações do motorista, substitua com os nomes reais dos campos do seu banco de dados
                $nome = $row_info_motorista['nome'];
                $telefone_motorista = $row_info_motorista['telefone_motorista'];
                $foto = $row_info_motorista['foto'];
                $foto_motorista = $row_info_motorista['foto_motorista'];
                $estado = $row_info_motorista['estado'];
                $cidade = $row_info_motorista['cidade'];
                $bairro = $row_info_motorista['bairro'];
                $monitor = $row_info_motorista['monitor'];

                // Verifica se o motorista tem uma foto
                if (empty($foto_motorista) || $foto_motorista === null) {
                    // Se não tiver, use uma imagem padrão
                    $foto_motorista = '../img/fundo_foto_padrao.png';
                }

                // Verifica se o motorista tem uma foto
                if (empty($monitor) || $monitor === null) {
                    $monitor = 'Não informado';
                }

                // Verifica se a vistoria está completa
                $vistoria_completa = true;

                // Supondo que o moto_cpf do motorista seja obtido da consulta anterior
                $moto_cpf = $row_info_motorista['moto_cpf'];

                // Consulta para verificar se todas as colunas da tabela vistoria são diferentes de "0" para o moto_cpf específico
                $sql_verificar_vistoria = "SELECT * FROM vistoria WHERE moto_cpf = ? AND (item01 != '0' OR item02 != '0' OR item03 != '0' OR item04 != '0' OR item05 != '0' OR item06 != '0' OR item07 != '0' OR item08 != '0' OR item09 != '0' OR item10 != '0')";
                $stmt_verificar_vistoria = mysqli_prepare($sql, $sql_verificar_vistoria);

                // Verifica se a preparação da declaração da vistoria foi bem-sucedida
                if ($stmt_verificar_vistoria) {
                    mysqli_stmt_bind_param($stmt_verificar_vistoria, "s", $moto_cpf);
                    mysqli_stmt_execute($stmt_verificar_vistoria);
                    $result_verificar_vistoria = mysqli_stmt_get_result($stmt_verificar_vistoria);

                    // Verifica se a execução da declaração da vistoria foi bem-sucedida
                    if ($result_verificar_vistoria) {
                        // Verifica se há resultados na consulta da vistoria
                        if ($row_verificar_vistoria = mysqli_fetch_assoc($result_verificar_vistoria)) {
                            // Todas as colunas são diferentes de "0"
                            $vistoria_completa = true;
                        } else {
                            // Pelo menos uma coluna é "0"
                            $vistoria_completa = false;
                        }
                    } else {
                        // Se a execução da declaração da vistoria não retornar resultados, pode ser considerado como vistoria incompleta
                        $vistoria_completa = false;
                    }

                    if ($vistoria_completa) {
                        $vistoria = "Completa";
                    } else {
                        $vistoria = "Incompleta";
                    }
                } else {
                    die('Erro na preparação da declaração da vistoria: ' . mysqli_error($sql));
                }
            } else {
                die('Consulta inválida ou trans_id não encontrado.');
            }
        } else {
            die('Erro na execução da preparação da declaração: ' . mysqli_error($sql));
        }
    } else {
        die('Erro na preparação da declaração: ' . mysqli_error($sql));
    }
} else {
    // Se não houver trans_id na URL, redirecione ou tome alguma ação padrão
    header("Location: ../php/home_responsavel.php");
    exit();
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <title>Seu transporte</title>
</head>

<body class="home-body" id="transporte-body"
    style="display: flex; height: 100%; flex-direction: column; justify-content: center; align-items: center;">
    <header class="home-header row justify-content-center align-items-center g-2 col-12"
        style="position: absolute;top: 0;padding: 0 2vw; display: relative;">
        <span class="col-6"
            style="display: flex;flex-direction: row; justify-content: start; align-items: center; gap: 4vw;">
            <a href="home_responsavel.php">
                <img src="../img/logo_v2.png" alt="Logo Transfast" class="home-logo">
            </a>
            <span style="display: flex;flex-direction: row; justify-content: center; align-items: center; gap: 2vw;">
                <a href=""
                    style="padding: 1vw 1.5vw; background-color: #3C3577; border-radius: 1vw;text-decoration: none;color: #fff;" id="chamada">CHAMADA</a>
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
                    <a href="seu_transporte_com.php">
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

    <div class="comTransporte">
        <div class="banner-motorista">
          <img src="../img/header_background.png" alt="Foto do Perfil">
        </div>
        <div class="foto-perfil">
        <?php
        $result = mysqli_query($sql, "SELECT foto FROM motorista WHERE moto_cpf = '$moto_cpf'");
      if ($result) {
        $rowft = mysqli_fetch_assoc($result);
        $foto_transporte = $rowft['foto'];
        if (!empty($foto_transporte)) {
          echo '<img src="data:image/jpeg;base64,' . base64_encode($foto_transporte) . '"style="border-radius: 50%; width: 11vw; height: 11vw; object-fit: cover;"';
        } else {
          echo '<img src="../img/fundo_foto_padrao.png" alt="Foto do Perfil">';
        }
      } else {
        echo "Erro ao obter a foto do banco de dados: " . mysqli_error($sql);
      }
      ?>
            <span>
                <a href="">
                    <i class="ph ph-chat-circle-dots"></i>
                </a>
                <a href="#" id="avaliar">
                    <i class="ph ph-star"></i>
                </a>
            </span>

        </div>
        <div class="informacoes">
            <div class="info-transporte">
                <div class="info-item">
                    <p class="titulo-info" style="color: #fff; font-weight: 600;"><?php echo $nome; ?></p>
                    <p class="info"><?php echo $telefone_motorista; ?></p>
                </div>
                <div class="info-item">
                    <p class="titulo-info">Monitor</p>
                    <p class="info"><?php echo $monitor; ?></p>
                </div>
                <div class="info-item">
                    <p class="titulo-info">Vistoria</p>
                    <p class="info"><?php echo $vistoria; ?></p>
                </div>
            </div>
            <div class="info-transporte">
                <div class="info-item">
                    <p class="titulo-info">Estado</p>
                    <p class="info"><?php echo $estado; ?></p>
                </div>
                <div class="info-item">
                    <p class="titulo-info">Cidade</p>
                    <p class="info"><?php echo $cidade; ?></p>
                </div>
                <div class="info-item">
                    <p class="titulo-info">Bairro</p>
                    <p class="info"><?php echo $bairro; ?></p>
                </div>
            </div>
        </div>

    </div>

    <dialog id="modal-avaliar" style="padding: 0;">
        <p>Avalie este condutor <button id="avaliar-close" style="position: absolute; right: 2vw; height: 2vw; width: 2vw; padding: 0; display: flex; align-items: center; justify-content: center;"><i class="ph ph-x" style="margin:0"></i></button></p>
        <div class="modal-avaliacao">
            <span class="avaliacao">
                <img src="../img/yellow_star.png" alt="" class="star">
                <img src="../img/yellow_star.png" alt="" class="star">
                <img src="../img/yellow_star.png" alt="" class="star">
                <img src="../img/yellow_star.png" alt="" class="star">
                <img src="../img/purple_star.png" alt="" class="star">
            </span>
            <button id="avaliar-close">Avaliar</button>
        </div>
    </dialog>

    <dialog id="modal-chamada" style="width: 60vw; height: 40vw; padding: 0;">
        <p>CHAMADA <button id="chamada-close" style="position: absolute; right: 2vw;"><i class="ph ph-x"></i></button></p>
        <div class="modal-avaliacao" style="padding: 4vw 0;">
            <div class="chamada" style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 2vw;">
            <?php
                // Verifica se o usuário está autenticado
                if (isset($_SESSION['res_cpf'])) {
                    $responsavel_id = $_SESSION['res_cpf'];

                    // Consulta para obter informações das crianças associadas ao responsável
                    $sql_obter_criancas = "SELECT * FROM crianca WHERE res_cpf = ?";
                    $stmt_obter_criancas = mysqli_prepare($sql, $sql_obter_criancas);

                    if ($stmt_obter_criancas) {
                        mysqli_stmt_bind_param($stmt_obter_criancas, "s", $responsavel_id);
                        mysqli_stmt_execute($stmt_obter_criancas);
                        $result_obter_criancas = mysqli_stmt_get_result($stmt_obter_criancas);

                        // Itera sobre as crianças e exibe a estrutura HTML para cada uma
                        while ($row_crianca = mysqli_fetch_assoc($result_obter_criancas)) {
                            // Substitua os valores de exemplo pelos nomes reais dos campos do seu banco de dados
                            $nome_crianca = $row_crianca['nome'];
                            $foto_crianca = $row_crianca['foto']; // Substitua pelo campo correto que armazena a foto
                            $id_crianca = $row_crianca['cria_id']; // Substitua pelo campo correto que identifica cada criança

                            // Crie identificadores únicos para cada criança
                            $id_presente = 'presente_' . $id_crianca;
                            $id_ausente = 'ausente_' . $id_crianca;

                            // Exibe a estrutura HTML para cada criança
                            echo '
                            <div class="chamada-item"
                                style="display: flex; flex-direction: row; justify-content: center; align-items: center; gap: 2vw;">
                                <div class="chamada-crianca"
                                    style="display: flex; flex-direction: row; align-items: center; padding: 10px 10px; background-color: #1E184C; border-radius: 10px; color: #fff; gap: 10px; width: 25vw;">';
                                    if(!empty($foto_crianca)){
                                        echo '<img src="' . $foto_crianca . '" alt="" style="width: 4vw; height: 4vw; object-fit: cover; justify-content: start; border-radius: 10px;">';
                                    }else{
                                        echo '<img src="../img/fundo_foto_padrao.png" alt="" style="width: 4vw; height: 4vw; object-fit: cover; justify-content: start; border-radius: 10px;">';
                                    }
                                    echo '<p style="margin: 0;">' . $nome_crianca . '</p>
                                </div>
                                <div style="display: flex; gap: 1vw;">
                                    <span
                                        style="padding: 10px 10px; background-color: #1E184C; border-radius: 10px; color: #fff; display: flex; justify-content: center; align-items: center; gap: 10px;">
                                        <input type="radio" name="presenca_' . $id_crianca . '" id="' . $id_presente . '" value="presente">
                                        <label for="' . $id_presente . '">Presente</label>
                                    </span>
                                    <span
                                        style="padding: 10px 10px; border: solid 1px #1E184C;border-radius: 10px; display: flex; justify-content: center; align-items: center; gap: 10px;">
                                        <input type="radio" name="presenca_' . $id_crianca . '" id="' . $id_ausente . '" value="ausente">
                                        <label for="' . $id_ausente . '">Ausente</label>
                                    </span>
                                </div>
                            </div>
                            ';
                        }

                        mysqli_stmt_close($stmt_obter_criancas);
                    } else {
                        die('Erro na preparação da consulta: ' . mysqli_error($sql));
                    }
                }
                ?>

            </div>
            <button onclick="salvarPresenca()">SALVAR</button>
        </div>
    </dialog>
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
                <a href="">
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

    <script>
        const avaliar = document.getElementById("avaliar")
        const avaliarClose = document.getElementById("avaliar-close")
        const modalAvaliar = document.getElementById("modal-avaliar")

        const chamada = document.getElementById("chamada")
        const chamadaClose = document.getElementById("chamada-close")
        const modalChamada = document.getElementById("modal-chamada")

        avaliar.onclick = function () {
            modalAvaliar.showModal()
        }

        avaliarClose.onclick = function () {
            modalAvaliar.close()
        }

        chamada.onclick = function (event) {
            modalChamada.showModal()
            event.preventDefault();
        }

        chamadaClose.onclick = function () {
            modalChamada.close()
        }

        function salvarPresenca() {
            // Obtenha todos os radio buttons marcados
            var checkboxes = document.querySelectorAll('input[type=radio]:checked');

            // Crie um array para armazenar os dados a serem enviados ao servidor
            var data = [];

            // Itere sobre os radio buttons marcados e adicione ao array
            checkboxes.forEach(function (checkbox) {
                data.push({
                    cria_id: checkbox.name.split('_')[1], // Obtém o ID da criança
                    presenca: checkbox.value
                });
            });

            // Envie os dados ao servidor usando uma solicitação AJAX
            // Exemplo usando jQuery:
            $.ajax({
                type: 'POST',
                url: 'salvar_presenca.php',
                data: { presenca_data: data },
                success: function (response) {
                    // Faça algo com a resposta do servidor, se necessário
                    console.log(response);
                    // Feche o modal após salvar
                    document.getElementById("modal-chamada").close();
                }
            });
        }

    </script>
</body>

</html>