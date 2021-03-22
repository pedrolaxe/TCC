<?php

session_start();
include 'includes/functions.php';

?>
<!DOCTYPE html>
<html>

<head>
  <title>Sistema Restaurante</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include 'includes/head.php' ?>

  <!-- CSS -->
  <link href="<?php LINK_SITE ?>assets/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php LINK_SITE ?>assets/css/main.css" media="screen" />
</head>

<body class="text-center">

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include 'includes/head.php' ?>

  <main class="form-signin">
  <form action="" method="post">

      <h1>Trocar Senha</h1>
      <br>

      <label for="inputSenha" class="visually-hidden">Digite a Senha</label>
      <input name="senha" type="password" id="inputSenha" class="form-control" placeholder="Digite a Senha" required autofocus>
      
      <label for="inputSenha2" class="visually-hidden">Novamente a Senha</label>
      <input name="senha2" type="password" id="inputSenha2" class="form-control" placeholder="Novamente a Senha" required autofocus>
        <input type="hidden" id="codigo" value="<?php if(!empty($_GET['code'])){echo $_GET['code'];} ?>">
      <br>
      <button class="w-100 btn btn-lg btn-outline-primary" type="button" id="enviar">Enviar</button>
    </form>
  </main>
  <div class="text-center">
    <div id="error"></div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {

      $('#enviar').click(function() {
        var senha = $("#inputSenha").val();
        var senha2 = $("#inputSenha2").val();
        var codigo = $("#codigo").val();
        console.log("Senha1: ", senha, "Senha2: ", senha2, "codigo: ",codigo)

        if(senha == senha2){
        var dataString = 'senha=' + senha+'&codigo=' + codigo;
        if ($.trim(codigo).length > 0 && $.trim(senha).length > 0) {
          $.ajax({
            type: "POST",
            url: "savepass.php",
            data: dataString,
            cache: false,
            beforeSend: function() {
              $("#error").val('Aguarde...');
              console.log("enviando")
            },
            success: function(data) {
              if (data) {
                $("#error").html(data);
                console.log("erro")
              }

            }
          });
        }
        }else{
            console.log("senhas diferentes")
            $("#error").html("senhas diferentes");
        }
        return false;
      });
    

    });
  </script>
</body>


</html>