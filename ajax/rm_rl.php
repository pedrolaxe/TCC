<?php
include '../includes/config.php';

$id = anti_injection(mysql_real_escape_string(base64_decode($_GET['id'])));
if(empty($id)){
	echo "<script>alert('Falha: ID Vazio!')</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
}else{
if(is_numeric($id)){

$query = mysql_query("DELETE FROM zn_relatoriopcs WHERE id='$id'");
if($query){
	echo "<script>alert('Apagado com Sucesso!')</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
}else{
	echo "<script>alert('Erro ao Apagar!')</script>";
	echo "<script>javascript:open('../plugin-registrodepcs', '_top')</script>";
}
}
}//empty id
?>﻿
