<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

	date_default_timezone_set('America/Sao_Paulo');

	$nome = mysqli_real_escape_string($mysqli, $_POST['nome_cat']);
	$slug = mysqli_real_escape_string($mysqli, $_POST['slug_cat']);
	$data = date('d/m/Y');
	$hora = date('H:i:s');

	if(empty($slug)){
        $slug = Remove_acento(trim(strtolower($nome)));
    }

	$q = $mysqli->query("SELECT slug FROM zn_categories WHERE slug='$slug'");
	$numerocat = $q->num_rows;
	if($numerocat==0){
	if(!empty($nome)){
	$sql = $mysqli->query("INSERT INTO zn_categories (nome,slug,data,hora) VALUES ('$nome','$slug','$data','$hora')");
	if($sql){
		echo "true";
	}else{
		echo "Falha ao criar!";
	}
	}else{
		echo "Preencha todos os campos!";
	}
	}//numerocat
	else{
		//echo "Categoria ja existente!";
	}
?>
