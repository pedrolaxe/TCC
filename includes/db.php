<?php

$host      = 'localhost';
$username  = 'root';
$password  = '';
$database  = 'tcc';

$con = mysqli_connect( $host, $username, $password, $database );

if($con) {
  // echo "We are connected";
} else {
  header('Location: erro.php');
  die( "Database connection failed" );
}

?>
