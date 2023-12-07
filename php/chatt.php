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
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <title>Seu transporte</title>

    <script type="text/javascript">
        function scrollChatToEnd() {
            var chatDiv = document.getElementById('chat');
            chatDiv.scrollTop = chatDiv.scrollHeight;
        }

        function atualizarChat() {
            var chatDiv = document.getElementById('chat');

            // Realizar uma solicitação AJAX
            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    // Verificar se o usuário não está rolando para cima
                    var isScrolledToBottom = chatDiv.scrollHeight - chatDiv.clientHeight <= chatDiv.scrollTop + 1;

                    // Atualizar o conteúdo da div 'chat'
                    chatDiv.innerHTML = req.responseText;

                    // Se o usuário estava rolando para baixo antes da atualização, manter o scroll para baixo
                    if (isScrolledToBottom) {
                        scrollChatToEnd();

                    }
                }
            };
            req.open('GET', 'chat.php', true);
            req.send();
        }

        // Chamar a função para atualizar o chat a cada 0,5 segundos
        setInterval(atualizarChat, 500);

        function atualizarUltimaMensagem() {
            var ultimaMensagemDiv = document.getElementById('ultima-mensagem');

            // Realizar uma solicitação AJAX
            var req = new XMLHttpRequest();
            req.onreadystatechange = function () {
                if (req.readyState == 4 && req.status == 200) {
                    // Atualizar o conteúdo da div 'ultima-mensagem'
                    ultimaMensagemDiv.innerHTML = req.responseText;
                }
            };
            req.open('GET', 'ult_msg.php', true);
            req.send();
        }
        window.onload = function () {
            atualizarUltimaMensagem();
        };
        // Atualizar o "ultimo chat" a cada 0,5 segundos
        setInterval(atualizarUltimaMensagem, 500);

        function enviarMensagem() {
    var mensagemInput = document.getElementsByName('mensagem')[0];
    var mensagem = mensagemInput.value;

    var req = new XMLHttpRequest();
    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            console.log(req.status, req.responseText); // Adicione este log
            if (req.status == 200) {
                mensagemInput.value = '';
                atualizarChat();
            }
        }
    };
    req.open('POST', 'chatt.php', true);
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    req.send('&mensagem=' + mensagem);

    return false;
}

        
    </script>


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

    <!--- janela do chat (o fundo onde fica tudo do chat) ----------->
    <div class="chat-container"
        style="width: 60vw; height: 38vw; display: flex; flex-direction: row; justify-content: center; align-items: center; color: #fff; border-radius: 2vw; margin-top: 3vw;">

        <!-- parte lateral esquerda do chat (onde aparece o perfil)--->
        <div class="sidebar-chat"
            style="height: 100%; width: 20vw; background-color: #3C3577; border-radius: 2vw 0 0 2vw; padding: 10px 10px;">

            <div class="sidebar-chat-container"
                style="display: flex;flex-direction: column;justify-content: center;align-items: center; padding: 1vw 0 0 0;">
                <p style="margin: 0;">Suas mensagens</p>

                <div class="sidebar-mensagens"
                    style="background-color: #3C3577; width: 100%; justify-content: start; align-items: center; ; margin-top: 1vw;">
                    <!-- abaixo, o perfil do motorista (só vai aparecer se o responsável tiver um motorista) --->

                    <?php
                    // Verifique se a criança associada ao responsável tem um trans_id
                    $query = "SELECT trans_id FROM crianca WHERE res_cpf = :res_cpf";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":res_cpf", $responsavelCpf, PDO::PARAM_STR);
                    $stmt->execute();
                    $crianca = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>

 <?php if ($crianca && $crianca['trans_id']&& $crianca['trans_id'] != 1) : ?>
    <div id="sidebar-mensagens-item" class="sidebar-mensagens-item"
        style=" background-color: #1E184C;display: flex; padding: 8px; flex-direction: row;justify-content: start;align-items: center; gap: 10px; border-radius: 0.5vw">

                        <?php
                        include("bd_conect.php");
                        include("conexao.php");
                        function obterDadosTransporte($pdo, $responsavelCpf)
                        {
                            $query = "SELECT t.nome, t.foto
                                   FROM responsavel r
                                   JOIN crianca c ON r.res_cpf = c.res_cpf
                                   JOIN transporte t ON c.trans_id = t.trans_id
                                   WHERE r.res_cpf = :res_cpf";
    
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(":res_cpf", $responsavelCpf, PDO::PARAM_STR);
                            $stmt->execute();
    
                            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
                            return $resultado;
                        }
                        function obterFotoMotorista($pdo, $responsavelCpf)
                        {
                            $query = "SELECT m.foto
              FROM responsavel r
              JOIN crianca c ON r.res_cpf = c.res_cpf
              JOIN transporte t ON c.trans_id = t.trans_id
              JOIN motorista m ON t.moto_cpf = m.moto_cpf
              WHERE r.res_cpf = :res_cpf";

                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(":res_cpf", $responsavelCpf, PDO::PARAM_STR);
                            $stmt->execute();

                            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($resultado && $resultado['foto']) {
                                // Retorna a foto em base64
                                return base64_encode($resultado['foto']);
                            } else {
                                return null;
                            }
                        }

                        $responsavelCpf = $_SESSION["res_cpf"];

                        $fotoMotoristaBase64 = obterFotoMotorista($pdo, $responsavelCpf);

                        // Exibir a foto no HTML
                        if ($fotoMotoristaBase64) :
                        ?>
                            <img src="data:image/jpeg;base64,<?= $fotoMotoristaBase64 ?>" alt="Foto"
                                style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">
                        <?php else : ?>
                            <img src="../img/fundo_foto_padrao.png" alt="Foto padrão"
                                style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">
                        <?php endif; ?>
                
                        <?php
                        $dadosTransporte = obterDadosTransporte($pdo, $responsavelCpf);
                
                        if ($resultado) :
                        ?> 
                        <div class="mensagem-info"style="display: flex; flex-direction: column; justify-content: center; align-items: start;">
                            <p style="text-transform: capitalize; margin: 0; color: #ffffff; font-weight: 500; font-size: 18px;"><?= $dadosTransporte['nome'] ?></p>
                        <?php else : ?>
                            <p style="margin: 0; color: #1E184C; font-weight: 500; font-size: 18px;">Motorista Sem Nome</p>
                        <?php endif; ?>
                            
                            <p style="margin: 0; font-size: 12px;" id="ultima-mensagem">
                                <?php include("ult_msg.php"); ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
                    <!------ Acima, o perfil do motorista (onde vai ser clicado e aparecerá o chat) ----------->
                </div>
            </div>
        </div>
        <!-- na div acima, a parte lateral erquerda do chat--------->

        <div class="chat"
            style="height: 100%; width: 100%; background-color: #F5F5F5; display: flex; flex-direction: column; justify-content: center; align-items: center; border-radius: 0 2vw 2vw 0;">
            <!------ abaixo, aparecerá junto quando clicar no perfil ----->
                  <h1 id="titulo-chat" style="color: #1E184C;">Bem-vindo ao Chat!</h1>
                  <h3 id="subtitulo-chat" style="color: #3C3577;">Aqui você tira dúvidas com sua van!</h3>

            <div id="chat-header" class="chat-header"
                style="display: none; width: 100%; height: 3vw; background-color: #E4E4E4; justify-content: start; align-items: center; padding: 2vw; border-radius: 0 2vw 0 0;">
                <span style="display: flex;flex-direction: row;justify-content: center;align-items: center; gap: 10px;">
                
                    <?php
                    $fotoMotoristaBase64 = obterFotoMotorista($pdo, $responsavelCpf);

                    // Exibir a foto no HTML
                    if ($fotoMotoristaBase64) {
                        echo '<img src="data:image/jpeg;base64,' . $fotoMotoristaBase64 . '" alt="Foto do motorista"
                        style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">';
                    } else {
                        echo '<img src="../img/fundo_foto_padrao.png" alt="Foto padrão"
                        style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">';
                    }
                    ?>
                    <?php
                    include("bd_conect.php");
                    include("conexao.php");

                    $dadosTransporte = obterDadosTransporte($pdo, $responsavelCpf);

                    // Verifica se a consulta retornou algum resultado
                    if ($resultado) {
                        // Exibe o nome associado à tabela transporte
                        echo '<p style="text-transform: capitalize;
                         margin: 0; color: #1E184C; font-weight: 500; font-size: 18px;">' . $dadosTransporte['nome'] . '</p>';
                    } else {
                        // Se não encontrar o nome, você pode lidar com isso de acordo com a sua lógica
                        echo '<p style="margin: 0; color: #1E184C; font-weight: 500; font-size: 18px;">Motorista Sem Nome</p>';
                    }

                    ?>
                </span>
            </div>

            <!-------- Acima, aparecerá só quando clicar no perfil ------->
         
            <div id="chat" class="chat-mensagens"
                style=" display: none; height: 100%; width: 100%; flex-direction: column; justify-content: start; align-items: center; padding: 2vw; overflow-y: auto; ">
                <!--- dentro dessa div é onde aparecem as mensagens (direita e esquerda) -------->
                <!----- CONTEUDO DO CHAT.PHP ----------->
                <!-- o conteudo do chat.php aparecerá só quando ele clicar no perfil de chat do motorista-->
            </div>

            <form method="POST" action="javascript:void(0);" onsubmit="return enviarMensagem();">
                <div id="chat-bottom" class="chat-bottom" style="display: none;">
                    <input name="mensagem" type="text" placeholder="Escreva sua mensagem">
                    <button type="submit"><i class="ph ph-paper-plane"></i></button>
                </div>
            </form>

        </div>
    </div>
    <!-------- Fim da div que tem tudo --------->

    <?php
    include("bd_conect.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mensagem = $_POST['mensagem'];
        // Utilize as variáveis $responsavelCpf e $motoCpf na sua inserção no banco de dados
        $pdo->query("INSERT INTO chat (mensagem, tipo, res_cpf, moto_cpf) VALUES ('$mensagem', 'responsavel', '$responsavelCpf', '$motoCpf')");
        
    }
    ?>
    
    <!-- ocultar e aparecer elementos -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Encontrar os elementos HTML
            var chatHeader = document.querySelector('.chat-header');
            var chatMensagens = document.querySelector('.chat-mensagens');
            var chatBottom = document.querySelector('.chat-bottom');
            var h1Element = document.querySelector('h1');
            var h3Element = document.querySelector('h3');
            var sidebarItem = document.querySelector('.sidebar-mensagens-item');

            // Função para mostrar as divs e ocultar o H1 e H3
            function mostrarChat() {
                // Esconder os elementos h1 e h3
                document.getElementById('titulo-chat').style.display = 'none';
                document.getElementById('subtitulo-chat').style.display = 'none';
                document.getElementById('chat-header').style.display = 'none';
                // Mostrar as divs do chat
                document.getElementById('chat-header').style.display = 'flex';
                document.getElementById('chat').style.display = 'flex';
                document.getElementById('chat-bottom').style.display = 'flex';
            }

            // Adicionar um ouvinte de evento de clique à div sidebar-mensagens-item
            if (sidebarItem) {
                sidebarItem.addEventListener('click', mostrarChat);
            }
        });
    </script>
</body>
</html>