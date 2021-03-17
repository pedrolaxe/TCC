<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";

$id = base64_decode(anti_injection(mysql_real_escape_string($_GET['id'])));

if(is_desativado($id)==false){

$query = mysql_query("UPDATE zn_posts SET ativo='0' WHERE id='$id'");
if($query){
	echo "<script>javascript:open('../novo-post', '_top')</script>";
}else{
	echo "<script>alert('Erro!')</script>";
	echo "<script>javascript:open('../novo-post', '_top')</script>";
}
}else{
	echo "<script>alert('O Post ja esta desativado!')</script>";
	echo "<script>javascript:open('../novo-post', '_top')</script>";
}
?>
