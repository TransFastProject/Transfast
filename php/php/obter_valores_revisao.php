<?php
include_once 'conexao.php';
session_start();
$moto_cpf = $_SESSION['moto_cpf'];

$revi_item01_query = "SELECT item01 FROM vistoria WHERE moto_cpf = '$moto_cpf'";
$revi_item02_query = "SELECT item02 FROM vistoria WHERE moto_cpf = '$moto_cpf'";
$revi_item03_query = "SELECT item03 FROM vistoria WHERE moto_cpf = '$moto_cpf'";
$revi_item04_query = "SELECT item04 FROM vistoria WHERE moto_cpf = '$moto_cpf'";
$revi_item05_query = "SELECT item05 FROM vistoria WHERE moto_cpf = '$moto_cpf'";
$revi_item06_query = "SELECT item06 FROM vistoria WHERE moto_cpf = '$moto_cpf'";
$revi_item07_query = "SELECT item07 FROM vistoria WHERE moto_cpf = '$moto_cpf'";
$revi_item08_query = "SELECT item08 FROM vistoria WHERE moto_cpf = '$moto_cpf'";
$revi_item09_query = "SELECT item09 FROM vistoria WHERE moto_cpf = '$moto_cpf'";
$revi_item10_query = "SELECT item10 FROM vistoria WHERE moto_cpf = '$moto_cpf'";

$revi_item01_result = mysqli_query($sql, $revi_item01_query);
$revi_item02_result = mysqli_query($sql, $revi_item02_query);
$revi_item03_result = mysqli_query($sql, $revi_item03_query);
$revi_item04_result = mysqli_query($sql, $revi_item04_query);
$revi_item05_result = mysqli_query($sql, $revi_item05_query);
$revi_item06_result = mysqli_query($sql, $revi_item06_query);
$revi_item07_result = mysqli_query($sql, $revi_item07_query);
$revi_item08_result = mysqli_query($sql, $revi_item08_query);
$revi_item09_result = mysqli_query($sql, $revi_item09_query);
$revi_item10_result = mysqli_query($sql, $revi_item10_query);

$revi_item01_value = mysqli_fetch_assoc($revi_item01_result)['item01'];
$revi_item02_value = mysqli_fetch_assoc($revi_item02_result)['item02'];
$revi_item03_value = mysqli_fetch_assoc($revi_item03_result)['item03'];
$revi_item04_value = mysqli_fetch_assoc($revi_item04_result)['item04'];
$revi_item05_value = mysqli_fetch_assoc($revi_item05_result)['item05'];
$revi_item06_value = mysqli_fetch_assoc($revi_item06_result)['item06'];
$revi_item07_value = mysqli_fetch_assoc($revi_item07_result)['item07'];
$revi_item08_value = mysqli_fetch_assoc($revi_item08_result)['item08'];
$revi_item09_value = mysqli_fetch_assoc($revi_item09_result)['item09'];
$revi_item10_value = mysqli_fetch_assoc($revi_item10_result)['item10'];

$response = [
    'revi_item01' => $revi_item01_value,
    'revi_item02' => $revi_item02_value,
    'revi_item03' => $revi_item03_value,
    'revi_item04' => $revi_item04_value,
    'revi_item05' => $revi_item05_value,
    'revi_item06' => $revi_item06_value,
    'revi_item07' => $revi_item07_value,
    'revi_item08' => $revi_item08_value,
    'revi_item09' => $revi_item09_value,
    'revi_item10' => $revi_item10_value,
];

echo json_encode($response);
?>
