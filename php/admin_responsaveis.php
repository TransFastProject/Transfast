<?php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Listagem dos Responsáveis</title>
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
            <div id="gere_local"><a href="admin_responsaveis.php">Responsáveis</a></div><br />
            <div class="gere_links"><a href="admin_criancas.php">Crianças</a></div><br />
            <div class="gere_links"><a href="admin_transporte.php">Transportes</a></div><br />
        </div>

        <footer id="gere_sair"><a href="sair.php">Sair</a></footer>
    </div>
    <div id="gere_conteudo">
        <div id="listagem_titulo">
            <h1>Listagem Dos Responsáveis</h1>
        </div>
        <?php
    include "conexao.php";
    $query = mysqli_query($sql,"select * from responsavel")
    
    ?>

    <table id="tableResponsavel" border="1">
        <tr>
            <td align="center">Res_CPF</td>
            <td align="center">Nome</td>
            <td align="center">E-mail</td>
            <td align="center">Senha</td>
            <td align="center">Gênero</td>
            <td align="center">Telefone</td>
            <td align="center">Data_Nascimento</td>
            <td align="center">CEP</td>
            <td align="center">Rua</td>
            <td align="center">Bairro</td>
            <td align="center">Numero</td>
            <td align="center">Complemento</td>
        </tr>

    <?php 
        while($linha = mysqli_fetch_array($query)){

            $res_cpf = $linha['res_cpf'];
            $nome = $linha['nome'];
            $email = $linha['email'];
            $senha = $linha['senha'];
            $genero = $linha['genero'];
            $telefone = $linha['telefone'];
            $data_nascimento = $linha['data_nascimento'];
            $cep = $linha['cep'];
            $rua = $linha['rua'];
            $bairro = $linha['bairro'];
            $numero = $linha['numero'];
            $complemento = $linha['complemento'];
            

            echo "
                <tr> 
                    <td> $res_cpf</td>
                    <td> $nome</td>
                    <td> $email</td>
                    <td> $senha</td>
                    <td> $genero</td>
                    <td> $telefone</td>
                    <td> $data_nascimento</td>
                    <td> $cep</td>
                    <td> $rua</td>
                    <td> $bairro</td>
                    <td> $numero</td>
                    <td> $complemento</td>
                    

                </tr>
            ";
        
        }

    ?>
</table>
        </div>

    </div>
</body>

</html>