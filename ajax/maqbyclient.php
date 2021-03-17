<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";
$idusuario = mysql_real_escape_string($_POST['get_option']);
if(isset($idusuario)){

    $query = mysql_query("SELECT * FROM zn_relatoriopcs WHERE id_cliente='$idusuario' ORDER BY data DESC");
    while($linha = mysql_fetch_array($query)){

  echo '<tr>';
      echo '<td><i class="'. LoadOSicon($linha['sispc']).'"></i></td>';
      echo '<td>'.$linha['nomepc'].'</td>';
      echo '<td>'.$linha['usuariopc'].'</td>';
      echo '<td>'.$linha['localpc'].'</td>';
      echo '<td>'.Nome_cliente($linha['id_cliente']).'</td>';
      echo '<td class="text-center"><a href="'.URLSITE."/".$linha['link_relat'].'" target="_blank" style="color:#333;"><i class="icon-download"></i></a></td>';
      echo '<td class="text-center">
        <ul class="icons-list">
        <li class="dropdown dropup">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="'.URLSITE.'/ajax/rm_rl?id='.base64_encode($linha['id']).'"><i class="icon-trash text-danger"></i>Remover</a></li>

          </ul>
        </li>
      </ul>
    </td>';

  echo '</tr>';
  }

}
?>
