<?php
include_once 'conexao.php';
session_start();
$moto_nome = "SELECT nome FROM motorista WHERE moto_cpf ='" . $_SESSION['moto_cpf'] . "'";
$link_moto = mysqli_query($sql, $moto_nome);
$linked_moto = mysqli_fetch_assoc($link_moto);

$checa_id = "SELECT trans_id FROM transporte WHERE moto_cpf ='" . $_SESSION['moto_cpf'] . "'";
$result_id = mysqli_query($sql, $checa_id);
$trans_id = mysqli_fetch_assoc($result_id)["trans_id"];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Escolas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/estilo.css">
	<link rel="stylesheet" href="../css/gerenciamento.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
	<script type="text/JavaScript"></script>
</head>
<!--Tela com as escolas cadastradas que o motorista vai, em teoria tem que ter um input aqui que leva para uma tela de cadastro dessas escolas-->

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
			<div id="gere_local"><a href="gere_criancas_escolas.php">Crianças</a></div><br />
			<div class="gere_links"><a href="gere_lucro.php">Lucro</a></div><br />
			<div class="gere_links"><a href="gere_perfil.php">Perfil</a></div><br />
			<div class="gere_links"><a href="">Chamada</a></div><br /> <!--chamada -->
			<div class="gere_links"><a href="">Chat</a></div><br />

		</div>

		<footer id="gere_sair"><a href="sair.php">Sair</a></footer>
	</div>

	<div id="gere_conteudo">
		<div id="lista_escolas">
			<?php
			$result3 = $sql->query("SELECT DISTINCT UPPER(crianca.escola) as nome_escola FROM crianca WHERE crianca.trans_id = $trans_id");
			if ($result3 !== false && $result3->num_rows > 0) {
				while ($row = $result3->fetch_assoc()) {
					echo '<div class="escola">

					<div class="escola_icones">
						<a href="../php/gere_criancas.php?escola=' . urlencode($row['nome_escola']) . '"><img src="../img/icone_lapis.png"></a>
						<a href="../php/excluir_escola.php?escola=' . urlencode($row['nome_escola']) . '""><img src="../img/icone_fechar.png"></a>	
					</div>
	
					<div class="escola_nome">
						<p>' . $row['nome_escola'] . '</p>
					</div>
				</div>';
				}
			} else {
				echo '<div class="escola">

					<div class="escola_icones">
						<a href="../php/gere_criancas.php?escola=?"><img src="../img/icone_lapis.png"></a>
						<a href="../php/excluir_escola.php?escola=?"><img src="../img/icone_fechar.png"></a>
					</div>
	
					<div class="escola_nome">
						<p>As escolas aparecerão aqui</p>
					</div>
				</div>';
			}
			?>



		</div>
	</div>
</body>

</html>