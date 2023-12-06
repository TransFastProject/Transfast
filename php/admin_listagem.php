<?php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Listagem Usuários</title>
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
            <div id="gere_local"><a href="admin_listagem.php">Listagem</a></div><br />
            <div class="gere_links"><a href="admin_motoristas.php">Motoristas</a></div><br />
            <div class="gere_links"><a href="admin_responsaveis.php">Responsáveis</a></div><br />
            <div class="gere_links"><a href="admin_criancas.php">Crianças</a></div><br />
            <div class="gere_links"><a href="admin_transporte.php">Transportes</a></div><br />
        </div>

        <footer id="gere_sair"><a href="sair.php">Sair</a></footer>
    </div>
    <div id="gere_conteudo">
        <div id="listagem_titulo">
            <h1>Listagem De Usuários</h1>
        </div>
        <div style="margin-top: 10vh;">

            <div class="links_listagem"><img src="../img/listagem_motorista.png"><a href="admin_motoristas.php">
                    <div>Motorista</div>
                </a></div>
            <div class="links_listagem"><img src="../img/listagem_responsavel.png"><a href="admin_responsaveis.php">
                    <div>Responsável</div>
                </a></div>
                <div class="links_listagem"><img src="../img/listagem_crianca.png"><a href="admin_criancas.php">
                    <div>Crianca</div>
                </a></div>
            <div class="links_listagem"><img src="../img/listagem_transporte.png"><a href="admin_transporte.php">
                    <div>Transporte</div>
                </a></div>
        </div>

    </div>
</body>

</html>