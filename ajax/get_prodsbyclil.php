<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

$clienteid = $_POST['clienteid'];


$result = $mysqli->query("SELECT * FROM zn_equipamentos WHERE cliente='$clienteid' ");

$equip_arr = array();

while( $row = $result->fetch_assoc() ){
    $userid = $row['id'];
    $nome = $row['nome'];

    $equip_arr[] = array("id" => $userid, "nome" => $nome);
}

// encoding array to json format
echo json_encode($equip_arr);