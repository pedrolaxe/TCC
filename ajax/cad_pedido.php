<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

date_default_timezone_set('America/Sao_Paulo');

	
	$zn_clients         = mysqli_real_escape_string($mysqli, $_POST['zn_clients']);
    $numboleta          = mysqli_real_escape_string($mysqli, $_POST['numboleta']);
    $datapedido         = mysqli_real_escape_string($mysqli, $_POST['datapedido']);
    $save_cart          = mysqli_real_escape_string($mysqli, $_POST['save_cart']);
	$observacao         = mysqli_real_escape_string($mysqli, $_POST['observacao']);
	
	$data = date('d/m/Y');
	$hora = date('H:i:s');

if(!empty($numboleta)){
	
	$cad_pedido = $mysqli->query("INSERT INTO zn_pedidos (codcliente,numboleta,datapedido,save_cart,observacao,data,hora) VALUES ('$zn_clients','$numboleta','$datapedido','$save_cart','$observacao','$data','$hora')");
	if($cad_pedido){
		//echo 'ok';
		echo '<script>window.location.href = "plugin-pedidos";</script>';
		//header("Location: ../plugin-equipamentos");
	}else{
		echo 'Falha ao Cadastrar';
		//header("Location: ../plugin-equipamentos");
		echo '<script>window.location.href = "plugin-pedidos";</script>';
	}

}else{
	echo 'Preencha os campos corretamente!';
}


?>