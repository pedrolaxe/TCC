<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

$equipid = $_POST['equipid'];


$result = $mysqli->query("SELECT * FROM zn_equipamentos WHERE id='$equipid' ");

$equip_arr = array();

while( $row = $result->fetch_assoc() ){
    $id = $row['id'];
    $valor = $row['valor'];

    $equip_arr[] = array("id" => $id, "valor" => $valor);
}

echo json_encode($equip_arr);