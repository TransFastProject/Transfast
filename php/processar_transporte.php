<?php
session_start(); // Inicializa a sessão

include "conexao.php";

if ($sql === false) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["foto_transporte"]) && $_FILES["foto_transporte"]["error"] == UPLOAD_ERR_OK) {
        $caminho_trans_temporario = $_FILES["foto_transporte"]["tmp_name"];
        $transporte_imagem = file_get_contents($caminho_trans_temporario);

        $moto_cpf = $_SESSION['moto_cpf']; // Obtém o moto_cpf da sessão

        // Usando Prepared Statements para evitar SQL injection
        $stmt = mysqli_prepare($sql, "UPDATE transporte SET foto = ? WHERE moto_cpf = ?");
        mysqli_stmt_bind_param($stmt, "ss", $transporte_imagem, $moto_cpf);

        if (mysqli_stmt_execute($stmt)) {
            echo "Foto atualizada com sucesso.";

            // Exibir a foto atualizada
            $result = mysqli_query($sql, "SELECT foto FROM transporte WHERE moto_cpf = '$moto_cpf'");
            if ($result) {
                $rowTrans = mysqli_fetch_assoc($result);
                $foto_transporte = $rowTrans['foto'];

                if ($foto_transporte) {
                    echo ' Imagem obtida com Sucesso';
                } else {
                    echo ' Erro: A foto não foi obtida do banco de dados.';
                }
            } else {
                echo " Erro ao obter a foto do banco de dados: " . mysqli_error($sql);
            }
        } else {
            echo " Erro ao atualizar a foto: " . mysqli_error($sql);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo " Ocorreu um erro ao fazer o upload da imagem.";
        var_dump($_FILES); // Debugging
    }
}

header("Location: ../php/gere_perfil.php");
exit();
?>
