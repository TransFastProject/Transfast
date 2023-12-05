<?php
include_once 'conexao.php';
session_start();

$moto_nome = "SELECT nome FROM motorista WHERE moto_cpf = '" . $_SESSION['moto_cpf'] . "'";
$link_moto = mysqli_query($sql, $moto_nome);
$linked_moto = mysqli_fetch_assoc($link_moto);

$checa_id = "SELECT trans_id FROM transporte WHERE moto_cpf ='" . $_SESSION['moto_cpf'] . "'";
$result_id = mysqli_query($sql, $checa_id);
$trans_id = mysqli_fetch_assoc($result_id)["trans_id"];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Lista de Chamada</title>
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
			<div class="gere_links"><a href="gere_revisao.php">Revisão</a></div><br />
			<div class="gere_links"><a href="gere_criancas_escolas.php">Crianças</a></div><br />
			<div class="gere_links"><a href="gere_lucro.php">Lucro</a></div><br />
			<div class="gere_links"><a href="gere_perfil.php">Perfil</a></div><br />
			<div id="gere_local"><a href="gere_chamada_escolas.php">Chamada</a></div><br />
			<div class="gere_links"><a href="">Chat</a></div><br />

		</div>
		<footer id="gere_sair"><a href="sair.php">Sair</a></footer>
	</div>

	<div id="gere_conteudo">

		<br>
		<div id="filtro">
			<a></a><input type="text" id="barra_busca" style="font-size:20px;" placeholder="Pesquise aqui">
			<button id="btn_filtro" onclick="searchData()"></button>
		</div>

		<div class="lista_chamada">
			<div id="lista_chamada_presentes">
				<h1>Presente</h1>
				<?php
				if (!empty($_GET['search'])) {
					$data = $_GET['search'];
					$select_search = $sql->query("SELECT crianca.cria_id, crianca.nome, crianca.presenca, crianca.foto FROM crianca WHERE crianca.trans_id = $trans_id AND crianca.presenca = 'presente' AND crianca.nome LIKE '%$data%'");

					if ($select_search !== false && $select_search->num_rows > 0) {
						while ($row = $select_search->fetch_assoc()) {
							$foto = $row['foto'];
							if ($foto) {
								echo '<div class="lista_criancas">
									<div class="crianca"><img src="data:image/jpeg;base64,' . base64_encode($foto) . '" style="border-radius: 50%; width: 6.5vw; height: 6.5vw; object-fit: cover;"><label for="">' . $row['nome'] . '</label></div>
								</div> 
								<br/>';
							} else {
								echo '<div class="lista_criancas">
									<div class="crianca"><img src="../img/fundo_foto_padrao.png" style="border-radius: 50%; width: 6.5vw; height: 6.5vw; object-fit: cover;"><label for="">' . $row['nome'] . '</label></div>
								</div> 
								<br>';
							}

						}
					} 
				} else if (empty($_GET['search'])) {
					$result = $sql->query("SELECT crianca.cria_id, crianca.nome, crianca.presenca, crianca.foto FROM crianca WHERE crianca.trans_id = $trans_id AND crianca.presenca = 'presente'");

					if ($result !== false && $result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$foto = $row['foto'];
							if ($foto) {
								echo '<div class="lista_criancas">
									<div class="crianca"><img src="data:image/jpeg;base64,' . base64_encode($foto) . '" style="border-radius: 50%; width: 6.5vw; height: 6.5vw; object-fit: cover;"><label for="">' . $row['nome'] . '</label></div>
							</div> 
							<br>';
							} else {
								echo '<div class="lista_criancas">
									<div class="crianca"><img src="../img/fundo_foto_padrao.png" style="border-radius: 50%; width: 6.5vw; height: 6.5vw; object-fit: cover;"><label for="">' . $row['nome'] . '</label></div>
							</div> 
							<br>';
							}
						}
					} else {
						echo '<div class="lista_criancas">
							<p>Não existem criancas presentes</p>
						</div> 
						<br>';
					}
				}

				?>
			</div>

			<div id="lista_chamada_ausentes">
				<h1>Ausente</h1>
					<?php
					if (!empty($_GET['search'])) {
						$data = $_GET['search'];
						$select_search = $sql->query("SELECT crianca.cria_id,crianca.nome, crianca.presenca, crianca.foto FROM crianca WHERE crianca.trans_id = $trans_id AND crianca.presenca = 'ausente' AND crianca.nome LIKE '%$data%'");

						if ($select_search !== false && $select_search->num_rows > 0) {
							while ($row = $select_search->fetch_assoc()) {
								$foto = $row['foto'];
								if ($foto) {
									echo '<div class="lista_criancas">
										<div class="crianca"><img src="data:image/jpeg;base64,' . base64_encode($foto) . '" style="border-radius: 50%; width: 6.5vw; height: 6.5vw; object-fit: cover;"><label for="">' . $row['nome'] . '</label></div>
								</div> 
								<br/>';
								} else {
									echo '<div class="lista_criancas">
										<div class="crianca"><img src="../img/fundo_foto_padrao.png" style="border-radius: 50%; width: 6.5vw; height: 6.5vw; object-fit: cover;"><label for="">' . $row['nome'] . '</label></div>
								</div> 
								<br/>';
								}
							}
						}
					} else if (empty($_GET['search'])) {
						$result = $sql->query("SELECT crianca.cria_id, crianca.nome, crianca.presenca, crianca.foto FROM crianca WHERE crianca.trans_id = $trans_id AND crianca.presenca = 'ausente'");

						if ($result !== false && $result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								$foto = $row['foto'];
								if ($foto) {
									echo '<div class="lista_criancas">
										<div class="crianca"><img src="data:image/jpeg;base64,' . base64_encode($foto) . '" style="border-radius: 50%; width: 6.5vw; height: 6.5vw; object-fit: cover;"><label for="">' . $row['nome'] . '</label></div>
								</div> 
								<br/>';
								} else {
									echo '<div class="lista_criancas">
										<div class="crianca"><img src="../img/fundo_foto_padrao.png" style="border-radius: 50%; width: 6.5vw; height: 6.5vw; object-fit: cover;"><label for="">' . $row['nome'] . '</label></div>
								</div> 
								<br/>';
								}
							}
						} else {
							echo '<div class="lista_criancas">
								<p>Não existem criancas ausentes</p>
						</div> 
						<br/>';
						}

					}

					?>


			</div>
			<div id="gere_voltar" style="margin-top: 5vh;">
				<footer><a href="gere_chamada_escolas.php">Voltar</a></footer>
			</div>
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
	window.location = "gere_chamada.php?search="+ search.value;
}
</script>

</html>