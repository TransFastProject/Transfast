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
			<div class="gere_links"><a href="gere_inicio.php">Home</a></div><br /><br />
			<div id="gere_local"><a href="gere_revisao.php">Revisão</a></div><br /><br />
			<div class="gere_links"><a href="gere_criancas_escolas.php">Crianças</a></div><br /><br />
			<div class="gere_links"><a href="gere_lucro.php">Lucro</a></div><br /><br />
			<div class="gere_links"><a href="gere_perfil.php">Perfil</a></div><br /><br />
		</div>

		<footer id="gere_sair"><a href="sair.php">Sair</a></footer>
	</div>
	<form method="POST" action="salvar_revisao.php">
		<div id="gere_conteudo">
			<div id="revisao_lista">
				<div>
					<input type="checkbox" name="revi_item01" id="revi_item01">
					<label for="revi_item01">Caixa de primeiros socorros</label><br>
				</div>
				<div>
					<input type="checkbox" name="revi_item02" id="revi_item02">
					<label for="revi_item02">Sistema de retenção</label><br>
				</div>
				<div>
					<input type="checkbox" name="revi_item03" id="revi_item03">
					<label for="revi_item03">Travas de segurança nas janelas</label><br>
				</div>
				<div>
					<input type="checkbox" name="revi_item04" id="revi_item04">
					<label for="revi_item04">Estroboscopio</label><br>
				</div>
				<div>
					<input type="checkbox" name="revi_item05" id="revi_item05">
					<label for="revi_item05">Limitador de velocidade</label><br>
				</div>
				<div>
					<input type="checkbox" name="revi_item06" id="revi_item06">
					<label for="revi_item06">Sistema de radio</label><br>
				</div>
				<div>
					<input type="checkbox" name="revi_item07" id="revi_item07">
					<label for="revi_item07">Cronotacógrafo</label><br>
				</div>
				<div>
					<input type="checkbox" name="revi_item08" id="revi_item08">
					<label for="revi_item08">Extintor de incêndio (pó químico seco ou água)</label><br>
				</div>
				<div>
					<input type="checkbox" name="revi_item09" id="revi_item09">
					<label for="revi_item09">Dispositivos próprios para quebra ou remoção de vidros</label><br>
				</div>
				<div>
					<input type="checkbox" name="revi_item10" id="revi_item10">
					<label for="revi_item10">Lanternas de luz (branca, fosca ou amarela)</label><br>
				</div>
			</div>
			<input type="submit" value="Salvar" id="btn_revi_lista">
	</form>
	<div id="gere_voltar">
		<footer><a href="gere_revisão.php">Voltar</a></footer>
	</div>

	</div>
</body>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		var revi_item01 = document.getElementById('revi_item01');
		var revi_item02 = document.getElementById('revi_item02');
		var revi_item03 = document.getElementById('revi_item03');
		var revi_item04 = document.getElementById('revi_item04');
		var revi_item05 = document.getElementById('revi_item05');
		var revi_item06 = document.getElementById('revi_item06');
		var revi_item07 = document.getElementById('revi_item07');
		var revi_item08 = document.getElementById('revi_item08');
		var revi_item09 = document.getElementById('revi_item09');
		var revi_item10 = document.getElementById('revi_item10');

		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4 && xhr.status === 200) {
				var response = JSON.parse(xhr.responseText);

				if (response.revi_item01 === '1') {
					revi_item01.checked = true;
				}
				if (response.revi_item02 === '1') {
					revi_item02.checked = true;
				}
				if (response.revi_item03 === '1') {
					revi_item03.checked = true;
				}
				if (response.revi_item04 === '1') {
					revi_item04.checked = true;
				}
				if (response.revi_item05 === '1') {
					revi_item05.checked = true;
				}
				if (response.revi_item06 === '1') {
					revi_item06.checked = true;
				}
				if (response.revi_item07 === '1') {
					revi_item07.checked = true;
				}
				if (response.revi_item08 === '1') {
					revi_item08.checked = true;
				}
				if (response.revi_item09 === '1') {
					revi_item09.checked = true;
				}
				if (response.revi_item10 === '1') {
					revi_item10.checked = true;
				}
			}
		};
		xhr.open('GET', 'obter_valores_revisao.php', true);
		xhr.send();
	});
</script>

</html>