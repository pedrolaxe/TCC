<?php
include '../includes/config.php';
global $mysqli;

$query = $_GET['query'];
$sql = "SELECT codpat,nome FROM zn_equipamentos WHERE codpat,nome LIKE '%".$query."%' LIMIT 10"; 

	$result = $mysqli->query($sql);

    $json = [];
    
	
    while(($linha = $result->fetch_assoc()) !== null){
	     $json[] = $linha['codpat'];
	}

    echo json_encode($json);
    
    ?>