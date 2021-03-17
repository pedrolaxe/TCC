<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

date_default_timezone_set('America/Sao_Paulo');

	$idequip 		= base64_decode(anti_injection(mysqli_real_escape_string($mysqli, $_POST['idequip'])));
	$nome           = anti_injection(mysqli_real_escape_string($mysqli, $_POST['nome']));
	$cliente      	= mysqli_real_escape_string($mysqli, $_POST['zn_clients']);
	$valor         	= mysqli_real_escape_string($mysqli, $_POST['valor']);
	$obs            = mysqli_real_escape_string($mysqli, $_POST['obs']);
	
	$data = date('d/m/Y');
	$hora = date('H:i:s');


if(!empty($nome) && !empty($valor)){
	
	$edt_equi = $mysqli->query("UPDATE zn_equipamentos SET nome='$nome', cliente='$cliente', valor='$valor', obs='$obs', data='$data', hora='$hora' WHERE id='$idequip' ");
	if($edt_equi){
        //echo 'ok';
        echo '<script>window.location.href = "plugin-equipamentos";</script>';
		//header("Location: ../plugin-equipamentos");
	}else{
		echo 'Falha ao Cadastrar';
        echo '<script>window.location.href = "plugin-equipamentos";</script>';
	}

}else{
	echo 'Preencha os campos corretamente!';
}

?>
