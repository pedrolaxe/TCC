<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";

$id = anti_injection(mysql_real_escape_string($_POST['iduser']));
$titulo = $_POST['titulo'];
$slug 	= remover_caracter($_POST['slug']);
$data	= date('d/m/Y H:i');
$textopost	= $_POST['textopost'];
$cat	= $_POST['zn_categories'];

if(!empty($id)){

$query = mysql_query("UPDATE zn_posts SET titulo='$titulo', slug='$slug', categoria='$cat', data='$data', texto='$textopost' WHERE id='$id'");

if($query){
	echo "true";
}else{
	echo "Verifique os campos!";
}
}else{
	echo "ID Vazio";
}
?>
