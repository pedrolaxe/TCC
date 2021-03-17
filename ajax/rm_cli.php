<?php
include '../includes/config.php';
global $mysqli;

$id = anti_injection(base64_decode(mysqli_real_escape_string($mysqli, $_GET['id'])));
if(empty($id)){
	echo "<script>alert('Falha: ID Vazio!')</script>";
	header("Location: ../plugin-clientes");
}else{
	if(is_numeric($id)){

	$query = $mysqli->query("DELETE FROM zn_clients WHERE id='$id'");
		if($query){
		header("Location: ../plugin-clientes");
		
		}else{
			echo "<script>alert('Erro ao Apagar!')</script>";
			header("Location: ../plugin-clientes");
		}
	}
}//empty id
?>﻿
