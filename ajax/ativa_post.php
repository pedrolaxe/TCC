<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "verifica.php";
$id = base64_decode(anti_injection(mysql_real_escape_string($_GET['id'])));

$query = mysql_query("UPDATE zn_posts SET ativo='1' WHERE id='$id'");
if($query){
	echo "<script>javascript:open('../novo-post', '_top')</script>";
}else{
	echo "<script>alert('Erro! :(')</script>";
	echo "<script>javascript:open('../novo-post', '_top')</script>";
}
?>
