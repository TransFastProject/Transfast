<?php
include_once 'conexao.php';
if (isset($_GET['email'])) {
    $query = mysqli_query($sql, "select * from motorista where email='" . $_GET['email'] . "'");

    $linhas = mysqli_fetch_array($query);

    if ($linhas > 0) {
        echo "<span style='color:red;font-weight:bold;'>Indisponivel</span>";
    } else {
        echo "<span style='color:green;font-weight:bold;'>Disponivel</span>";
    }

}
?>