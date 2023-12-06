<?php
include 'conexao.php';

$motorista = $sql -> query("SELECT COUNT(*) AS total_motorista FROM motorista");
$row_motorista = $motorista->fetch_assoc();
$total_motorista = $row_motorista["total_motorista"];

$responsavel = $sql -> query("SELECT COUNT(*) AS total_responsavel FROM responsavel");
$row_responsavel = $responsavel->fetch_assoc();
$total_responsavel = $row_responsavel["total_responsavel"];

$crianca = $sql -> query("SELECT COUNT(*) AS total_crianca FROM crianca");
$row_crianca = $crianca->fetch_assoc();
$total_crianca = $row_crianca["total_crianca"];

$transporte = $sql -> query("SELECT COUNT(*) AS total_transporte FROM transporte");
$row_transporte = $transporte->fetch_assoc();
$total_transporte = $row_transporte["total_transporte"];

$total_perfis_cadastrados = $total_motorista + $total_responsavel;

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Listagem Usuários</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/gerenciamento.css">
    <link rel="stylesheet" href="../css/listagem.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
</head>

<body>
    <div id="gere_menu">
        <div class="btn_expandir">
            <i class="bi bi-caret-right-square"></i>
        </div>
        <div>
            <img src="../img/fundo_foto_padrao.png" alt="Foto do Perfil" style="width:11vw;height:11vw;">
            <p>Bem Vindo<br>
                Admin
            </p>
        </div>
        <div>
            <br />
            <div id="gere_local"><a href="admin_listagem.php">Listagem</a></div><br />
            <div class="gere_links"><a href="admin_motoristas.php">Motoristas</a></div><br />
            <div class="gere_links"><a href="admin_responsaveis.php">Responsáveis</a></div><br />
            <div class="gere_links"><a href="admin_criancas.php">Crianças</a></div><br />
            <div class="gere_links"><a href="admin_transporte.php">Transportes</a></div><br />
        </div>

        <footer id="gere_sair"><a href="sair.php">Sair</a></footer>
    </div>
    <div id="gere_inicio">
    <div class="gere_conteudo_2">
			<div class="gere_card">
            <img src="../img/listagem_motorista.png">
				<p><b>
						<?php echo $total_motorista; ?>
					</b></p>
				<p>Motoristas Cadastrados</p>
			</div>

			<div class="gere_card">
            <img src="../img/listagem_responsavel.png">

<p><b>
        <?php echo $total_responsavel;?>
    </b></p>
<p>Responsáves Cadastrados</p>
			</div>

			<div class="gere_card">
			<img src="../img/listagem_crianca.png">
                <p><b><?php echo $total_crianca; ?>
					</b></p>
				<p>Criancas Cadastrados</p>
			</div>

		</div>

		<div class="gere_conteudo_2">
			<div class="gere_card">
            <img src="../img/listagem_transporte.png">
				<p><b><?php echo $total_transporte; ?>
					</b></p>
				<p>Transportes Cadastrados</p>
			</div>

			<div class="gere_card">
				<img src="../img/icone_pessoa.png" />

				<p><b>
						<?php echo $total_perfis_cadastrados; ?>
					</b></p>
				<p>Perfis Cadastrados</p>
			</div>


		</div>
</div>
</body>

</html>