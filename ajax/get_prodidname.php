<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

$equipid = $_POST['equipid'];


$result = $mysqli->query("SELECT nome FROM zn_equipamentos WHERE id='$equipid' ");

$equip_arr = array();

while( $row = $result->fetch_assoc() ){
    $nome = $row['nome'];

    $equip_arr[] = array("nome" => $nome);
}

// encoding array to json format
echo json_encode($equip_arr);