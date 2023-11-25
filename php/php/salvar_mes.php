<?php 
session_start();
$mes = $_GET['mes'];
$_SESSION['mes'] = $mes;
header('Location: gere_gastos_historico.php');
?>