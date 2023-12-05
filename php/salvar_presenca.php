<?php
// salvar_presenca.php

// Inclua o arquivo de conexão
include('conexao.php');

// Verifique se a solicitação é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha os dados da presença do corpo da solicitação
    $presenca_data = $_POST['presenca_data'];

    // Itere sobre os dados e atualize o banco de dados conforme necessário
    foreach ($presenca_data as $item) {
        $id_crianca = $item['cria_id'];
        $presenca = $item['presenca'];

        // Execute a operação de atualização no banco de dados
        // Substitua pelos nomes reais dos campos e tabelas do seu banco de dados
        $sql_atualizar_presenca = "UPDATE crianca SET presenca = ? WHERE cria_id = ?";
        $stmt_atualizar_presenca = mysqli_prepare($sql, $sql_atualizar_presenca);

        // Verifique se a preparação da declaração foi bem-sucedida
        if ($stmt_atualizar_presenca) {
            mysqli_stmt_bind_param($stmt_atualizar_presenca, "si", $presenca, $id_crianca);
            mysqli_stmt_execute($stmt_atualizar_presenca);
            mysqli_stmt_close($stmt_atualizar_presenca);

            // Saída para o log
            echo "ID Criança: $id_crianca, Presença: $presenca\n";
        } else {
            // Erro na preparação da declaração
            echo "Erro na preparação da declaração de atualização.\n";
        }
    }

    // Responda com uma mensagem de sucesso ou outro indicador
    echo 'Presença salva com sucesso!';
}
?>
