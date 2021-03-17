<?php
  @session_start();
  include "includes/config.php";

  @$usuario = $_SESSION['usuario_admin'];
  @$senha   = $_SESSION['senha_admin'];
  @$id_adm  = $_SESSION['id_adm'];

  @$senhaenc = Encriptar($_SESSION['senha_admin']);

  $sql = $mysqli->query("SELECT * FROM zn_users WHERE usuario = '{$_SESSION['usuario_admin']}' AND senha = '{$_SESSION['senha_admin']}' AND funcao='{$_SESSION['id_adm']}'");
     $linha = $sql->fetch_assoc();
               $usuario = $linha['usuario'];
               $senha   = $linha['senha'];
               $id_adm  = $linha['funcao'];
     
  if($_SESSION['usuario_admin'] != $usuario && $_SESSION['senha_admin'] != $senha && $_SESSION['id_adm'] != $id_adm){
    echo '<script>window.location.href = "login";</script>';
  }

  if(!isset($_SESSION['usuario_admin']) && (!isset($_SESSION['senha_admin'])) && (!isset($_SESSION['id_adm'])) ){
    echo '<script>window.location.href = "login";</script>';
  }
?>
