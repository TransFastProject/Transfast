<?php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Listagem das Crianças</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/gerenciamento.css">
    <link rel="stylesheet" href="../css/listagem.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
</head>

<body>
    <div id="gere_menu">
        <div class="btn_expandir">
            <i class="bi bi-caret-right-square"></i>
        </div>
        <div>
            <img src="../img/fundo_foto_padrao.png" alt="Foto do Perfil" style="width:11vw;height:11vw;">
            <p>Bem Vindo<br>
                Admin
            </p>
        </div>
        <div>
            <br />
            <div class="gere_links"><a href="admin_listagem.php">Listagem</a></div><br />
            <div class="gere_links"><a href="admin_motoristas.php">Motoristas</a></div><br />
            <div class="gere_links"><a href="admin_responsaveis.php">Responsáveis</a></div><br />
            <div id="gere_local"><a href="admin_criancas.php">Crianças</a></div><br />
            <div class="gere_links"><a href="admin_transporte.php">Transportes</a></div><br />
        </div>

        <footer id="gere_sair"><a href="sair.php">Sair</a></footer>
    </div>
    <div id="gere_conteudo">
        <div id="listagem_titulo">
            <h1>Listagem Das Crianças</h1>
        </div>
        <?php
    include "conexao.php";
    $query = mysqli_query($sql,"select * from crianca")
    
    ?>

    <table id="tableCrianca" border="1">
        <tr>
            <td align="center">Cria_ID</td>
            <td align="center">Res_CPF</td>
            <td align="center">Trans_ID</td>
            <td align="center">Nome</td>
            <td align="center">Idade</td>
            <td align="center">Gênero</td>
            <td align="center">Data_Nascimento</td>
            <td align="center">Escola</td>
            <td align="center">Deficiencia</td>
            <td align="center">Valor</td>
        </tr>

    <?php 
        while($linha = mysqli_fetch_array($query)){
            
            $cria_id = $linha['cria_id'];
            $res_cpf = $linha['res_cpf'];
            $trans_id = $linha['trans_id'];
            $nome = $linha['nome'];
            $idade = $linha['idade'];
            $genero = $linha['genero'];
            $data_nascimento = $linha['data_nascimento'];
            $escola = $linha['escola'];
            $deficiencia = $linha['deficiencia'];
            $valor = $linha['valor'];
            

            echo "
                <tr> 
                    <td> $cria_id</td>
                    <td> $res_cpf</td>
                    <td> $trans_id</td>
                    <td> $nome</td>
                    <td> $idade</td>
                    <td> $genero</td>
                    <td> $data_nascimento</td>
                    <td> $escola</td>
                    <td> $deficiencia</td>
                    <td> $valor</td>
                </tr>
            ";
        
        }

    ?>
</table>
        </div>

    </div>
</body>

</html>