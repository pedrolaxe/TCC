<?php
include '../includes/config.php';
//remove Contra-Cheques
$id = anti_injection(mysql_real_escape_string(base64_decode($_GET['id'])));
$ucq = anti_injection(mysql_real_escape_string(base64_decode($_GET['ucq'])));
if(empty($id)){
	echo "<script>alert('Falha: ID Vazio!')</script>";
	echo "<script>javascript:open('../contra-cheques', '_top')</script>";
}else{
if(is_numeric($id) && is_numeric($ucq)){

$query = mysql_query("DELETE FROM zn_contracheques WHERE id='$id' AND id_user='$ucq' ");
if($query){
	echo "<script>alert('Apagado com Sucesso!')</script>";
	echo "<script>javascript:open('../contra-cheques', '_top')</script>";
}else{
	echo "<script>alert('Erro ao Apagar!')</script>";
	echo "<script>javascript:open('../contra-cheques', '_top')</script>";
}

}
}//empty id
?>﻿
