<?php
$host      = 'localhost';
$username  = 'pmauser';
$password  = 'dread@1995';
$database  = 'dedal';

$con = mysqli_connect( $host, $username, $password, $database );

define('LINK_SITE','/tcc/');

if(!$con) {
  header('Location: '.LINK_SITE.'includes/erro.php');
  die( "Database connection failed" );
}

?>
