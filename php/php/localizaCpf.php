<?php
include_once 'conexao.php';
if (isset($_GET['moto_cpf'])) {
    $query = mysqli_query($sql, "select * from motorista where moto_cpf='" . $_GET['moto_cpf'] . "'");

    $linhas = mysqli_fetch_array($query);

    if ($linhas > 0) {
        echo "<span style='color:red;font-weight:bold;'>Indisponivel</span>";
    } else {
        echo "<span style='color:green;font-weight:bold;'>Disponivel</span>";
    }
}
?>