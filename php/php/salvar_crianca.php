<?php
include "conexao.php";
session_start();
$cria_id = $_GET['cria_id'];
$select_res_cria = "SELECT res_cpf from crianca WHERE cria_id='". $cria_id . "'";
$link_res_cria = mysqli_query($sql,$select_res_cria);
$linked_res_cria= mysqli_fetch_assoc($link_res_cria);
$cria_data_nascimento = $_POST['dataNascimento'];
$cria_medicamentos = $_POST['cuidadosEspeciais'];
$cria_genero = $_POST['genero'];
$cria_escola = $_POST['escola'];


//adicionar genero abaixo depois
$sql->query("update crianca set escola = '$cria_escola', data_nascimento='$cria_data_nascimento', medicamentos='$cria_medicamentos', genero='$cria_genero' where cria_id ='" . $cria_id . "'");

// banco do responsavel abaixo
$res_nome = $_POST['responsavel'];
$res_rua = $_POST['rua'];
$res_cep = $_POST['cep'];
$res_bairro = $_POST['bairro'];
$res_numero = $_POST['numero'];

$responsavel_telefone = $_POST['contato'];

$sql->query("update responsavel set nome='$res_nome', rua='$res_rua', cep='$res_cep', bairro='$res_bairro', numero='$res_numero' where res_cpf ='". $linked_res_cria['res_cpf']."'");


header("Location: ../php/gere_criancas_cad.php?cria_id=".$cria_id);
?>

