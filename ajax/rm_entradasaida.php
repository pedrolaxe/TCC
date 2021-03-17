<?php
include '../includes/config.php';
global $mysqli;

$id = anti_injection(base64_decode(mysqli_real_escape_string($mysqli, $_GET['id'])));
if(empty($id)){
	header("Location: ../plugin-entradasaida");
}else{
	if(is_numeric($id)){

	$query = $mysqli->query("DELETE FROM zn_entradasaida WHERE id='$id'");
		if($query){
			header("Location: ../plugin-entradasaida");
		}else{
			echo "<script>alert('Erro ao Apagar!')</script>";
			header("Location: ../plugin-entradasaida");
		}
	}
}//empty id
?>
