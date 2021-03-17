<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

date_default_timezone_set('America/Sao_Paulo');

	$nome       = anti_injection(mysqli_real_escape_string($mysqli, $_POST['nome']));
	$cliente  = mysqli_real_escape_string($mysqli, $_POST['zn_clients']);
	$valor     = mysqli_real_escape_string($mysqli, $_POST['valor']);
	$obs = mysqli_real_escape_string($mysqli, $_POST['obs']);
	
	$data = date('d/m/Y');
	$hora = date('H:i:s');


if(!empty($nome) && !empty($valor)){
	
	$cad_equi = $mysqli->query("INSERT INTO zn_equipamentos (nome,cliente,valor,obs,data,hora) VALUES ('$nome','$cliente','$valor','$obs','$data','$hora')");
	if($cad_equi){
		//echo 'ok';
		echo '<script>window.location.href = "plugin-equipamentos";</script>';
		//header("Location: ../plugin-equipamentos");
	}else{
		echo 'Falha ao Cadastrar';
		//header("Location: ../plugin-equipamentos");
		echo '<script>window.location.href = "plugin-equipamentos";</script>';
	}

}else{
	echo 'Preencha os campos corretamente!';
}


?>
