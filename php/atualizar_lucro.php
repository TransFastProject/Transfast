<?php
include_once 'conexao.php';
session_start();

$cria_id = $_GET['cria_id'];

if (empty($cria_id)) {
    die("ID da criança não foi passado na URL.");
}


$moto_cpf = $_SESSION['moto_cpf'];
$result_cria = mysqli_query($sql, "SELECT cria_id FROM crianca WHERE trans_id = (SELECT trans_id FROM motorista WHERE moto_cpf = '$moto_cpf')");
$row_cria = mysqli_fetch_assoc($result_cria);

$meses = array('janeiro', 'fevereiro', 'marco', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro');

// Modificação do código que você forneceu
$query = "SELECT * FROM verificacao WHERE cria_id = '$cria_id'"; // Use a consulta correta aqui
$result = mysqli_query($sql, $query);

if ($result && $result->num_rows > 0) {
    
    $select_query = "SELECT * FROM verificacao WHERE cria_id = '$cria_id'";
    $result = mysqli_query($sql, $select_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Se o registro existir, atualize-o
            foreach ($meses as $mes) {
                $$mes = isset($_POST[$mes]) ? $_POST[$mes] : '-';
            }

            $update_query = "UPDATE verificacao SET ";
            foreach ($meses as $mes) {
                $update_query .= "$mes = '" . $$mes . "', ";
            }
            $update_query = rtrim($update_query, ', ') . " WHERE cria_id = '$cria_id'";

            if (mysqli_query($sql, $update_query)) {
                echo "Registro atualizado com sucesso.";
            } else {
                echo "Erro ao atualizar o registro: " . mysqli_error($sql);
            }
        } 
    }
        }else {
            // Se o registro não existir, insira-o
            $insert_fields = [];
            $insert_values = [];
            foreach ($meses as $mes) {
                $value = isset($_POST[$mes]) ? $_POST[$mes] : '-';
                $insert_fields[] = $mes;
                $insert_values[] = "'$value'";
            }
            $insert_query = "INSERT INTO verificacao (cria_id, " . implode(', ', $insert_fields) . ") VALUES ('$cria_id', " . implode(', ', $insert_values) . ")";
            
            if (mysqli_query($sql, $insert_query)) {
                echo "Registro inserido com sucesso.";
            } else {
                echo "Erro ao inserir o registro: " . mysqli_error($sql);
            }
    }


exit();
?>
