<?php
include 'conexao.php';
session_start();

$nota = $_POST['radio_button'];
$trans_id = $_GET['trans_id'];

$select_nota = $sql->query("SELECT nota FROM transporte WHERE trans_id ='$trans_id'");
$row_nota = mysqli_fetch_assoc($select_nota);

if (!empty($row_nota['nota'])) {

    $nota_atual = $row_nota['nota'];
    $nova_nota = ($nota_atual + $nota) / 2;


    $update_nota = $sql->query("UPDATE transporte SET nota=$nova_nota WHERE trans_id ='$trans_id'");
} else {

    $update_nota = $sql->query("UPDATE transporte SET nota=$nota WHERE trans_id ='$trans_id'");
}

if ($update_nota) {
    echo "Nota atualizada com sucesso!";
    header("Location: ../php/seu_transporte_com.php?trans_id=$trans_id");
} else {
    echo "Erro ao atualizar a nota: " . mysqli_error($sql);
    header("Location: ../php/seu_transporte_com.php?trans_id=$trans_id");
}
?>
