
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

    $identsai  = anti_injection(mysqli_real_escape_string($mysqli, $_POST['identsai']));

	$entradasaida  = anti_injection(mysqli_real_escape_string($mysqli, $_POST['data']));
	$status        = mysqli_real_escape_string($mysqli, $_POST['zn_status']);
	$projeto        = mysqli_real_escape_string($mysqli, $_POST['projeto']);
    
    $data_entrada = substr($entradasaida, 0, 10);
    $data_saida = substr($entradasaida, 13, 23);

	$data = date('d/m/Y');
	$hora = date('H:i:s');

if(!empty($codpat) and !empty($entradasaida)){
	
	$cad_entrada = $mysqli->query("UPDATE zn_entradasaida SET codpat='$todoscodigos', dt_ent='$data_saida', dt_sai='$data_entrada', projeto='$projeto', status='$status', data='$data', hora='$hora' WHERE id='$identsai'");
	

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

?>
