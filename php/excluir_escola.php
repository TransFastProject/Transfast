<?php 
include_once "conexao.php";
session_start();
$nome_escola = $_GET['escola'];

$checa_id = "SELECT trans_id FROM transporte WHERE moto_cpf ='" . $_SESSION['moto_cpf'] . "'";
$result_id = mysqli_query($sql, $checa_id);
$trans_id = mysqli_fetch_assoc($result_id)["trans_id"];

$sql -> query("update crianca set trans_id='1' where escola='".$nome_escola."' and trans_id ='".$trans_id."'");

header("Location: ../php/gere_criancas_escolas.php");
?>