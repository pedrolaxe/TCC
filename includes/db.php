<?php
$host      = 'localhost';
$username  = 'pmauser';
$password  = 't$d3tUDzd#h=KJSLAxe095}7T';
$database  = 'tcc';

// $con = new mysqli($host, $username, $password, $database);

$con = new PDO('mysql:host=localhost;dbname=tcc', $username, $password);
// $con->set_charset("utf8");

date_default_timezone_set('America/Sao_Paulo');

define('LINK_SITE','/');

if(!$con) {
  header('Location: '.LINK_SITE.'includes/erro.php');
  die( "Database connection failed" );
}

?>
