<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

date_default_timezone_set('America/Sao_Paulo');

    $codpat     =  $_POST['codpat'];
    if(isset($codpat) && is_array($codpat)){
        $todoscodigos = implode(",", $codpat);
    }

	$entradasaida  = anti_injection(mysqli_real_escape_string($mysqli, $_POST['data']));
	$status        = mysqli_real_escape_string($mysqli, $_POST['zn_status']);
	$projeto        = mysqli_real_escape_string($mysqli, $_POST['projeto']);
    
    $data_entrada = substr($entradasaida, 0, 10);
    $data_saida = substr($entradasaida, 13, 23);

	$usuario = $_SESSION['usuario_admin'];	
	$data = date('d/m/Y');
	$hora = date('H:i:s');

if(VerifyisProject($codpat)==false){
if(!empty($codpat) and !empty($entradasaida)){
	
	$cad_entrada = $mysqli->query("INSERT INTO zn_entradasaida (codpat,dt_ent,dt_sai,projeto,status,usuario,data,hora) VALUES ('$todoscodigos','$data_saida','$data_entrada','$projeto','$status','$usuario','$data','$hora')");
	
	if(@strpos($codpat, ',') !== false) {
		SetStatusLista($todoscodigos, $status);
	} else {
		SetStatus($codpat, $status);
	}

	if($cad_entrada){
		//echo 'ok';
		echo '<script>window.location.href = "plugin-entradasaida";</script>';
	}else{
		echo 'Falha ao Cadastrar';
		echo '<script>window.location.href = "plugin-entradasaida";</script>';
	}

}else{
	echo 'Preencha os campos corretamente!';
}
}elseif(VerifyisProject($codpat)==false){
	echo 'Existem Produtos que n&atilde;o est&atilde;o na Empresa!';
}

?>
