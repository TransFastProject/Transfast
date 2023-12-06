<?php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Listagem dos Transportes</title>
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
            <div class="gere_links"><a href="admin_criancas.php">Crianças</a></div><br />
            <div id="gere_local"><a href="admin_transporte.php">Transportes</a></div><br />
        </div>

        <footer id="gere_sair"><a href="sair.php">Sair</a></footer>
    </div>
    <div id="gere_conteudo">
        <div id="listagem_titulo">
            <h1>Listagem Dos Transportes</h1>
        </div>
        <?php
    include "conexao.php";
    $query = mysqli_query($sql,"select * from transporte")
    
    ?>

    <table id="tableTransporte" border="1">
        <tr>
            <td align="center">Trans_ID</td>
            <td align="center">Moto_CPF</td>
            <td align="center">Nome</td>
            <td align="center">Monitor</td>
            <td align="center">Placa</td>
            <td align="center">N_Assentos</td>
            <td align="center">Estado</td>
            <td align="center">Cidade</td>
            <td align="center">CEP</td>
            <td align="center">Bairro</td>
            <td align="center">Nota</td>
            <td align="center">Codigo</td>
        </tr>

    <?php 
        while($linha = mysqli_fetch_array($query)){
            
            $trans_id = $linha['trans_id'];
            $moto_cpf = $linha['moto_cpf'];
            $nome = $linha['nome'];
            $monitor = $linha['monitor'];
            $placa = $linha['placa'];
            $n_assentos = $linha['n_assentos'];
            $estado = $linha['estado'];
            $cidade = $linha['cidade'];
            $cep = $linha['cep'];
            $bairro = $linha['bairro'];
            $nota = $linha['nota'];
            $codigo = $linha['codigo'];

            

            echo "
                <tr> 
                    <td> $trans_id</td>
                    <td> $moto_cpf</td>
                    <td> $nome</td>
                    <td> $monitor</td>
                    <td> $placa</td>
                    <td> $n_assentos</td>
                    <td> $estado</td>
                    <td> $cidade</td>
                    <td> $cep</td>
                    <td> $bairro</td>
                    <td> $nota</td>
                    <td> $codigo</td>
                </tr>
            ";
        
        }

    ?>
</table>
        </div>

    </div>
</body>

</html>