<?php
session_start(); // Inicializa a sessão

include "conexao.php";

if ($sql === false) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == UPLOAD_ERR_OK) {
        $caminho_temporario = $_FILES["foto"]["tmp_name"];
        $dados_imagem = file_get_contents($caminho_temporario);

        $dado_imagem = mysqli_real_escape_string($sql, $dados_imagem);

        $moto_cpf = $_SESSION['moto_cpf']; // Obtém o moto_cpf da sessão

        // Atualiza a foto do motorista com base no moto_cpf
        $up = "UPDATE motorista SET foto = '$dado_imagem' WHERE moto_cpf = '$moto_cpf'";

        if (mysqli_query($sql, $up)) {
            echo "Foto atualizada com sucesso.";
            
            // Exibir a foto atualizada
            $result = mysqli_query($sql, "SELECT foto FROM motorista WHERE moto_cpf = '$moto_cpf'");
            if ($result) {
                $rowft = mysqli_fetch_assoc($result);
                $imagem = $rowft['foto'];

                if ($imagem) {
                    echo 'Imagem obtida com Sucesso';
                }
            } else {
                echo "Erro ao obter a foto do banco de dados: " . mysqli_error($sql);
            }
            
        } else {
            echo "Erro ao atualizar a foto: " . mysqli_error($sql);
        }

        mysqli_close($sql);
    } else {
        echo "Ocorreu um erro ao fazer o upload da imagem.";
        var_dump($_FILES); // Debugging
    }
}
header("Location: ../php/gere_perfil.php");
        exit();
?>
