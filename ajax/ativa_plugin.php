<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
date_default_timezone_set('America/Sao_Paulo');

$id_plugin = anti_injection(mysqli_real_escape_string($mysqli, $_POST['zn_plugins']));

if(!empty($id_plugin)){

	$sqls = $mysqli->query("UPDATE zn_plugins SET ativo='1' WHERE id='$id_plugin'");
	if($sqls){
		header("Location: ../instalar-plugins");
	}
}else{
		header("Location: ../instalar-plugins");
}
?>
