<?php
$host      = 'localhost';
$username  = 'root';
$password  = '123456';
$database  = 'dedal';

$con = mysqli_connect( $host, $username, $password, $database );

define('LINK_SITE','/');

if(!$con) {
  header('Location: '.LINK_SITE.'erro.php');
  die( "Database connection failed" );
}

?>
