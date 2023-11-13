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
			
		<div id="filtro"><a></a><input type="text" id="barra_busca" style="font-size:20px;" placeholder="Pesquise aqui">
			<button style="width:3.3vw; height:3.3vw;background-image: url(../img/icone_lupa_v2.png);background-size:2.8vw 2.8vw;background-repeat: no-repeat;" onclick="searchData()"></button>
			</div>
			<table id="tabela_gastos">
				<div>
					<tr id="tabela_index">
						<td style="width: 20%;">DATA</td>
						<td>Itens</td>
						<td style="width: 20%;">Valor</td>
					</tr>
				</div>
				<?php
				$moto_cpf = $_SESSION['moto_cpf']; 
				$mes = $_SESSION['mes'];
				if(!empty($_GET['search'])){
				$data = $_GET['search'];
				$gastos_mensais_select = "SELECT data_compra, mes, produtos, valor FROM gastos WHERE mes='$mes' AND moto_cpf='$moto_cpf' AND produtos LIKE '%$data%'";
				$gastos_mensais = $sql->query($gastos_mensais_select);
				if ($gastos_mensais !== false && $gastos_mensais->num_rows > 0) {
					while ($row = $gastos_mensais->fetch_assoc()) {
						echo '<tr>
							<td>'. $row['data_compra'] .'</td>
							<td>'. $row['produtos']    .'</td>
							<td>'. $row['valor'] .'</td>
						</tr>';
					}
				
				}
			}else if(empty($_GET['search'])){
				$gastos_mensais_select = "SELECT data_compra, mes, produtos, valor FROM gastos WHERE mes='$mes' AND moto_cpf='$moto_cpf'";
				$gastos_mensais = $sql->query($gastos_mensais_select);
				if ($gastos_mensais !== false && $gastos_mensais->num_rows > 0) {
					while ($row = $gastos_mensais->fetch_assoc()) {
						echo '<tr>
							<td>'. $row['data_compra'] .'</td>
							<td>'. $row['produtos']    .'</td>
							<td>'. $row['valor'] .'</td>
						</tr>';
					}
				
				}
			}
				else{
					echo '<tr>
							<td>Sem Dados</td>
							<td>Sem Dados</td>
							<td>Sem Dados</td>
						</tr>';
				}
			
			
				?>


			</table>



		</div>
		<div id="gere_voltar" style="margin-top: 5vh;">
			<footer><a href="gere_gastos.php">Voltar</a></footer>
		</div>
		<!-- Criar um input que toda vez que for clicado vai gerar 3 td, um com o dia, um com os itens comprados e o outro com o valor gasto, além desses seria bom criar uma tabela para armazenar esses itens junto com os meses respectivos-->
	</div>
</body>
<script type="text/JavaScript">
var search = document.getElementById('barra_busca');

search.addEventListener("keydown",function(event) {
if (event.key === "Enter"){
	searchData();
}
});

function searchData(){
	window.location = "gere_gastos_historico.php?search="+ search.value;
}
</script>
</html>