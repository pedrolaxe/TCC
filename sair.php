<?php
  session_start();
  include"includes/config.php";

  unset($_SESSION['usuario_admin']);
  unset($_SESSION['senha_admin']);
  unset($_SESSION['id_adm']);

  header("Location: login");
session_destroy();
?>
