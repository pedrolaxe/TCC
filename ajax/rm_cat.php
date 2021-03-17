<?php
include '../includes/config.php';

$id = anti_injection(base64_decode(mysqli_real_escape_string($mysqli, $_GET['id'])));
if(empty($id)){
	header("Location: ../categorias");
}else{
if(is_numeric($id)){

$query = $mysqli->query("DELETE FROM zn_categories WHERE id='$id'");
if($query){
	header("Location: ../categorias");
}else{
	echo "<script>alert('Erro ao Apagar!')</script>";
	header("Location: ../categorias");
}
}
}//empty id
?>﻿