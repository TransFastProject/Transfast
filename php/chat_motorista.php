<?php
include_once 'conexao.php';
session_start();

$moto_nome = "SELECT nome FROM motorista WHERE moto_cpf='" . $_SESSION['moto_cpf'] . "'";
$link_moto = mysqli_query($sql, $moto_nome);
$linked_moto = mysqli_fetch_assoc($link_moto);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Escolas</title>
	<meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/estilo.css">
	<link rel="stylesheet" href="../css/gerenciamento.css">
    <link rel="stylesheet" href="../css/chat.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
	<script type="text/JavaScript"></script>
</head>

<body>
	<div id="gere_menu">
	<div class="btn_expandir">
		<i class="bi bi-caret-right-square"></i>
		</div>
		<div>
			<?php
			include "conexao.php";
			if ($sql === false) {
				die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
			}
			$moto_cpf = $_SESSION['moto_cpf'];
			$result = mysqli_query($sql, "SELECT foto FROM motorista WHERE moto_cpf = '$moto_cpf'");
			if ($result) {
				$rowft = mysqli_fetch_assoc($result);
				$imagem = $rowft['foto'];
				if ($imagem) {
					echo '<img src="data:image/jpeg;base64,' . base64_encode($imagem) . '" style="border-radius: 50%; width: 11vw; height: 11vw; object-fit: cover;">';
				} else {
					echo '<img src="../img/fundo_foto_padrao.png" alt="Foto do Perfil" style="width:11vw;height:11vw;">';
				}
			} else {
				echo "Erro ao obter a foto do banco de dados: " . mysqli_error($sql);
			}
			?>
			<p>Bem Vindo<br>
				<?php echo $linked_moto['nome'] . PHP_EOL ?>
			</p>
		</div>
		<div>
			<br />
			<div class="gere_links"><a href="gere_inicio.php">Home</a></div><br />
			<div class="gere_links"><a href="gere_revisao.php">Revisão</a></div><br />
			<div class="gere_links"><a href="gere_criancas_escolas.php">Crianças</a></div><br />
			<div class="gere_links"><a href="gere_lucro.php">Lucro</a></div><br />
			<div class="gere_links"><a href="gere_perfil.php">Perfil</a></div><br />
			<div class="gere_links"><a href="gere_chamada_escolas.php">Chamada</a></div><br />
			<div id="gere_local"><a href="">Chat</a></div><br />
		</div>

		<footer id="gere_sair"><a href="sair.php">Sair</a></footer>
	</div>

	<div id="gere_conteudo_chat">
    <div class="chat-container" style="width: 60vw; height: 38vw; display: flex; flex-direction: row; justify-content: center; align-items: center; color: #fff; border-radius: 2vw; margin-top: 3vw;">
        <div class="sidebar-chat" style="height: 100%; width: 20vw; background-color: #3C3577; border-radius: 2vw 0 0 2vw; padding: 10px 10px;">
            <div class="sidebar-chat-container" style="display: flex;flex-direction: column;justify-content: center;align-items: center; padding: 1vw 0 0 0;">
                <p style="margin: 0;">Suas mensagens</p>
                <div class="sidebar-mensagens" style="background-color: #1E184C; padding: 8px; width: 100%; justify-content: start; align-items: center; border-radius: 0.5vw; margin-top: 1vw;">
                    <div class="sidebar-mensagens-item" style="display: flex; flex-direction: row;justify-content: start;align-items: center; gap: 10px;">
                        <img src="../img/foto_motorista.png" alt="" style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">
                        <div class="mensagem-info" style="display: flex; flex-direction: column; justify-content: center; align-items: start;">
                            <p style="margin: 0; font-size: 16px;">Tia Sany</p>
                            <p style="margin: 0; font-size: 12px;">Você: eae veia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat" style="height: 100%; width: 100%; background-color: #F5F5F5; display: flex; flex-direction: column; justify-content: center; align-items: center; border-radius: 0 2vw 2vw 0;">
            <div class="chat-header" style="width: 100%; height: 3vw; background-color: #E4E4E4; display: flex; justify-content: start; align-items: center; padding: 2vw; border-radius: 0 2vw 0 0;">
                <span style="display: flex;flex-direction: row;justify-content: center;align-items: center; gap: 10px;">
                    <img src="../img/foto_motorista.png" alt="" style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">
                    <p style="margin: 0; color: #1E184C; font-weight: 500; font-size: 18px;">Tia Sany</p>
                </span>
            </div>
            <div class="chat-mensagens" style="height: 100%; width: 100%; display: flex; flex-direction: column; justify-content: start; align-items: center; padding: 2vw;">
                <div class="chat-left" style="width: 100%; display: flex; justify-content: start; align-items: center;">
                    <div class="chat-left-item" style="width: 19vw;padding: 10px; background-color: #1E184C; display: flex; justify-content: start; align-items: center; border-radius: 1vw;">
                        <p style="margin: 0; font-size: 14px;">Lorem ipsum dolor sit amet consectetur.</p>
                    </div>
                </div>
                    
                <div class="chat-right" style="width: 100%; display: flex; justify-content: end; align-items: center; border-radius: 0 2vw 2vw 0;">
                    <div class="chat-right-item" style="width: 19vw;padding: 10px; background-color: #1E184C; display: flex; justify-content: start; align-items: center; border-radius: 1vw;">
                        <p style="margin: 0; font-size: 14px;">Lorem ipsum dolor sit amet consectetur.</p>
                    </div>
                </div>

            </div>
            <div class="chat-bottom">
                <input type="text" placeholder="Escreva sua mensagem">
                <button><i class="ph ph-paper-plane"></i></button>
            </div>
        </div>
    </div>
	</div>
</body>

</html>