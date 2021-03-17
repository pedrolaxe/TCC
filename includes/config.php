<?php
/**
 * As configurações básicas do SUPERADMIN.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL.
 *
 * Esse arquivo é usado pelo script de criação config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "config.php" e preencher os valores.
 *
 */

  $mysqli = new mysqli("localhost", "root", "", "13notas");
  $mysqli->set_charset("utf8");

      date_default_timezone_set('America/Sao_Paulo');

define("VERSION","2.2.1");
define("COPYRIGHT", "SPACEADMIN");
define("HEADER", "includes/templates/header.php");
define("FOOTER", "includes/templates/footer.php");
define("URLSITE", "http://localhost/superadmin");
define("URLIMGS", URLSITE."/uploads/imgs/");

include "functions.php";
include "blog_functions.php";

$tempolimite = 300000; //5 minutos
$titpainel = 'SPACEADMIN';
$linksite = URLSITE;
?>
