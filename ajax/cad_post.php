<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "../verifica.php";

$titulo = mysql_real_escape_string($_POST['titulo']);
$slug 	= remover_caracter(strtolower($_POST['slug']));
$data		= date('d/m/Y H:i');
$cat  	= $_POST['zn_categories'];
$texto	= $_POST['textopost'];
$ativo 	= 0;

if(empty($slug)){
	$slug = str_replace(" ", "-", strtolower($titulo));
}
$query = mysql_query("INSERT INTO zn_posts (titulo,slug,categoria,data,texto,ativo) VALUES ('$titulo','$slug','$cat','$data','$texto','$ativo')");
if($query){
	echo "true";
}else{
	echo "Verifique corretamente os campos!";
}
?>
