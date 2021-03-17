<?php
include '../includes/config.php';

$id = anti_injection(mysql_real_escape_string(base64_decode($_GET['id'])));
if(empty($id)){
	echo "<script>alert('Falha: ID Vazio!')</script>";
	echo "<script>javascript:open('../todos-usuarios', '_top')</script>";
}else{
if(is_numeric($id)){

$query = mysql_query("UPDATE zn_users SET ativo='1' WHERE id='$id'");
if($query){
	echo "<script>alert('Ativado!')</script>";
	echo "<script>javascript:open('../todos-usuarios', '_top')</script>";
}else{
	echo "<script>alert('Erro ao Ativar!')</script>";
	echo "<script>javascript:open('../todos-usuarios', '_top')</script>";
}
}
}//empty id
?>﻿
