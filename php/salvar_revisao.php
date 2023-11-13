<?php 
include_once "conexao.php";
session_start();
$moto_cpf = $_SESSION['moto_cpf'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $revi_item01 = isset($_POST['revi_item01']) ? '1' : '0';
    $revi_item02 = isset($_POST['revi_item02']) ? '1' : '0';
    $revi_item03 = isset($_POST['revi_item03']) ? '1' : '0';
    $revi_item04 = isset($_POST['revi_item04']) ? '1' : '0';
    $revi_item05 = isset($_POST['revi_item05']) ? '1' : '0';
    $revi_item06 = isset($_POST['revi_item06']) ? '1' : '0';
    $revi_item07 = isset($_POST['revi_item07']) ? '1' : '0';
    $revi_item08 = isset($_POST['revi_item08']) ? '1' : '0';
    $revi_item09 = isset($_POST['revi_item09']) ? '1' : '0';
    $revi_item10 = isset($_POST['revi_item10']) ? '1' : '0';

    $moto_cpf = $_SESSION['moto_cpf'];
    $sql -> query("update vistoria set item01='$revi_item01', item02='$revi_item02', item03='$revi_item03', item04='$revi_item04', item05='$revi_item05', item06='$revi_item06', item07='$revi_item07', item08='$revi_item08', item09='$revi_item09', item10='$revi_item10' where moto_cpf ='". $moto_cpf."'");

    header('Location: gere_revisao.php');
}
?>