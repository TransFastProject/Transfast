<?php
include_once 'conexao.php';
include("bd_conect.php");

session_start();

// Adicione as seguintes linhas para obter as informações do motorista
$moto_nome = "SELECT nome FROM motorista WHERE moto_cpf='" . $_SESSION['moto_cpf'] . "'";
$link_moto = mysqli_query($sql, $moto_nome);
$linked_moto = mysqli_fetch_assoc($link_moto);

// Adicione as seguintes linhas para obter o CPF do responsável associado ao motorista
$responsavelCpfQuery = "SELECT res_cpf FROM crianca WHERE trans_id = (SELECT trans_id FROM transporte WHERE moto_cpf = :moto_cpf)";
$stmtResponsavelCpf = $pdo->prepare($responsavelCpfQuery);
$stmtResponsavelCpf->bindParam(":moto_cpf", $_SESSION['moto_cpf'], PDO::PARAM_STR);
$stmtResponsavelCpf->execute();
$responsavelCpfResult = $stmtResponsavelCpf->fetch(PDO::FETCH_ASSOC);

if ($responsavelCpfResult && isset($responsavelCpfResult['res_cpf'])) {
	$responsavelCpf = $responsavelCpfResult['res_cpf'];
} else {
	// Lide com a situação em que o CPF do responsável não foi encontrado
	// Pode ser interessante exibir uma mensagem de erro ou tomar outra ação apropriada
	// Por exemplo, redirecionar o usuário para uma página de erro.
	// Você pode personalizar essa parte de acordo com a lógica do seu aplicativo.
	echo "Erro: CPF do responsável não encontrado.";
	exit();
}

// Defina $motoCpf com o valor da sessão
$motoCpf = $_SESSION['moto_cpf'];

?>
<!DOCTYPE html>
<html lang="pt-br">
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
		req.open('GET', 'chat2.php', true);
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
		req.open('POST', 'chat_motorista.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.send('&mensagem=' + mensagem);

		return false;
	}


