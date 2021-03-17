<?php
include '../includes/config.php';
global $mysqli;

$id = anti_injection(base64_decode(mysqli_real_escape_string($mysqli, $_GET['id'])));
if(empty($id)){
	header("Location: ../todos-usuarios");
}else{
if(is_numeric($id)){

	if(ID_userisadmin($id)==false){
		$query = $mysqli->query("DELETE FROM zn_users WHERE id='$id'");
			if($query){
				header("Location: ../todos-usuarios");
			}else{
				echo "<script>alert('Erro ao Apagar!')</script>";
				header("Location: ../todos-usuarios");
			}
	}else{
		echo 'Admins not removed';
	}
}
}//empty id
?>﻿
