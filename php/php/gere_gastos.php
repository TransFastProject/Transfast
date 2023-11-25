<?php
include_once 'conexao.php';
session_start();

$moto_nome = "SELECT nome FROM motorista WHERE moto_cpf = '" . $_SESSION['moto_cpf'] . "'";
$link_moto = mysqli_query($sql, $moto_nome);
$linked_moto = mysqli_fetch_assoc($link_moto);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Pagamentos Mensais</title>
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
			<div class="gere_links"><a href="gere_revisao.php">Revisão</a></div><br /><br />
			<div class="gere_links"><a href="gere_criancas_escolas.php">Crianças</a></div><br /><br />
			<div id="gere_local"><a href="gere_lucro.php">Lucro</a></div><br /><br />
			<div class="gere_links"><a href="gere_perfil.php">Perfil</a></div><br /><br />
		</div>
		<footer id="gere_sair"><a href="sair.php">Sair</a></footer>
	</div>

	<div id="gere_conteudo">



		<div id="lista_meses">

			<h1>Gastos</h1>

			<div>
				<section>
					<a class="mes" id="janeiro" href="salvar_mes.php?mes=janeiro">Janeiro</a>
					<a class="mes" id="fevereiro" href="salvar_mes.php?mes=fevereiro">Fevereiro</a>
					<a class="mes" id="marco" href="salvar_mes.php?mes=marco">Março</a>
					<a class="mes" id="abril" href="salvar_mes.php?mes=abril">Abril</a>
					<a class="mes" id="maio" href="salvar_mes.php?mes=maio">Maio</a>
					<a class="mes" id="junho" href="salvar_mes.php?mes=junho">Junho</a>
				</section>
				<section>
					<a class="mes" id="julho" href="salvar_mes.php?mes=julho">Julho</a>
					<a class="mes" id="agosto" href="salvar_mes.php?mes=agosto">Agosto</a>
					<a class="mes" id="setembro" href="salvar_mes.php?mes=setembro">Setembro</a>
					<a class="mes" id="outubro" href="salvar_mes.php?mes=outubro">Outubro</a>
					<a class="mes" id="novembro" href="salvar_mes.php?mes=novembro">Novembro</a>
					<a class="mes" id="dezembro" href="salvar_mes.php?mes=dezembro">Dezembro</a>
				</section>
			</div>
		</div>

		<div id="gere_voltar" style="margin-top: 5vh;">
			<footer><a href="gere_lucro.php">Voltar</a></footer>
		</div>
	</div>
</body>

</html>