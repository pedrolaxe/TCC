<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

	date_default_timezone_set('America/Sao_Paulo');

	$marca = mysqli_real_escape_string($mysqli, $_POST['marca']);
	$slug = mysqli_real_escape_string($mysqli, $_POST['slug']);
	$data = date('d/m/Y');
    $hora = date('H:i:s');
    
    if(empty($slug)){
        $slug = Remove_acento(trim(strtolower($marca)));
    }

	$q = $mysqli->query("SELECT slug FROM zn_marcas WHERE slug='$slug'");
	$numerocat = $q->num_rows;
	if($numerocat==0){
	if(!empty($marca)){
	$sql = $mysqli->query("INSERT INTO zn_marcas (marca,slug,data,hora) VALUES ('$marca','$slug','$data','$hora')");
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
