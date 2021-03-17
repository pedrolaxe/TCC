<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

    $codigoequip = $_POST['codigoequip'];

        $sql = "SELECT * FROM zn_equipamentos WHERE codpat = '$codigoequip' LIMIT 1"; 


        $result = $mysqli->query($sql);
        if($result->num_rows > 0){
            //Status_equip
            while(($linha = $result->fetch_assoc()) !== null){
                echo '<strong>Cod: </strong>SU'.$linha['codpat'].'<br>'; // Nomemarca_byid($linha['marca']). ' - Status: '.Status_equip($linha['status']);
                echo '<strong>Nome: </strong>'.$linha['nome'] . '<br>';
                echo '<strong>Marca: </strong>'.Nomemarca_byid($linha['marca']). '<br>';
                echo '<strong>Status: </strong>'.Status_equip($linha['status']). '<br>';
            }   
    }else{
        echo "Nada Encontrado.";
    }
    
    ?>