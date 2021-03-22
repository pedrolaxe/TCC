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

      <h1>Recuperar Senha</h1>
      <br>

      <label for="inputEmail" class="visually-hidden">Email</label>
      <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
      <br>
      <button name="submit" class="w-100 btn btn-lg btn-outline-primary" type="button" id="enviar">Enviar</button>
    </form>
    <a href="<?= LINK_SITE; ?>"><button class="w-100 btn btn-lg btn-outline-secondary">Voltar</button></a>
  </main>
  <div class="text-center">
    <div id="error"></div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {

      $('#enviar').click(function() {
        var email = $("#inputEmail").val();
        var dataString = 'email=' + email;
        if ($.trim(email).length > 0) {
          $.ajax({
            type: "POST",
            url: "sendpass.php",
            data: dataString,
            cache: false,
            beforeSend: function() {
              $("#error").val('Aguarde...');
            },
            success: function(data) {
              if (data) {
                $("#error").html(data);
              }

            }
          });

        }
        return false;
      });

    });
  </script>
</body>

</html>