<?php
include_once "conexao.php";
session_start();

$res_nome = $_SESSION['nome'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/responsavel.css">
    <link rel="stylesheet" href="../css/seuTransporte.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <title>Seu perfil</title>

    <style>
      .campo-perfil{
        border-style: solid;
              color: #fff;
              padding: 0;
              border-bottom-width: 1px;
              border-top-width: 0;
              border-right-width: 0;
              border-left-width: 0;
      }

      input::placeholder { color: #fff; }
    </style>
</head>

<body class="home-body" style="display: flex; height: 100%; flex-direction: column; justify-content: center; align-items: center;">
    <header class="home-header row justify-content-center align-items-center g-2 col-12" style="position: absolute;top: 0;padding: 0 2vw;">
      <span class="col-6" style="display: flex;flex-direction: row; justify-content: start; align-items: center; gap: 4vw;">
        <a href="../html/home_responsavel.html" >
            <img src="../img/logo_v2.png" alt="Logo Transfast" class="home-logo">
        </a>
        <span style="display: flex;flex-direction: row; justify-content: center; align-items: center; gap: 2vw;">
          <a href="perfilResponsavel.php" style="text-decoration: none; color: #fff;">RESPONSÁVEL</a>
          <a href="perfilCriancaSelecionar.php" style="padding: 1vw 1.5vw; background-color: #3C3577; border-radius: 1vw;text-decoration: none;color: #fff;">CRIANÇA</a>
        </span>
      </span>
        

        <div class="home-menu col-6">
            <div class="home-menu-container row justify-content-center align-items-center">
                <div class="home-menu-item col">
                    <a href="home_responsavel.html">
                        <i class="ph ph-house"></i>
                        <p>Início</p>
                    </a>
                </div>
                <div class="home-menu-item col">
                    <a href="">
                        <i class="ph ph-chat-circle-dots"></i>
                        <p>Mensagens</p>
                    </a>
                </div>
                <div class="home-menu-item col">
                    <a href="">
                        <i class="ph ph-van"></i>
                        <p>Seu transporte</p>
                    </a>
                </div>
                <div class="home-menu-item col">
                    <a href="">
                        <i class="ph ph-user"></i>
                        <p>Perfil</p>
                    </a>
                </div>
            </div>

        </div>
    </header>

    <div class="semTransporte" style="margin-top: 5vw;">
        <div class="perfil-container" style="width:50vw; display: flex;flex-direction: column; justify-content: center; align-items: start;gap: 3vw;">
        <form action="addCriancaCodigo.php" method="post" enctype="multipart/form-data" style="display: flex;flex-direction: column; justify-content: center; align-items: start;gap: 3vw;">
          <span style="display: flex;flex-direction: row; justify-content: start; align-items: center;gap: 2vw;">
          <div class="fotoPerfil-div" style="display: flex; flex-direction: column; justify-content: center; align-items: center">
                <img id="previewFoto" src="../img/fundo_foto_padrao.png" class="rounded-circle" style="width: 10vw; height: 10vw; object-fit: cover;">
            <label for="novaFotoPerfil" style="position: absolute; cursor: pointer" id="novaFotoPerfil-label"><i class="ph ph-pencil" style="font-size: 3vw"></i></label>
            <input type="file" id="novaFotoPerfil" name="novaFotoPerfil" style="display: none;" accept="image/*" onchange="previewImagem(this);">
          </div>
            <div class="perfil-info-usuario">
              <p style="margin: 0; font-size: 25px;"><input type="text" name="nome" placeholder="Nome da criança" style="background: none; font-size: 25px; color: #fff; border: none; outline: none;"></p>
            </div>
          </span>
          <div class="perfil-info" style="width: 100%;display: flex;flex-direction: column; justify-content: center; align-items: center; gap: 1vw;">
            <span style="display: flex;flex-direction: row; justify-content: space-between; align-items: center; width: 100%;">
              <span style="width: 23vw;">
              <p style="border-style: solid; color: #fff; padding: 0; border-bottom-width: 1px; border-top-width: 0; border-right-width: 0; border-left-width: 0; height: 2vw; display: flex;flex-direction: row; justify-content: start; align-items: center; gap: 10px">Gênero: 
                <!-- Campo de Seleção para Gênero -->
              <select name="genero" class="campo-perfil" style="background: none; width: 23vw; border: none; outline: none; -moz-appearance: none; -webkit-appearance: none;">
                  <option value="" selected style="background-color: #1E184C;">Selecione</option>
                  <option value="Masculino" style="background-color: #1E184C;">Masculino</option>
                  <option value="Feminino" style="background-color: #1E184C;">Feminino</option>
                  <option value="Outro" style="background-color: #1E184C;">Outro</option>
                  <option value="Prefiro não dizer" style="background-color: #1E184C;">Prefiro não dizer</option>
              </select>
              </p>
              </span>
              <span style="width: 23vw;">
                <p class="campo-perfil" style="display: flex;flex-direction: row; justify-content: start; align-items: center; height: 2vw;">Escola: <input type="text" name="escola" style="background: none; color: #fff; border: none; outline: none;"></p>
                <p></p>
              </span>
            </span>
            <span style="display: flex;flex-direction: row; justify-content: space-between; align-items: center; width: 100%;">
              <span style="width: 23vw;">
                <p class="campo-perfil"style="display: flex;flex-direction: row; justify-content: start; align-items: center; white-space: nowrap; height: 2vw;">Data de nascimento: <input type="text" name="data_nascimento" style="background: none; color: #fff; border: none; outline: none;"></p>
                <p></p>
              </span>
              <span style="width: 23vw;">
                <p class="campo-perfil" style="display: flex;flex-direction: row; justify-content: start; align-items: center; height: 2vw;">Responsável: <input type="text" name="responsavel" value="<?php echo $res_nome; ?>" style="background: none; color: #fff; border: none; outline: none;" readonly></p>
                <p></p>
              </span>
            </span>
            <span style="display: flex;flex-direction: row; justify-content: space-between; align-items: center; width: 100%;">
              <span style="width:50vw;">
              <p style="border-style: solid; color: #fff; padding: 0; border-bottom-width: 1px; border-top-width: 0; border-right-width: 0; border-left-width: 0; height: 2vw;display: flex;flex-direction: row; justify-content: start; align-items: center; gap: 10px">Deficiência: 
                <!-- Campo de Seleção para Deficiência -->
              <select name="deficiencia" class="campo-perfil" style="background: none; width: 50vw; border: none; outline: none; -moz-appearance: none; -webkit-appearance: none;">
                  <option value="" selected style="background-color: #1E184C;">Selecione</option>
                  <option value="Nenhuma" style="background-color: #1E184C;">Não possui</option>
                  <option value="Física" style="background-color: #1E184C;">Física</option>
                  <option value="Visual" style="background-color: #1E184C;">Visual</option>
                  <option value="Auditiva" style="background-color: #1E184C;">Auditiva</option>
                  <option value="Cognitiva" style="background-color: #1E184C;">Cognitiva</option>
              </select>
              </p>
              </span>
            </span>
          </div>

          <div class="salvar" style="width: 100%; display: flex; flex-direction:column; justify-content: center; align-items:center; gap: 1vw;">
            <input type="submit" style="border: none; width: 12vw; height: 2.5vw;  border-radius: 1vw; text-align: center; display: flex; justify-content: center; align-items: center;" name="submit" value="Salvar">
            <button style="border: none; width: 12vw; height: 2.5vw; border-radius: 1vw;">Voltar</button>
          </div>

          </form>
        </div>
    </div>

    <script>
      function previewImagem(input) {
          var preview = document.getElementById('previewFoto');
          var file = input.files[0];
          var reader = new FileReader();

          reader.onloadend = function () {
              preview.src = reader.result;
          };

          if (file) {
              reader.readAsDataURL(file);
          } else {
              preview.src = "../img/fundo_foto_padrao.png";
          }
      }
    </script>
</body>
</html>