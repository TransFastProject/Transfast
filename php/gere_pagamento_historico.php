<?php
include_once 'conexao.php';
session_start();

$cria_id = isset($_GET['cria_id']) ? $_GET['cria_id'] : '';

if (empty($cria_id)) {
	die("ID da criança não foi passado na URL.");
}


$moto_nome = "SELECT nome FROM motorista WHERE moto_cpf = '" . $_SESSION['moto_cpf'] . "'";
$link_moto = mysqli_query($sql, $moto_nome);
$linked_moto = mysqli_fetch_assoc($link_moto);

$moto_tel = "SELECT telefone FROM motorista WHERE moto_cpf = '" . $_SESSION['moto_cpf'] . "'";
$link_tel = mysqli_query($sql, $moto_tel);
$linked_tel = mysqli_fetch_assoc($link_tel);

$moto_rua = "SELECT rua FROM motorista WHERE moto_cpf = '" . $_SESSION['moto_cpf'] . "'";
$link_rua = mysqli_query($sql, $moto_rua);
$linked_rua = mysqli_fetch_assoc($link_rua);

$moto_cpf = $_SESSION['moto_cpf'];
$result_cria = mysqli_query($sql, "SELECT cria_id FROM crianca WHERE trans_id = (SELECT trans_id FROM motorista WHERE moto_cpf = '$moto_cpf')");
$row_cria = mysqli_fetch_assoc($result_cria);

$meses = array('janeiro', 'fevereiro', 'marco', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro');

// Obter os valores do banco de dados para cada mês
$select_query = "SELECT * FROM mes WHERE cria_id = '$cria_id'";
$result = mysqli_query($sql, $select_query);
$row_meses = mysqli_fetch_assoc($result);
foreach ($meses as $mes) {
	$$mes = isset($row_meses[$mes]) ? $row_meses[$mes] : '-';
}

// Consulta para obter as informações da criança e do responsável
$select_info_query = "SELECT crianca.nome AS nome_crianca, responsavel.telefone AS telefone_responsavel, responsavel.rua AS endereco_responsavel FROM crianca INNER JOIN responsavel ON crianca.res_cpf = responsavel.res_cpf WHERE crianca.cria_id = '$cria_id'";

$result_info = mysqli_query($sql, $select_info_query);

if ($result_info) {
	$row_info = mysqli_fetch_assoc($result_info);
} else {
	die("Erro ao executar a consulta: " . mysqli_error($sql));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<!--Tela que checa se todos os pagamentos foram pagos certamente o valor e etc, tabela de lucro anual-->

<head>
	<title>Historico de Pagamentos</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/estilo.css">
	<link rel="stylesheet" href="../css/gerenciamento.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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

		<div id="registro_pagamento">

			<div id="dados_pagamento">

				<div><img src="../img/fundo_foto_padrao.png" id="foto" alt=""></div>

				<div id="informacoes">
					<p>Nome: <strong>
							<?php echo $row_info['nome_crianca']; ?>
						</strong>
						</strong></p>
					<p>Tell: <strong>
							<?php echo $row_info['telefone_responsavel']; ?>
						</strong></p>
					<p>Endereco: <strong>
							<?php echo $row_info['endereco_responsavel']; ?>
						</strong></p>
				</div>
			</div>

			<form method="post" action="../php/atualizar_lucro.php?cria_id=<?php echo $cria_id; ?>">

				<table id="tabela_pagamento">
					<div>
						<tr id="tabela_index">
							<td>MÊS</td>
							<td>PAGAMENTO</td>
						</tr>
					</div>
					<tr>
						<td>JANEIRO</td>
						<td>
							<select name="janeiro" id="janeiro" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($janeiro == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($janeiro == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($janeiro == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>FEVEREIRO</td>
						<td>
							<select name="fevereiro" id="fevereiro" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($fevereiro == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($fevereiro == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($fevereiro == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>MARÇO</td>
						<td>
							<select name="marco" id="marco" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($marco == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($marco == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($marco == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>ABRIL</td>
						<td>
							<select name="abril" id="abril" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($abril == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($abril == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($abril == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>MAIO</td>
						<td>
							<select name="maio" id="maio" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($maio == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($maio == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($maio == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>JUNHO</td>
						<td>
							<select name="junho" id="junho" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($junho == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($junho == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($junho == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>JULHO</td>
						<td>
							<select name="julho" id="julho" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($julho == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($julho == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($julho == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>AGOSTO</td>
						<td>
							<select name="agosto" id="agosto" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($agosto == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($agosto == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($agosto == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>SETEMBRO</td>
						<td>
							<select name="setembro" id="setembro" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($setembro == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($setembro == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($setembro == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>OUTUBRO</td>
						<td>
							<select name="outubro" id="outubro" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($outubro == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($outubro == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($outubro == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>NOVEMBRO</td>
						<td>
							<select name="novembro" id="novembro" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($novembro == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($novembro == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($novembro == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>
					<tr style="border-bottom-width: 2px">
						<td>DEZEMBRO</td>
						<td>
							<select name="dezembro" id="dezembro" style="border: none; width: 250px; text-align: center;">
								<option value="-" <?php if ($dezembro == '-')
									echo 'selected'; ?>>-</option>
								<option value="sim" <?php if ($dezembro == 'sim')
									echo 'selected'; ?>>Sim</option>
								<option value="nao" <?php if ($dezembro == 'nao')
									echo 'selected'; ?>>Não</option>
							</select>
						</td>
					</tr>

				</table>
				<input type="submit" value="Atualizar">

			</form>


		</div>
		<div id="gere_voltar" style="margin-top: 5vh;">
			<footer><a href="gere_mensalidade.php">Voltar</a></footer>
		</div>

	</div>
</body>

</html>