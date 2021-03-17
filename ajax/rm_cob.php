<?php
include '../includes/config.php';
global $mysqli;

$id = anti_injection(base64_decode(mysqli_real_escape_string($mysqli, $_GET['id'])));
if(empty($id)){
	header("Location: ../plugin-cobrancas");
}else{
	if(is_numeric($id)){

	$query = $mysqli->query("DELETE FROM zn_cobrancas WHERE id='$id'");
		if($query){
			header("Location: ../plugin-cobrancas");
		}else{
			echo "<script>alert('Erro ao Apagar!')</script>";
			header("Location: ../plugin-cobrancas");
		}
	}
}//empty id
?>
