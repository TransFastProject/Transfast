<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Faça seu cadastro</title>
  <link rel="stylesheet" href="../css/estilo.css" />
  <link rel="stylesheet" href="../css/cadastro.css">
  <script language="javascript">
    function ChecaCpf() {
      try {
        objetoAJAX = new XMLHttpRequest();
      } catch (e1) {
        try {
          objetoAJAX = new ActiveXObject("MSXM12.XMLHTTP");
        } catch (e2) {
          try {
            objetoAJAX = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e3) {
            obejtoAJAX = false;
          }
        }
      }
      if (objetoAJAX) {
        var objSpan = document.getElementById("avisoCpf");
        objSpan.innerHTML = "Checando...";
        var txtCPF = document.getElementById("cpf").value;
        var enderecoURL = 'localizaCpf.php?moto_cpf=' + escape(txtCPF);

        objetoAJAX.open("GET", enderecoURL, true);
        objetoAJAX.onreadystatechange = function () {
          if (objetoAJAX.readyState == 4) {
            if (objetoAJAX.status == 200) {
              var texto = objetoAJAX.responseText;

              objSpan.innerHTML = texto;
            } else {
              objSpan.innerHTML = "Falha na localização do CPF:" + objetoAJAXstatusText;
            }
          }
        }
        objetoAJAX.send(null);
      }
    }
    function ChecaEmail() {
      try {
        objetoAJAX = new XMLHttpRequest();
      } catch (e1) {
        try {
          objetoAJAX = new ActiveXObject("MSXM12.XMLHTTP");
        } catch (e2) {
          try {
            objetoAJAX = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e3) {
            obejtoAJAX = false;
          }
        }
      }
      if (objetoAJAX) {
        var objSpan = document.getElementById("avisoEmail");
        objSpan.innerHTML = "Checando...";
        var txtEmail = document.getElementById("email").value;
        var enderecoURL = 'localizaEmail.php?email=' + escape(txtEmail);

        objetoAJAX.open("GET", enderecoURL, true);
        objetoAJAX.onreadystatechange = function () {
          if (objetoAJAX.readyState == 4) {
            if (objetoAJAX.status == 200) {
              var texto = objetoAJAX.responseText;

              objSpan.innerHTML = texto;
            } else {
              objSpan.innerHTML = "Falha na localização do Email:" + objetoAJAXstatusText;
            }
          }
        }
        objetoAJAX.send(null);
      }
    }


  </script>
</head>

<body class="cad_body">
  <form action="salvar_motorista.php" method="POST" class="forms_cadastro">
    <h1>Faça seu cadastro</h1>

    <div>
      <div>
        <label for="" class="label_cad"><b>Nome</b></label><br />
        <input type="text" name="nome" id="nome" class="input_cad" required /><br />
      </div>
      <div>
        <label for="" class="label_cad"><b>Senha</b></label><br />
        <input type="password" name="senha" id="senha" class="input_cad" placeholder="6 Caracteres ou mais"
          required /><br />
      </div>
    </div>

    <div>
      <div>
        <label for="" class="label_cad"><b>Email</b></label><span id="avisoEmail"></span><br />
        <input type="email" name="email" id="email" class="input_cad" oninput="ChecaEmail()" required /><br />
      </div>
      <div>
        <label for="" class="label_cad"><b>Telefone</b></label><br />
        <input type="tel" name="telefone" id="telefone" class="input_cad" required /> <br />
      </div>
    </div>

    
    <div>
      <div>
        <label for="" class="label_cad" id="label_cpf"><b>CPF</b></label><span id="avisoCpf"></span><br><!--Modificiar esse campo para mais para a esquerda e para cima, para do lado dele ficar um campo de genero onde será possivel definir o genero do motorista, seria interessante colocar 4 opções predefinidos como masculino, feminino, não binario, prefiro não dizer-->
        <input type="text" name="cpf" id="cpf" class="input_cad" required /> <br>
      </div>

      <div>
        <label for="" class="label_cad" id="label_genero"><b>Gênero</b></label><span id="avisoCpf"></span><br />
        <select name="genero" id="genero" class="input_cad">
          <option value="masculino">Masculino</option>
          <option value="feminino">Feminino</option>
          <option value="outro">Outro</option>
          <option value="prefiro não dizer">Prefiro não dizer</option>
        </select>
      </div>
    </div>
    
    <div>
      <div>
        <br /><br />
        <label for="" class="label_cad"><b>Data de Nascimento</b></label><br />
        <input type="date" name="dtnascimento" id="dtnascimento" class="input_cad" required />
      </div>
    </div>

    
    <div id="btn_cadastro">
      <input type="submit" value="." name="btnCad" id="btn_fcadastro">
    </div>
    <p>Já possui conta? <a href="../html/login.html">Faça o Login</a></p>

  </form>
</body>

</html>