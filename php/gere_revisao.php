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
	<title>Revisão</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/estilo.css">
	<link rel="stylesheet" href="../css/gerenciamento.css">
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
			<div id="gere_local"><a href="gere_revisao.php">Revisão</a></div><br />
			<div class="gere_links"><a href="gere_criancas_escolas.php">Crianças</a></div><br />
			<div class="gere_links"><a href="gere_lucro.php">Lucro</a></div><br />
			<div class="gere_links"><a href="gere_perfil.php">Perfil</a></div><br />
			<div class="gere_links"><a href="gere_chamada_escolas.php">Chamada</a></div><br />
			<div class="gere_links"><a href="chat_motorista.php">Chat</a></div><br />
		</div>

		<footer id="gere_sair"><a href="sair.php">Sair</a></footer>
	</div>
	<div id="gere_conteudo">
		<div id="gere_revi">
			<p>O calendário de vistoria foi definido de acordo com o dígito final das placas dos veículos, e pode ser
				realizado num intervalo de três meses:</p>
			<ul>
				<li>Finais 1, 2, 3 e 4 – de fevereiro a abril de 2023.</li>
				<li>Finais 5, 6, 7 e 8 – de março a maio de 2023.</li>
				<li>Finais 9 e 0 – de abril a junho de 2023.</li>
			</ul>
			<p>Na cidade de São Paulo, a vistoria é realizada somente em uma das Instituições Técnicas Licenciadas (ITL)
				credenciadas pela Secretaria Nacional de Trânsito (Senatran).</p>
			<p>O laudo de vistoria terá validade para o respectivo semestre do ano, tendo por base a data de sua
				emissão, não podendo assim ser aproveitado em outro semestre.</p>
			<p>O valor para a obtenção do laudo é pago diretamente para as empresas credenciadas.</p>
		</div>
		<br>
		<div id="rev_btn">
			<a href="gere_revi_lista.php">Vistoria</a>
		</div>


	</div>
	</script>
</body>

</html>