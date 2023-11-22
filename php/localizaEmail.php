<?php
include_once 'conexao.php';
if (isset($_GET['email'])) {
    $query_moto = $sql -> query("select email from motorista where email ='".$_GET['email'] ."'");
    $query_res = $sql -> query("select email from responsavel where email = '". $_GET['email'] . "'");

    $linhas_moto = mysqli_fetch_array($query_moto);
    $linhas_res = mysqli_fetch_array($query_res);

    if ($linhas_moto > 0 || $linhas_res > 0) {
        echo "<span style='color:red;font-weight:bold;'>Indisponivel</span>";
    } else {
        echo "<span style='color:green;font-weight:bold;'>Disponivel</span>";
    }

}
?>