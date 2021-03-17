<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
global $mysqli;

$idusuario = mysqli_real_escape_string($mysqli, $_POST['get_option']);
if(isset($idusuario)){

$select_cq = $mysqli->query("SELECT * FROM zn_contracheques WHERE id_user='$idusuario' ");

	while($lista = $select_cq->fetch_assoc() ){

echo '<tr>';
	echo '<td class="center">'.NomeById($lista['id_user']).'</td>';
	echo '<td class="center"><img src="'.URLSITE."/".Icontype($lista['tipo']).'" alt="tipo arquivo"></td>';
	echo '<td class="center"><a href="'.URLSITE.'/'.$lista['caminho'].'" target="_blank">'.$lista['nome'].'</a></td>';
	echo '<td class="center">'.$lista['data'].'</td>';
	echo '<td class="center">'.is_ativo_cq($lista['status']).'</td>';
	echo '<td>';
	echo '<a class="btn btn-small btn-danger" href="ajax/rm_cq?id='.base64_encode($lista['id']).'&ucq='.base64_encode($lista['id_user']).'"><i class="halflings-icon trash white"></i> Apagar</a>';
echo '</td></tr>';
 }
} ?>
