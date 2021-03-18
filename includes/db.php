<?php
$host      = 'localhost';
$username  = 'root';
$password  = '';
$database  = 'dedal';

$con = mysqli_connect( $host, $username, $password, $database );

define('LINK_SITE','http://localhost/TCC/');

if(!$con) {
  header('Location: '.LINK_SITE.'erro.php');
  die( "Database connection failed" );
}

?>
