<?php 
include 'conexao.php';
session_start();

$itens = $_POST['itens'];
$valor = $_POST['valor'];
$data_sql = $_POST['data'];
$data = date('d/m/Y', strtotime($data_sql));

$gastos_insert = $sql -> query("INSERT INTO gastos(moto_cpf, data_compra, mes, produtos, valor) VALUES('".$_SESSION['moto_cpf']."','$data','".$_SESSION['mes']."','$itens','$valor')");

if ($gastos_insert && mysqli_affected_rows($sql) > 0) {
    header("Location: ../php/gere_gastos_historico.php");
    exit();
  } else {
    $_SESSION['msg'] = "Erro ao cadastrar os gastos: " . mysqli_error($sql);
  }


?>