</script>

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
		<!--- janela do chat (o fundo onde fica tudo do chat) ----------->
		<div class="chat-container"
			style="width: 60vw; height: 38vw; display: flex; flex-direction: row; justify-content: center; align-items: center; color: #fff; border-radius: 2vw; margin-top: 3vw;">

			<!-- parte lateral esquerda do chat (onde aparece o perfil)--->
			<div class="sidebar-chat"
				style="height: 100%; width: 20vw; background-color: #3C3577; border-radius: 2vw 0 0 2vw; padding: 10px 10px;">

				<div class="sidebar-chat-container"
					style="display: flex;flex-direction: column;justify-content: center;align-items: center; padding: 1vw 0 0 0;">
					<p style="margin: 0; font-size: 1vw;">Suas mensagens</p>

					<div class="sidebar-mensagens"
						style="background-color: #3C3577; width: 100%; justify-content: start; align-items: center; ; margin-top: 1vw;">
						<!-- abaixo, o perfil do motorista (só vai aparecer se o responsável tiver um motorista) --->

						<?php
						include("bd_conect.php");

						// Verifique se a criança associada ao responsável tem um trans_id
						$query = "SELECT trans_id FROM crianca WHERE res_cpf = :res_cpf";
						$stmt = $pdo->prepare($query);
						$stmt->bindParam(":res_cpf", $responsavelCpf, PDO::PARAM_STR);
						$stmt->execute();
						$crianca = $stmt->fetch(PDO::FETCH_ASSOC);

						// Obter o trans_id associado ao moto_cpf da session
						$queryTransId = "SELECT trans_id FROM transporte WHERE moto_cpf = :moto_cpf";
						$stmtTransId = $pdo->prepare($queryTransId);
						$stmtTransId->bindParam(":moto_cpf", $_SESSION['moto_cpf'], PDO::PARAM_STR);
						$stmtTransId->execute();
						$transId = $stmtTransId->fetch(PDO::FETCH_ASSOC);

						// Se houver um trans_id associado ao moto_cpf
						if ($transId && isset($transId['trans_id'])) {
							// Obter o responsável associado à criança do trans_id
							$queryResponsavel = "SELECT res_cpf FROM crianca WHERE trans_id = :trans_id";
							$stmtResponsavel = $pdo->prepare($queryResponsavel);
							$stmtResponsavel->bindParam(":trans_id", $transId['trans_id'], PDO::PARAM_STR);
							$stmtResponsavel->execute();
							$responsavel = $stmtResponsavel->fetch(PDO::FETCH_ASSOC);

							// Agora $responsavel contém o res_cpf associado à criança do trans_id
							// Faça o que precisar com $responsavel
						} else {
							// Não há trans_id associado ao moto_cpf
							// Faça algo para lidar com essa situação
						}
						?>


						<?php if ($crianca && isset($crianca['trans_id']) && $crianca['trans_id'] && $crianca['trans_id'] != 1): ?>

						<div id="sidebar-mensagens-item" class="sidebar-mensagens-item"
							style="background-color: #1E184C; display: flex; padding: 8px; flex-direction: row; justify-content: start; align-items: center; gap: 10px; border-radius: 0.5vw">

							<?php
							include("bd_conect.php");
							include("conexao.php");

							function obterDadosResponsavel($pdo, $motoCpf)
							{
								$query = "SELECT r.res_cpf, r.nome, r.foto
                      FROM responsavel r
                      JOIN crianca c ON r.res_cpf = c.res_cpf
                      JOIN transporte t ON c.trans_id = t.trans_id
                      WHERE t.moto_cpf = :moto_cpf";

								$stmt = $pdo->prepare($query);
								$stmt->bindParam(":moto_cpf", $motoCpf, PDO::PARAM_STR);
								$stmt->execute();

								$dadosResponsavel = $stmt->fetch(PDO::FETCH_ASSOC);

								return $dadosResponsavel;
							}

							function obterFotoResponsavel($pdo, $motoCpf)
							{
								$query = "SELECT r.foto
                      FROM responsavel r
                      JOIN crianca c ON r.res_cpf = c.res_cpf
                      JOIN transporte t ON c.trans_id = t.trans_id
                      WHERE t.moto_cpf = :moto_cpf";

								$stmt = $pdo->prepare($query);
								$stmt->bindParam(":moto_cpf", $motoCpf, PDO::PARAM_STR);
								$stmt->execute();

								$dadosResponsavel = $stmt->fetch(PDO::FETCH_ASSOC);

								if ($dadosResponsavel && $dadosResponsavel['foto']) {
									// Retorna a foto em base64
									return $dadosResponsavel['foto'];
								} else {
									return null;
								}
							}

							$fotoResponsavelBase64 = obterFotoResponsavel($pdo, $motoCpf);

							// Exibir a foto no HTML
							if ($fotoResponsavelBase64):
								?>
							<img src="<?php echo $fotoResponsavelBase64 ?>" alt="Foto do responsável"
								style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">
							<?php else: ?>
							<img src="../img/fundo_foto_padrao.png" alt="Foto padrão"
								style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">
							<?php endif; ?>

							<?php
							$dadosResponsavel = obterDadosResponsavel($pdo, $motoCpf);

							if ($dadosResponsavel && $dadosResponsavel['res_cpf'] && $dadosResponsavel['res_cpf'] != '000.000.000-1'):
								?>
							<div class="mensagem-info"
								style="display: flex; flex-direction: column; justify-content: center; align-items: start;">
								<p style="text-transform: capitalize; margin: 0; color: #ffffff; font-weight: 500; font-size: 18px;">
									<?= $dadosResponsavel['nome'] ?>
								</p>
								<p style="margin: 0; font-size: 12px;" id="ultima-mensagem">
									<?php include("ult_msg.php"); ?>
								</p>
							</div>
							<?php else: ?>
							<!-- Caso o res_cpf do responsável seja '000.000.000-1' -->
									<p style="margin: 0; color: #1E184C; font-weight: 500; font-size: 18px;">Responsável Sem Nome</p>
								<?php endif; ?>

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
				<h3 id="subtitulo-chat" style="color: #3C3577;">Aqui você tira Dúvidas com os Responsáveis!</h3>

				<div id="chat-header" class="chat-header"
					style="display: none; width: 100%; height: 3vw; background-color: #E4E4E4; justify-content: start; align-items: center; padding: 2vw; border-radius: 0 2vw 0 0;">
					<span style="display: flex;flex-direction: row;justify-content: center;align-items: center; gap: 10px;">

						<?php
						$fotoResponsavelBase64 = obterFotoResponsavel($pdo, $motoCpf);

						// Exibir a foto no HTML
						if ($fotoResponsavelBase64) {
							echo '<img src="'.$fotoResponsavelBase64.'" alt="Foto do motorista"
                        style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">';
						} else {
							echo '<img src="../img/fundo_foto_padrao.png" alt="Foto padrão"
                        style="width: 3vw; height: 3vw; object-fit: cover; border-radius: 100%;">';
						}
						?>
						<?php
						include("bd_conect.php");
						include("conexao.php");

						$dadosResponsavel = obterDadosResponsavel($pdo, $motoCpf);

						// Verifica se a consulta retornou algum resultado
						if ($dadosResponsavel) {
							// Exibe o nome associado à tabela transporte
							echo '<p style="text-transform: capitalize;
                         margin: 0; color: #1E184C; font-weight: 500; font-size: 18px;">' . $dadosResponsavel['nome'] . '</p>';
						} else {
							// Se não encontrar o nome, você pode lidar com isso de acordo com a sua lógica
							echo '<p style="margin: 0; color: #1E184C; font-weight: 500; font-size: 18px;">Responsavel Sem Nome</p>';
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
	</div>
	<!-------- Fim da div que tem tudo --------->
	<?php
	include("bd_conect.php");

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$mensagem = $_POST['mensagem'];
		// Utilize as variáveis $responsavelCpf e $motoCpf na sua inserção no banco de dados
		$pdo->query("INSERT INTO chat (mensagem, tipo, res_cpf, moto_cpf) VALUES ('$mensagem', 'motorista', '$responsavelCpf', '$motoCpf')");
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