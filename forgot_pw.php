<?php 
include 'includes/functions.php';
  session_start();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Sistema Restaurante</title>

    <?php include 'includes/head.php' ?>
    
    <link href="<?=LINK_SITE;?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=LINK_SITE;?>assets/css/signin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=LINK_SITE;?>assets/css/main.css" media="screen" />


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      button {
        border: 0 !important;
      }
    </style>

  </head>
  <body class="text-center">

    <?php include 'includes/head.php' ?>
    
<main class="form-signin">
  <form action="index.php" method="POST">

    <h1 style="font-size: 64px">Esqueci a Senha</h1>

    <br>

    <label for="inputEmail" class="visually-hidden">Email</label>
    <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>    
    <br>
    <button name="submit" class="w-100 btn btn-lg btn-primary" type="submit">Enviar</button>
    <br><br>
  </form>
  <a href="<?=LINK_SITE;?>"><button class="w-100 btn btn-lg btn-outline-secondary">Voltar</button></a>
</main>

<script type="text/javascript">
  
// ==UserScript==
// @name        Wordswithfriends, Block javascript alerts
// @match       http://wordswithfriends.net/*
// @run-at      document-start
// ==/UserScript==

// addJS_Node (null, null, overrideSelectNativeJS_Functions);

// function overrideSelectNativeJS_Functions () {
//     window.alert = function alert (message) {
//         console.log (message);
//     }
// }

// function addJS_Node (text, s_URL, funcToRun) {
//     var D                                   = document;
//     var scriptNode                          = D.createElement ('script');
//     scriptNode.type                         = "text/javascript";
//     if (text)       scriptNode.textContent  = text;
//     if (s_URL)      scriptNode.src          = s_URL;
//     if (funcToRun)  scriptNode.textContent  = '(' + funcToRun.toString() + ')()';

//     var targ = D.getElementsByTagName ('head')[0] || D.body || D.documentElement;
//     targ.appendChild (scriptNode);
// }

</script>
    
  </body>
</html>
