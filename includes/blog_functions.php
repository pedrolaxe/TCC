<?php
/*
*
*   Blog Functions SPACEADMIN
*   @pedrolaxe
*
*/
function Idccat_byslug($slug){
	global $mysqli;
	$sql = $mysqli->query("SELECT id FROM zn_categories WHERE slug='$slug'");
	while($exibe = $sql->fetch_assoc()){
		return $exibe['id'];
	}
}
/*
*
* Name: GetPosts
* Params: $cat => Slug da categoria, $numposts => Quantidade de Posts, $order => ASC ou DESC
* Author: @pedrolaxe
* Version: 1.0
* Date: 18-08-2017
*/
function GetPosts($cat, $numposts, $order){
		global $mysqli;
    $idcat = Idccat_byslug($cat);
    $query = $mysqli->query("SELECT * FROM zn_posts WHERE categoria='$idcat' AND WHERE ativo='1' ORDER BY data '.$order.' LIMIT '.$numposts.'");

  while($list = $query->fetch_assoc()){
    echo '<div class="blog-post">';
      echo '<h2 class="blog-post-title">'.$list['titulo'].'</h2>\n';
      echo '<p class="blog-post-meta">'.$list['data'].' por <a href="#">Admin</a></p>\n';
      echo '<br>';
      echo '<p>'.$list['texto'].'</p>';
    echo '</div>';
  }
}


?>
