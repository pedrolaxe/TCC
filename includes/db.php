<?php
$host      = 'localhost';
$username  = 'root';
$password  = '';
$database  = 'dedal2';

$con = new mysqli($host, $username, $password, $database);
$con->set_charset("utf8");

date_default_timezone_set('America/Sao_Paulo');

define('LINK_SITE','http://localhost/TCC/');

if(!$con) {
  header('Location: '.LINK_SITE.'includes/erro.php');
  die( "Database connection failed" );
}

?>
