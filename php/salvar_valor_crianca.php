<?php
include 'conexao.php';
session_start(); 
$cria_id = $_GET['cria_id'];
$valor = $_POST['valor'];

$update_valor = $sql-> query("UPDATE crianca SET valor=$valor WHERE cria_id='$cria_id'");

if ($update_valor && mysqli_affected_rows($sql) > 0) {
    header("Location: ../php/gere_mensalidade.php");
    exit();
  } else {
    $_SESSION['msg'] = "Erro ao cadastrar o valor: " . mysqli_error($sql);
    header("Location: ../php/gere_mensalidade.php");
    exit();
  }

?>