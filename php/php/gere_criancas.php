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
<!--Cadastro das crianças na area de criancas que vai mostrar todas as criancas que o motorista leva daquela escola-->

<head>
	<title>Crianças</title>
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
			<div id="gere_local"><a href="gere_criancas_escolas.php">Crianças</a></div><br /><br />
			<div class="gere_links"><a href="gere_lucro.php">Lucro</a></div><br /><br />
			<div class="gere_links"><a href="gere_perfil.php">Perfil</a></div><br /><br />
		</div>

		<footer id="gere_sair"><a href="sair.php">Sair</a></footer>
	</div>
	<div id="gere_conteudo">
		<div id="conteudo_criancas">

			<?php
			$nome_escola = $_GET['escola'];
			if ($nome_escola == "?" || $nome_escola == "Sem Dados") {
				echo '<div class="criancas">

					<div class="criancas_icones">
						<a><img src="../img/icone_aviso.png"></a>
						<a href="../php/gere_criancas_cad.php?cria_id=?"><img src="../img/icone_edicao.png"></a>
					</div>
	
					<div class="criancas_foto">
						<img src="../img/fundo_foto_padrao.png">
					</div>
	
					<div class="criancas_dados">
						<table>
							<tr>
								<td>Nome:
								<td>Nome da criança
								
							</tr>
							<tr>
								<td>Data de Nascimento:
								<td>Data de Nascimento da criança
								
							</tr>
							<tr>
								<td>Responsavel:
								<td>Responsavel da criança
								
							</tr>
							<tr>
								<td>Endereço:
								<td>Endereço da criança
								
							</tr>
						</table>
					</div>
				</div>';

			} else {
				$stmt = $sql->prepare("SELECT crianca.cria_id as id_crianca, crianca.res_cpf, crianca.nome as nome_crianca, crianca.data_nascimento, responsavel.nome as nome_responsavel, responsavel.rua FROM crianca INNER JOIN responsavel ON crianca.res_cpf = responsavel.res_cpf WHERE crianca.escola = ? AND crianca.trans_id = ?");
				$stmt->bind_param("si", $nome_escola, $trans_id);
				$stmt->execute();
				$result3 = $stmt->get_result();
				if ($result3 !== false && $result3->num_rows > 0) {
					while ($row = $result3->fetch_assoc()) {
						echo '<div class="criancas">

					<div class="criancas_icones">
						<a href="../php/excluir_escola.php?cria_id=' . urlencode($row['id_crianca']) . '"><img src="../img/icone_aviso.png"></a>
						<a href="../php/gere_criancas_cad.php?cria_id=' . urlencode($row['id_crianca']) . '"><img src="../img/icone_edicao.png"></a>
					</div>
	
					<div class="criancas_foto">
						<img src="../img/fundo_foto_padrao.png">
					</div>
	
					<div class="criancas_dados">
						<table>
							<tr>
								<td>Nome:
								<td>' . $row['nome_crianca'] . '
								
							</tr>
							<tr>
								<td>Data de Nascimento:
								<td> ' . $row['data_nascimento'] . '
								
							</tr>
							<tr>
								<td>Responsavel:
								<td>' . $row['nome_responsavel'] . '
								
							</tr>
							<tr>
								<td>Endereço:
								<td>' . $row['rua'] . '
								
							</tr>
						</table>
					</div>
				</div>';
					}
				}
			}
			?>


			<div id="gere_voltar">
				<footer><a href="../php/gere_criancas_escolas.php">Voltar</a></footer>
			</div>

		</div>

	</div>
</body>

</html>