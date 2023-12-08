<?php
include_once "conexao.php";
session_start();
$moto_nome = "SELECT nome FROM motorista WHERE moto_cpf='" . $_SESSION['moto_cpf'] . "'";
$link_moto = mysqli_query($sql, $moto_nome);
$linked_moto = mysqli_fetch_assoc($link_moto);

if (isset($_SESSION["moto_cpf"])) {
  $stmt = mysqli_prepare($sql, "SELECT * FROM motorista WHERE moto_cpf = ?");
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['moto_cpf']);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_array($result)) {
  } else {
    echo "Motorista não encontrado.";
  }
} else {
  echo "Parâmetro 'moto_cpf' não fornecido na URL.";
}

if (isset($_SESSION["moto_cpf"])) {
  $stmt = mysqli_prepare($sql, "SELECT * FROM transporte WHERE moto_cpf = ?");
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['moto_cpf']);
  mysqli_stmt_execute($stmt);
  $result2 = mysqli_stmt_get_result($stmt);

  if ($row_t = mysqli_fetch_array($result2)) {
    $trans_id = $row_t['trans_id'];

    $stmt_c = mysqli_prepare($sql, "SELECT escola FROM crianca WHERE trans_id = ?");
    mysqli_stmt_bind_param($stmt_c, "s", $trans_id);
    mysqli_stmt_execute($stmt_c);
    $result3 = mysqli_stmt_get_result($stmt_c);

    if ($row_c = mysqli_fetch_array($result3)) {
    } else {
      //sem criança vinculada ao transporte, logo sem escolas e mostrando " - "
    }
  } else {
    echo "Transporte não encontrado.";
  }
} else {
  echo "Parâmetro 'moto_cpf' não fornecido na URL.";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <title>Perfil</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../css/estilo.css">
  <link rel="stylesheet" href="../css/gerenciamento.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
  <script type="text/JavaScript"></script>
</head>

<body>
  <div id="gere_menu">
    <div class="btn_expandir">
      <i class="bi bi-caret-right-square"></i>
    </div>
    <div>

      <?php
      include "conexao.php";
      if ($sql === false) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
      }
      $moto_cpf = $_SESSION['moto_cpf'];
      $result = mysqli_query($sql, "SELECT foto FROM motorista WHERE moto_cpf = '$moto_cpf'");
      if ($result) {
        $rowft = mysqli_fetch_assoc($result);
        $imagem = $rowft['foto'];
        if ($imagem) {
          echo '<img src="data:image/jpeg;base64,' . base64_encode($imagem) . '" style="border-radius: 50%; width: 11vw; height: 11vw; object-fit: cover;">';
        } else {
          echo '<img src="../img/fundo_foto_padrao.png" alt="Foto do Perfil" style="width:11vw;height:11vw;">';
        }
      } else {
        echo "Erro ao obter a foto do banco de dados: " . mysqli_error($sql);
      }
      ?>

      <p>Bem Vindo<br>
        <?php echo $linked_moto['nome'] . PHP_EOL ?>
      </p>
    </div>
    <div>
      <br />
      <div class="gere_links"><a href="gere_inicio.php">Home</a></div><br />
      <div class="gere_links"><a href="gere_revisao.php">Revisão</a></div><br />
      <div class="gere_links"><a href="gere_criancas_escolas.php">Crianças</a></div><br />
      <div class="gere_links"><a href="gere_lucro.php">Lucro</a></div><br />
      <div id="gere_local"><a href="gere_perfil.php">Perfil</a></div><br />
      <div class="gere_links"><a href="gere_chamada_escolas.php">Chamada</a></div><br />
      <div class="gere_links"><a href="chat_motorista.php">Chat</a></div><br />
    </div>
    <footer id="gere_sair"><a href="sair.php">Sair</a></footer>
  </div>

  <div id="gere_conteudo">
    <div id="perfil">
      <div id="foto_perfil">
        <form id="formularioft" action="processar_foto.php" method="post" enctype="multipart/form-data">
          <label for="seletor-foto">

            <?php //onde vai mostrar a foto do perfil
            include "conexao.php";

            if ($sql === false) {
              die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
            }
            $moto_cpf = $_SESSION['moto_cpf'];
            $result = mysqli_query($sql, "SELECT foto FROM motorista WHERE moto_cpf = '$moto_cpf'");

            if ($result) {
              $rowft = mysqli_fetch_assoc($result);
              $imagem = $rowft['foto'];

              if ($imagem) {
                echo '<div id="foto-container" style="position: relative; display: inline-block; width:12vw;">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imagem) . '" id="foto" style="border-radius: 50%; transition: filter 0.5s; filter: brightness(100%); width: 12vw; height: 12vw; object-fit: cover;" alt="Foto do Perfil">';
                echo '<span id="icone-mais" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 70px; color: white; opacity: 0; transition: opacity 0.5s; ">+</span>';
                echo '</div>';

              } else {
                echo '<div id="foto-container" style="position: relative; display: inline-block; width:12vw;">';
                echo '<img src="../img/fundo_foto_padrao.png" id="foto" style="border-radius: 50%; transition: filter 0.5s; filter: brightness(100%);" alt="Foto do Perfil">';
                echo '<span id="icone-mais" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 70px; color: white; opacity: 0; transition: opacity 0.5s; ">+</span>';
                echo '</div>';

              }

            } else {
              echo "Erro ao obter a foto do banco de dados: " . mysqli_error($sql);

            }

            ?>
          </label>
          <input type="file" name="foto" id="seletor-foto" style="display:none;" accept="image/*"><br>
        </form>


      </div>

      <form type="text" name="form" method="post" id="formsperfil" action="salvar_perfil.php">
        <div class="form-container">

          <!-- Campos principais -->
          <div class="form-group">
            <label for="nome"><b>Nome:</b></label>
            <input type="text" id="nome" name="nome" value="<?php echo $row['nome']; ?>">
            <label for="codigo">Codigo:</label>
            <input type="text" id="codigo" name="codigo" value="<?php echo $row_t['codigo']; ?>" readonly>
            <!--  editar esse input que aparece o nome, editar a fonte também, deixar sem borda e nome grande  -->
          </div>
          <div class="form-group">

            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" value="<?php echo $row_t['estado']; ?>">
            <label for="cep">Zona:</label>
            <input type="text" id="cep" name="cep" value="<?php echo $row_t['cep']; ?>">

          </div>

          <div class="form-group">
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" value="<?php echo $row_t['bairro']; ?>">

            <label for="cidade" style=" width: 8%;">Cidade:</label>
            <input type="text" id="cidade" name="cidade" value="<?php echo $row_t['cidade']; ?>">
          </div>

          <div class="form-group">
            <label for="genero">Gênero:</label>
            <select id="genero" name="genero">
              <option value="<?php echo $row['genero']; ?>">
                <?php echo $row['genero']; ?>
              </option>
              <option value="masculino">Masculino</option>
              <option value="feminino">Feminino</option>
              <option value="outro">Outro</option>
            </select>

          </div>
          <div class="form-group">
            <label for="escola">Escolas:</label>

            <select id="escola" name="escola">
              <?php
              $result3 = $sql->query("SELECT escola FROM crianca where trans_id = $trans_id");
              if ($result3 !== false && $result3->num_rows > 0) {
                while ($row_c = $result3->fetch_assoc()) {
                  echo "<option value='{$row_c['escola']}'>{$row_c['escola']}</option>";
                }
              } else {
                echo "<option value='-'>-</option>";
              }
              ?>
            </select>

          </div>
          <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" style="text-align: center;"
              value="<?php echo $row['data_nascimento']; ?>">

            <label for="cidade">Monitor:</label>
            <input type="text" id="monitor" name="monitor" value="<?php echo $row_t['monitor'];?>">
          </div>

          <div class="responsavel_dados">

            <div class="form-group">
              <label for="telefone">Contato:</label>
              <input type="text" id="telefone" name="telefone" value="<?php echo $row['telefone']; ?>">

            </div>
            <div class="form-group" style=" border-bottom-width: 0;">
              <input type="submit" value="Salvar" id="gp_btn" style="top:20vw;position:relative;">
            </div>
          </div>
      </form>
      <!-- colocar para mostrar numero de assentos -->
      <!-- tirar crianças especiais (quando terminar apaga esses comentarios :)  -->
      <form id="form_transporte" action="processar_transporte.php" method="POST" enctype="multipart/form-data">
        <div class="fotos_veiculo">
          <div class="btn_add_foto">
            <p> Adicione uma imagem do veiculo</p>
            <label for="seletor-transporte">
              <?php
              include 'conexao.php';

              if ($sql === false) {
                die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
              }
              $moto_cpf = $_SESSION['moto_cpf'];
              $result = mysqli_query($sql, "SELECT foto FROM transporte WHERE moto_cpf = '$moto_cpf'");

              if ($result) {
                $rowTrans = mysqli_fetch_assoc($result);
                $foto_transporte = $rowTrans['foto'];

                if ($foto_transporte) {
                  echo '<div id="foto-containerTrans" style="position: relative; display: inline-block; width:12vw;">';
                  echo '<img src="data:image/jpeg;base64,' . base64_encode($foto_transporte) . '" id="foto_transporte" style="transition: filter 0.5s; filter: brightness(100%); width: 12vw; height: 12vw; object-fit: cover; top:-2vw;">';
                  echo '<span id="icone-maist" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 70px; color: white; opacity: 0; transition: opacity 0.5s; ">+</span>';
                  echo '</div>';

                } else {
                  echo '<div id="foto-containerTrans" style="position: relative; display: inline-block; width:12vw;">';
                  echo '<img src="../img/foto_transporte.png" id="foto_transporte" style="transition: filter 0.5s; filter: brightness(100%);width: 12vw; height: 12vw; object-fit: cover;">';
                  echo '<span id="icone-maist" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 70px; color: white; opacity: 0; transition: opacity 0.5s; ">+</span>';
                  echo '</div>';
                }
              } else {
                echo "Erro ao obter a foto do banco de dados: " . mysqli_error($sql);
              }
              ?>
            </label>
            <input type="file" name="foto_transporte" id="seletor-transporte" style="display:none;"
              accept="image/*"><br>
          </div>
        </div>
      </form>
    </div>
  </div>
  </div>

  <script type="text/JavaScript">
    //parte de aparecer o simbolo e a imagem ficar mais escura.
    document.getElementById('foto-container').addEventListener('mouseover', function () {
      document.getElementById('foto').style.filter = 'brightness(40%)';
      document.getElementById('icone-mais').style.opacity = '1';
    });

    document.getElementById('foto-container').addEventListener('mouseout', function () {
      document.getElementById('foto').style.filter = 'brightness(100%)';
      document.getElementById('icone-mais').style.opacity = '0';
    });

    //parte do upload da foto
    document.getElementById('seletor-foto').addEventListener('change', function (event) {
      var file = event.target.files[0];
      var reader = new FileReader();

      reader.onload = function () {
        var fotoExibicao = document.getElementById('foto');
        fotoExibicao.src = reader.result;

        var formData = new FormData(document.getElementById('formularioft'));
        document.getElementById('formularioft').submit(); // Enviar o formulário automaticamente
        var xhr = new XMLHttpRequest();
        

        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              console.log('Formulário enviado com sucesso.');
            } else {
              console.error('Erro ao enviar o formulário: ' + xhr.status);
            }
          }
        };
        xhr.open('POST', 'processar_foto.php', true);
        xhr.send(formData);
      }
      reader.readAsDataURL(file);

    });
    document.getElementById("gp_btn").addEventListener("click", function () {
    alert("A alteração foi feita com sucesso!");
  });
    //meu codigo
    document.getElementById('foto-containerTrans').addEventListener('mouseover', function () {
    document.getElementById('foto_transporte').style.filter = 'brightness(40%)';
    document.getElementById('icone-maist').style.opacity = '1';
});

