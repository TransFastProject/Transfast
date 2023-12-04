<?php 
session_start();
$escola = $_GET['escola'];
$_SESSION['escola'] = $escola;
header('Location: gere_chamada.php');
?>