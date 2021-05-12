<?php
$host      = 'localhost';
$username  = 'root';
$password  = '123456';
$database  = 'dedal';

// $con = new mysqli($host, $username, $password, $database);

$con = new PDO('mysql:host=localhost;dbname=dedal', $username, $password);
// $con->set_charset("utf8");

date_default_timezone_set('America/Sao_Paulo');

define('LINK_SITE','/');

if(!$con) {
  header('Location: '.LINK_SITE.'includes/erro.php');
  die( "Database connection failed" );
}

?>