document.getElementById('foto-containerTrans').addEventListener('mouseout', function () {
    document.getElementById('foto_transporte').style.filter = 'brightness(100%)';
    document.getElementById('icone-maist').style.opacity = '0';
});

document.getElementById('seletor-transporte').addEventListener('change', function (event) {
    var fileTransporte = event.target.files[0];
    var readerTransporte = new FileReader();

    readerTransporte.onload = function () {
        var fotoExibicaoTransporte = document.getElementById('foto_transporte');
        fotoExibicaoTransporte.src = readerTransporte.result;

        var formDataTransporte = new FormData(document.getElementById('form_transporte'));
        document.getElementById('form_transporte').submit(); // Enviar o formulário automaticamente
        var xhrTransporte = new XMLHttpRequest();
        xhrTransporte.onreadystatechange = function () {
            if (xhrTransporte.readyState === XMLHttpRequest.DONE) {
                if (xhrTransporte.status === 200) {
                    console.log('Foto do transporte enviada com sucesso.');
                } else {
                    console.error('Erro ao enviar a foto do transporte: ' + xhrTransporte.status);
                }
            }
        };

        xhrTransporte.open('POST', 'processar_transporte.php', true);
        xhrTransporte.send(formDataTransporte);
    };

        readerTransporte.readAsDataURL(fileTransporte);
});
  </script>
</body>

</html>