<?php
include_once 'conexao.php';
session_start();
$moto_cpf = $_SESSION['moto_cpf'];

$moto_nome = "SELECT * FROM motorista WHERE moto_cpf='" . $_SESSION['moto_cpf'] . "'";
$link_moto = mysqli_query($sql, $moto_nome);
$linked_moto = mysqli_fetch_assoc($link_moto);

$checa_id = "SELECT trans_id FROM transporte WHERE moto_cpf ='" . $_SESSION['moto_cpf'] . "'";
$result_id = mysqli_query($sql, $checa_id);
$trans_id = mysqli_fetch_assoc($result_id)["trans_id"];


$criancas = "SELECT COUNT(*) AS total_criancas FROM crianca WHERE trans_id ='" . $trans_id . "'";
$n_crianca = mysqli_query($sql, $criancas);
$row = $n_crianca->fetch_assoc();
$total_crianca = $row["total_criancas"];

$valor = "SELECT SUM(valor) AS valor_total FROM crianca WHERE trans_id ='" . $trans_id . "'";
$v_total = mysqli_query($sql, $valor);
$row = $v_total->fetch_assoc();
$total_valor = $row["valor_total"];
if ($total_valor <= 0) {
	$valor_total = "0,00";
} else {
	$valor_total = $total_valor;
}

$escolas = "SELECT COUNT(DISTINCT UPPER(escola)) AS total_escolas FROM crianca WHERE trans_id='" . $trans_id . "'";
$n_escola = mysqli_query($sql, $escolas);
$row = $n_escola->fetch_assoc();
$total_escolas = $row["total_escolas"];

if (!$_SESSION['nome'] == "" && !$_SESSION['dtnascimento'] == "" && !$_SESSION['telefone'] == "" && !$_SESSION['cep'] == "" && !$_SESSION['bairro'] == "") {
	$msg_perfil = "Completo";
} else {
	$msg_perfil = "Imcompleto";
}

$revi_item01 = $sql->query("SELECT item01 FROM vistoria WHERE moto_cpf = '$moto_cpf'");
$revi_item02 = $sql->query("SELECT item02 FROM vistoria WHERE moto_cpf = '$moto_cpf'");
$revi_item03 = $sql->query("SELECT item03 FROM vistoria WHERE moto_cpf = '$moto_cpf'");
$revi_item04 = $sql->query("SELECT item04 FROM vistoria WHERE moto_cpf = '$moto_cpf'");
$revi_item05 = $sql->query("SELECT item05 FROM vistoria WHERE moto_cpf = '$moto_cpf'");
$revi_item06 = $sql->query("SELECT item06 FROM vistoria WHERE moto_cpf = '$moto_cpf'");
$revi_item07 = $sql->query("SELECT item07 FROM vistoria WHERE moto_cpf = '$moto_cpf'");
$revi_item08 = $sql->query("SELECT item08 FROM vistoria WHERE moto_cpf = '$moto_cpf'");
$revi_item09 = $sql->query("SELECT item09 FROM vistoria WHERE moto_cpf = '$moto_cpf'");
$revi_item10 = $sql->query("SELECT item10 FROM vistoria WHERE moto_cpf = '$moto_cpf'");

$revi_item01_value = mysqli_fetch_assoc($revi_item01)['item01'];
$revi_item02_value = mysqli_fetch_assoc($revi_item02)['item02'];
$revi_item03_value = mysqli_fetch_assoc($revi_item03)['item03'];
$revi_item04_value = mysqli_fetch_assoc($revi_item04)['item04'];
$revi_item05_value = mysqli_fetch_assoc($revi_item05)['item05'];
$revi_item06_value = mysqli_fetch_assoc($revi_item06)['item06'];
$revi_item07_value = mysqli_fetch_assoc($revi_item07)['item07'];
$revi_item08_value = mysqli_fetch_assoc($revi_item08)['item08'];
$revi_item09_value = mysqli_fetch_assoc($revi_item09)['item09'];
$revi_item10_value = mysqli_fetch_assoc($revi_item10)['item10'];

if($revi_item01_value === '1' && $revi_item02_value === '1' && $revi_item03_value === '1' && $revi_item04_value === '1' && $revi_item05_value === '1' && $revi_item06_value === '1' && $revi_item07_value === '1' && $revi_item08_value === '1' && $revi_item09_value === '1' && $revi_item10_value === '1'){
	$resposta_vistoria = "Completa";
}else{
	$resposta_vistoria = "Incompleta";
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Home</title>
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
			<div id="gere_local"><a href="gere_inicio.php">Home</a></div><br /><br />
			<div class="gere_links"><a href="gere_revisao.php">Revisão</a></div><br /><br />
			<div class="gere_links"><a href="gere_criancas_escolas.php">Crianças</a></div><br /><br />
			<div class="gere_links"><a href="gere_lucro.php">Lucro</a></div><br /><br />
			<div class="gere_links"><a href="gere_perfil.php">Perfil</a></div><br /><br />
		</div>

		<footer id="gere_sair"><a href="sair.php">Sair</a></footer>
	</div>

	<div id="gere_inicio">

		<div class="gere_conteudo_2">
			<div class="gere_card">
				<img src="../img/icone_pessoas.png" />

				<p><b>
						<?php echo $total_crianca; ?>
					</b></p>
				<!--Aqui vai ter que fazer um jeito de pegar todas as crianças cadastradas no trans_id especifico-->

				<p>Crianças em seu Transporte</p>
			</div>

			<div class="gere_card">
				<img src="../img/icone_dinheiro.png" />

				<p><b>
						<?php echo "R$$valor_total" ?>
					</b></p>
				<!-- Assim que a criança estiver cadastrada terão os valores que precisam pagar para continuar usando o app, aqui tem que juntar todas essas crianças cadastradas no trans_id especifico e juntar todos os valores que ela paga, dá pra fazer com javascript ou php -->

				<p>Valor Mensal Estimado</p>
			</div>

			<div class="gere_card">
			<img src="../img/icone_arquivos.png" />

				<p><b><?php echo $resposta_vistoria; ?></b></p>
				<p>Situação da vistoria</p>
				
				<!-- verificar se está ou não checkado na tela de revisão, provavelmente será em javascript, como? vai ter que buscar na outra tela uma variavel que seria universal no proprio site ou somente nessa tela, ou armazenar no banco de dados e quando chegar determinada data alterar para não chekado, vai ser um rolê, mas talvez dê pra fazer-->
			</div>

		</div>

		<div class="gere_conteudo_2">
			<div class="gere_card">
				<img src="../img/icone_escola.png" />

				<p><b>
						<?php echo $total_escolas; ?>
					</b></p><!--Aqui foda-se, procurar outra coisa para mudar e colocar no lugar-->

				<p>Escolas Que Passa</p>
			</div>

			<div class="gere_card">
				<img src="../img/icone_pessoa.png" />

				<p><b>
						<?php echo $msg_perfil; ?>
					</b></p>
				<!-- verificar na tela de perfil se todas as informações estão em seus devidos lugares-->

				<p>Perfil</p>
			</div>


		</div>

	</div>
</body>

</html>