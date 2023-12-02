<?php
include_once 'conexao.php';
session_start();
$moto_nome = "SELECT nome FROM motorista WHERE moto_cpf ='" . $_SESSION['moto_cpf'] . "'";
$link_moto = mysqli_query($sql, $moto_nome);
$linked_moto = mysqli_fetch_assoc($link_moto);

$cria_id = $_GET['cria_id'];

if ($cria_id == "?") {
	$select_values = "SELECT crianca.nome as nome_crianca, crianca.data_nascimento as dt_crianca, crianca.genero as genero_crianca, crianca.escola as escola_crianca, crianca.deficiencia as deficiencia_crianca, responsavel.nome as nome_responsavel, responsavel.rua as rua_responsavel, responsavel.bairro as bairro_responsavel, responsavel.cep as cep_responsavel, responsavel.telefone as telefone_responsavel, responsavel.numero as numero_responsavel, crianca.foto as foto  FROM crianca INNER JOIN responsavel ON crianca.res_cpf = responsavel.res_cpf WHERE crianca.cria_id=1";
	$link_values = mysqli_query($sql, $select_values);
	$linked_values = mysqli_fetch_assoc($link_values);
}else {
	$select_values = "SELECT crianca.nome as nome_crianca, crianca.data_nascimento as dt_crianca, crianca.genero as genero_crianca, crianca.escola as escola_crianca, crianca.deficiencia as deficiencia_crianca, responsavel.nome as nome_responsavel, responsavel.rua as rua_responsavel, responsavel.bairro as bairro_responsavel, responsavel.cep as cep_responsavel, responsavel.telefone as telefone_responsavel, responsavel.numero as numero_responsavel, crianca.foto as foto  FROM crianca INNER JOIN responsavel ON crianca.res_cpf = responsavel.res_cpf WHERE crianca.cria_id= $cria_id";
	$link_values = mysqli_query($sql, $select_values);
	$linked_values = mysqli_fetch_assoc($link_values);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>cadastrar criança</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/estilo.css">
	<link rel="stylesheet" href="../css/gerenciamento.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
	<script type="text/JavaScript"></script>
</head>
<!--Dados das crianças-->

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
			<div class="gere_links"><a href="gere_chamada_escolas.php">Chamada</a></div><br />
			<div class="gere_links"><a href="">Chat</a></div><br />
			
		</div>

		<footer id="gere_sair"><a href="sair.php">Sair</a></footer>
	</div>

	<div id="gere_conteudo">

		<div id="cad_crianca">

			<div id="cad_crianca_foto">
			<?php if (!empty($linked_values['foto'])): ?>
        <img id="previewFoto" src="<?php echo $linked_values['foto']; ?>" class="rounded-circle" style="width: 10vw; height: 10vw; object-fit: cover;">
      <?php else: ?>
        <img id="previewFoto" src="../img/fundo_foto_padrao.png" class="rounded-circle" style="width: 10vw; height: 10vw; object-fit: cover;">
      <?php endif; ?>
				<p><b>
						<?php echo $linked_values['nome_crianca']; ?>
					</b></p>
			</div>

			<form class="form-container" method="post" action="salvar_crianca.php?cria_id=<?php echo $cria_id ?>">

				<!-- Campos principais -->

				<div class="form-group">

					<label for="rua">Rua:</label>
					<input type="text" id="rua" name="rua" style=" width: 70%;"
						value="<?php echo $linked_values['rua_responsavel']; ?>" required>
					<label for="numero" style=" width: 5%;">N°:</label>
					<input type="text" id="numero" name="numero" style="width: 10%;"
						value="<?php echo $linked_values['numero_responsavel']; ?>" required>

				</div>

				<div class="form-group">
					<label for="bairro">Bairro:</label>
					<input type="text" id="bairro" name="bairro" style=" width: 40%;"
						value="<?php echo $linked_values['bairro_responsavel']; ?>" required>

					<label for="cep" style=" width: 7%;">CEP:</label>
					<input type="text" id="cep" name="cep" style=" width: 40%;"
						value="<?php echo $linked_values['cep_responsavel']; ?>" required>
				</div>

				<div class="form-group">
					<label for="genero">Gênero:</label>
					<select id="genero" name="genero" required>
						<option value="<?php echo $linked_values['genero_crianca']; ?>">
							<?php echo $linked_values['genero_crianca']; ?>
						</option>
						<option value="masculino">Masculino</option>
						<option value="feminino">Feminino</option>
						<option value="outro">Outro</option>
					</select>

					<label for="escola">Escola:</label>
					<input type="text" id="escola" name="escola" value="<?php echo $linked_values['escola_crianca']; ?>"
						required>

				</div>

				<div class="form-group" style=" width: 50%;">
					<label for="dataNascimento" style=" width: 40%;">Data de Nascimento:</label>
					<input type="date" id="dataNascimento" name="dataNascimento"
						style=" width: 60%; text-align: center;" value="<?php echo $linked_values['dt_crianca']; ?>"
						required>
				</div>

				<!-- Campos do Responsável e Conteúdo -->
				<div class="responsavel_dados">

					<div class="form-group">
						<label for="responsavel" style=" width: 18%;">Responsável:</label>
						<input type="text" id="responsavel" name="responsavel" style=" width: 82%;"
							value="<?php echo $linked_values['nome_responsavel']; ?>" required>
					</div>

					<div class="form-group" style=" width: 50%;">
						<label for="contato" style=" width: 30%;">Contato:</label>
						<input type="text" id="contato" name="contato" style=" width: 70%;"
							value="<?php echo $linked_values['telefone_responsavel']; ?>" required>
					</div>

				</div>

				<div class="form-group" style="border-bottom-width: 50%;">
					<label for="cuidadosEspeciais" style=" width: 40%;">Deficiencias:</label>
					<input type="text" id="cuidadosEspeciais" name="cuidadosEspeciais"
						style="margin-right:20%;width:80%;"
						value="<?php echo $linked_values['deficiencia_crianca']; ?>"></textarea>
				</div>

				<div class="form-group" style="border-bottom-width: 0px; text-align: center;">
					<input type="submit" value="Salvar">
				</div>
			</form>


			<div id="gere_voltar" style="margin-top: 5vh; margin-right: -10vw;">
				<footer><a href="gere_criancas.php?escola=<?php echo $linked_values['escola_crianca']; ?>">Voltar</a>
				</footer>
			</div>

		</div>
	</div>
</body>

</html>