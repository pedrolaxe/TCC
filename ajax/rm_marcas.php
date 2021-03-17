<?php
include '../includes/config.php';
global $mysqli;

$id = anti_injection(base64_decode(mysqli_real_escape_string($mysqli, $_GET['id'])));
if(empty($id)){
	header("Location: ../cat-marcas");
}else{
if(is_numeric($id)){

$query = $mysqli->query("DELETE FROM zn_marcas WHERE id='$id'");
if($query){
	header("Location: ../cat-marcas");
}else{
	echo "<script>alert('Erro ao Apagar!')</script>";
	header("Location: ../cat-marcas");
}
}
}//empty id
?>﻿