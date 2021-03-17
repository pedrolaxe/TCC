<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "../verifica.php";

global $mysqli;

$nome_site = anti_injection(mysqli_real_escape_string($mysqli, $_POST['nome_site']));
$desc_site = anti_injection(mysqli_real_escape_string($mysqli, $_POST['desc_site']));
$apikey    = anti_injection(mysqli_real_escape_string($mysqli, $_POST['apikey']));

if(empty($apikey)){
	$retq = ", retcode='802'";
}else{
	$retq = '';
}
$switch    = $_POST['switch'];
if(isset($switch)){

	$query = $mysqli->query("UPDATE zn_options SET nome_site='$nome_site', desc_site='$desc_site', bemvindo='1', apikey='$apikey' $retq");
	if($query){
		header("Location: ../configuracoes");
	}else{
		echo "<script>alert('Erro! :(')</script>";
		header("Location: ../configuracoes");
	}
	}else{
		$query = $mysqli->query("UPDATE zn_options SET nome_site='$nome_site', desc_site='$desc_site', bemvindo='0', apikey='$apikey' $retq");
		if($query){
			header("Location: ../configuracoes");
		}else{
			echo "<script>alert('Erro! :(')</script>";
			header("Location: ../configuracoes");
		}

	}
?>
