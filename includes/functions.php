<?php
function anti_injection($sql){
	// remove palavras que contenham sintaxe sql
	$sql = trim($sql);//limpa espacos vazio
	$sql = strip_tags($sql);//tira tags html e php
	$sql = addslashes($sql);//Adiciona barras invertidas a uma string
	$sql = quotemeta($sql);//coloca / se tiver cifrao
	return $sql;
 }
function Encriptar($senha){
	// o salt vai ser um md5 :)
	$salt = sha1("zion@cms#103");
	$salt2 = sha1("pedro@2016#zioncms");
	$saltao = crypt($salt,$salt2);
	// depois ele passa por uma SHA1
	$criador = sha1($senha.$saltao);

	//agora retorna senha encriptada kkk
	return $criador;
}
function Nome_inteiro(){
	global $mysqli;
	$username = $_SESSION['usuario_admin'];
	$query = $mysqli->query("SELECT nome_inteiro FROM zn_users WHERE usuario='$username'");
	$nome = $query->fetch_assoc();
	return $nome['nome_inteiro'];
}
function Email_username($username){
	global $mysqli;
		if(!empty($username)){
			$query = $mysqli->query("SELECT email FROM zn_users WHERE usuario='$username'");
			$nome = $query->fetch_assoc();
				return $nome['email'];
		}
}
function EmailById($id){
	global $mysqli;
	if(!empty($id)){
		$query = $mysqli->query("SELECT email FROM zn_users WHERE id='$id'");
		$nome = $query->fetch_assoc();
    		return $nome['email'];
    	}
}
function UsernameById($id){
	global $mysqli;
	$query = $mysqli->query("SELECT id,usuario FROM zn_users WHERE id='$id'");
	$list = $query->fetch_assoc();
		return $list['usuario'];
}
function IdByUsername($username){
	global $mysqli;
	$query = $mysqli->query("SELECT id,usuario FROM zn_users WHERE usuario='$username'");
	$list = $query->fetch_assoc();
		return $list['id'];
}
function NomeById($id){
	global $mysqli;
	$query = $mysqli->query("SELECT id,nome_inteiro FROM zn_users WHERE id='$id'");
	$list = $query->fetch_assoc();
		return $list['nome_inteiro'];
}
function NomeByUser($id){
	global $mysqli;
	$query = $mysqli->query("SELECT nome_inteiro FROM zn_users WHERE usuario='$id'");
	$list = $query->fetch_assoc();
		return $list['nome_inteiro'];
}
/*
*	Function is_vazio
*	Args: $var
*	Verifica se Ta vazio, se tiver ai informa fala que nao tem nada... :(
*/
function is_vazio($var){
	if(empty($var)){
		echo "N&atilde;o Informado";
	}else{
		echo $var;
	}
}
/*
*	Function is_ativo
*	Args: $var
*	Verifica se var esta ativo ou inativo
*/
function is_ativo($var, $id){
	if($var==1){
		echo '<span class="label label-success">Ativo</span>';
	}elseif($var==0){
		echo '<a href="ajax/ativa_post?id='.base64_encode($id).'"><span class="label label-danger">Inativo</span></a>';
	}
}
function tema_ativo($var){
	if($var==1){
		echo "Ativado";
	}elseif($var==0){
		echo "Desativado";
	}
}
function opacidade_tema($var){
	if($var==0){
		echo 'style="opacity:0.5"';
	}
}
/*
*	Function is_desativado
*	Args: $id
*	Verifica se var esta desativado
*/
function is_desativado($id){
	global $mysqli;
	$query = $mysqli->query("SELECT ativo FROM zn_posts WHERE id='$id'");
	$linha = $query->fetch_assoc();
		if($linha['ativo']==0){
			return true;
		}elseif($linha['ativo']==1){
			return false;
		}
}
/*
*	Function is_ativado
*	Args: $id
*	Verifica se var esta desativado
*/
function post_ativado($id){
	global $mysqli;
	$query = $mysqli->query("SELECT ativo FROM zn_posts WHERE id!='$id'");
	$conta = $query->num_rows;
		if($conta<=4){
			return true;
		}elseif($conta==0){
			return false;
		}
}
/*
*	Function post_desativado
*/
function Post_desativado(){
	global $mysqli;
	$query = $mysqli->query("SELECT ativo FROM zn_posts");
	$numero = $query->num_rows;
		if($numero==0){
			return true;
		}elseif($numero>0){
			return false;
		}
}
/*
*	Function GetID_bySlug
*	Args: $slug
*	Retorna o ID do post, a partir do slug.
*/
function GetID_bySlug($slug){
	global $mysqli;
	$query = $mysqli->query("SELECT id FROM zn_posts WHERE slug='$slug'");
	$b = $query->fetch_assoc();
		return $b['id'];
}
/*
*	Function limitaTexto
*	Args: $texto, $limite = 200, $slug
*	Limita o conteudo de um textop e coloca o link do slug
*/
function limitarTexto($texto, $limite, $slug){
$texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' '));
	echo $texto;
}
function limitarTexto_noslug($texto, $limite){
$texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' '));
	return $texto;
}
/*
*	Function Remove_acento
*	Args: $string
*	Remove acentuaÃ§Ã£o de uma $string
*/
function Remove_acento($string) {
    $remove = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string ) );
    return $remove;
}
/*
*	Function ListaPostNum
*	Args: $quantidade
*	Lista a quantidade de Posts de acordo com a quantidade
*/
function ListaPostNum($quantidade){
	global $mysqli;
	$query = $mysqli->query("SELECT * FROM zn_posts WHERE ativo='1' ORDER BY id DESC LIMIT '$quantidade'");
	while($linha = $query->fetch_assoc()){
		echo '<a href="'.$linha['slug'].'""><h1>'.$linha['titulo'].'</h1></a>';
		echo '<p class="lead" id="txtcenter">'.limitarTexto($linha['texto'], 200, $linha['slug']).'</p>';
	}
	exit;
}
/*
*	Function Get_imagemdestacada
*	Args: $id
*	Retorna Imagem destacada do Post
*/
function Get_imagemdestacada($id){
	global $mysqli;
	$query = $mysqli->query("SELECT imgdst FROM zn_posts WHERE id='$id'");
	$j = $query->fetch_assoc();
		echo '<img src="'.$j['imgdst'].'" id="imagem-destacada" width="200" height="250">';
}
/*
*	Function is_imgdst
*	Args: $id
*	Retorna badge se existe ou nÃ£o imagem destacada
*/
function is_imgdst($id){
	global $mysqli;
	$query = $mysqli->query("SELECT imgdst FROM zn_posts WHERE id='$id'");
	$num = $query->fetch_assoc();
		if($num['imgdst']!=""){
			echo '<span class="label label-success">SIM</span>';
		}elseif($num['imgdst']==""){
			echo '<span class="label label-important">N&Atilde;O</span>';
		}
}
/*
*	Function Existe_post
*	Args: $id
*	Verifica se existe posts com o $id
*/
function Existe_post($id){
	global $mysqli;
	$q = $mysqli->query("SELECT id FROM zn_posts WHERE id='$id'");
	$c = $q->num_rows;
	if($c==1){
		return true;
	}elseif($c==0){
		return false;
	}
}
/*
*	Function get_header
*	Args: $
*	Chama o header.php do tema ativo
*/
function get_header(){
	global $mysqli;
	$query = $mysqli->query("SELECT pasta FROM zn_themes WHERE ativo='1'");
	while($linha = $query->fetch_assoc()){
		$url = 'nfadm/temas/'.$linha['pasta'].'/';
	}
		return include $url.'header.php';
}
/*
*	Function get_footer
*	Args: $
*	Chama o footer.php do tema ativo
*/
function get_footer(){
	global $mysqli;
	$query = $mysqli->query("SELECT pasta FROM zn_themes WHERE ativo='1'");
	while($linha = $query->fetch_assoc()){
		$url = 'nfadm/temas/'.$linha['pasta'].'/';
	}
		return include $url.'footer.php';
}
/*
*	Function get_sidebar
*	Args: $
*	Chama o sidebar.php do tema ativo
*/
function get_sidebar(){
	global $mysqli;
	$query = $mysqli->query("SELECT pasta FROM zn_themes WHERE ativo='1'");
	while($linha = $query->fetch_assoc()){
		$url = 'nfadm/temas/'.$linha['pasta'].'/';
	}
		return include $url.'sidebar.php';
}
/*
*	Function get_url_theme
*	Args: $
*/
function get_url_theme(){
	global $mysqli;
	$query = $mysqli->query("SELECT pasta FROM zn_themes WHERE ativo='1'");
	while($linha = $query->fetch_assoc()){
		$url = 'nfadm/temas/'.$linha['pasta'].'/';
	}
		echo $url;
}
/*
*	Function Site_title()
*	Args: $
*	Mostra o Nome do site
*/
function Site_title(){
	global $mysqli;
	$query = $mysqli->query("SELECT nome_site,url_logo FROM zn_options");
	while($linha = $query->fetch_assoc()){
		echo $linha['nome_site'];
	}
}
function Site_logomarca(){
	global $mysqli;
	$query = $mysqli->query("SELECT nome_site,url_logo FROM zn_options");
	while($linha = $query->fetch_assoc()){
		if($linha['url_logo']==""){
			echo $linha['nome_site'];
		}else{
			echo '<img src="'.$linha['url_logo'].'" alt="logomarca">';
		}
	}
}
function Site_description(){
	global $mysqli;
	$query = $mysqli->query("SELECT desc_site FROM zn_options");
	while($linha = $query->fetch_assoc()){
		echo $linha['desc_site'];
	}
}
function Site_link(){
	echo "http://localhost/suadmin";
}
/**
* Function Num_themes
*
* Retorna numero de temas instalados
*/
function Num_themes(){
	global $mysqli;
	$q = $mysqli->query("SELECT id FROM zn_themes");
	$num = $q->num_rows;
		echo $num;
}
/**
* Function Selects
*
* Retorna select com as categorias existentes
*/
function Select_categories(){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_categories ORDER BY nome ASC");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<select name="zn_categories" id="zn_categories" class="form-control" style="width:180px;">';
		echo '<option value=""> Selecione a Categoria </option>';
	while($cat = $q->fetch_assoc()){
		echo '<option value="'.$cat['id'].'">'.$cat['nome'].'</option>';
	}//while
		echo '</select>';
	}else{
		echo 'Nenhuma Categoria a Exibir.';
	}
}
function Select_marca(){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_marcas ORDER BY marca ASC");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<select name="zn_marcas" id="zn_marcas" class="form-control" style="width:180px;">';
		echo '<option value=""> Selecione a Marca </option>';
	while($cat = $q->fetch_assoc()){
		echo '<option value="'.$cat['id'].'">'.$cat['marca'].'</option>';
	}//while
		echo '</select>';
	}else{
		echo 'Nenhuma Marca a Exibir.';
	}
}
function Select_editmarca($idmarca){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_marcas ORDER BY marca ASC");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<select name="zn_marcas" id="zn_marcas" class="bootstrap-select" data-live-search="true" style="width:180px;">';
		echo '<option value=""> Selecione a Marca </option>';
	while($cat = $q->fetch_assoc()){
		//if($idmarca==$cat['id']){return 'selected="true"'}
		echo '<option value="'.$cat["id"].'" '.(($cat["id"]==$idmarca)?'selected="selected"':"").'> '.$cat["marca"].'</option>';

	}//while
		echo '</select>';
	}else{
		echo 'Nenhuma Marca a Exibir.';
	}
}
function Select_editcat($idcat){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_categories ORDER BY id ASC");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<select name="zn_categories" id="zn_categories" class="form-control" style="width:180px;">';
		echo '<option value=""> Selecione a Marca </option>';
	while($cat = $q->fetch_assoc()){
		//if($idmarca==$cat['id']){return 'selected="true"'}
		echo '<option value="'.$cat["id"].'" '.(($cat["id"]==$idcat)?'selected="selected"':"").'> '.$cat["nome"].'</option>';
	}//while
		echo '</select>';
	}else{
		echo 'Nenhuma Categoria a Exibir.';
	}
}
function Select_editclientes($idcli){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_clients ORDER BY id ASC");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<select name="zn_clients" id="zn_clients" class="bootstrap-select" data-live-search="true" style="width:180px;">';
		echo '<option value=""> Selecione o Cliente </option>';
	while($cat = $q->fetch_assoc()){
		//if($idmarca==$cat['id']){return 'selected="true"'}
		echo '<option value="'.$cat["id"].'" '.(($cat["id"]==$idcli)?'selected="selected"':"").'> '.$cat["nome_fan"].'</option>';
	}//while
		echo '</select>';
	}else{
		echo 'Nenhum Cliente a Exibir.';
	}
}
function Select_clients(){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_clients");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<select name="zn_clients" id="zn_clients" class="bootstrap-select" data-live-search="true" style="width:180px;">';
		echo '<option value=""> Selecione o Cliente </option>';
	while($cat = $q->fetch_assoc()){
		echo '<option value="'.$cat['id'].'">'.$cat['nome_fan'].'</option>\n';
	}//while
		echo '</select>';
	}else{
		echo 'Nenhum Cliente Cadastrado.';
	}
}
function Select_dateexport($idcli){
	global $mysqli;
	$q = $mysqli->query("SELECT datapedido,codcliente FROM zn_pedidos WHERE codcliente='$idcli'");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<select name="zn_dataexp" id="zn_dataexp" class="bootstrap-select" style="width:180px;">';
		echo '<option value=""> Selecione o Mês </option>';
	while($cat = $q->fetch_assoc()){

		$datapedido = $cat['datapedido'];
		
		$dta_dia = substr($datapedido, 0, 2);
		$dta_mes = substr($datapedido, 3, 2);
		$dta_ano = substr($datapedido, 6, 4);

			if($dta_mes == '01'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Janeiro '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '02'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Fevereiro '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '03'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Março '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '04'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Abril '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '05'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Maio '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '06'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Junho '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '07'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Julho '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '08'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Agosto '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '09'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Setembro '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '10'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Outubro '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '11'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Novembro '.$dta_ano.'</option>\n';
			}elseif($dta_mes == '12'){
				echo '<option value="'.$dta_mes.'" data-ano="'.$dta_ano.'" data-cliente="'.$idcli.'">Dezembro '.$dta_ano.'</option>\n';
			}	

	}//while
		echo '</select>';
	}else{
		echo 'Nenhum Pedido Cadastrado.';
	}
}
function Select_equip(){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_equipamentos");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<select name="zn_equip" id="zn_equip" class="bootstrap-select" data-live-search="true" style="width:180px;">';
		echo '<option value=""> Selecionar Serviço </option>';
	while($cat = $q->fetch_assoc()){
		echo '<option value="'.$cat['id'].'">'.$cat['nome'].'</option>\n';
	}//while
		echo '</select>';
	}else{
		echo 'Nenhum Produtos Cadastrado.';
	}
}
function Select_Status(){
		echo '<select name="zn_status" id="zn_status" class="form-control" style="width:180px;">';
			echo '<option value=""> Selecione </option>';
			echo '<option value="1">Entrada</option>';
			echo '<option value="2">Saída</option>';
			echo '<option value="3">Empresa</option>';
			echo '<option value="4">Atrasado</option>';
		echo '</select>';
}
function Select_EditStatus($id, $status){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_status");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<select name="zn_status" id="zn_status" class="form-control" style="width:180px;">';
		echo '<option value=""> Selecione </option>';
	while($cat = $q->fetch_assoc()){
		echo '<option value="'.$cat["id"].'" '.(($cat["id"]==$status)?'selected="selected"':"").'> '.$cat["nome"].'</option>';
	}//while
		echo '</select>';
	}else{
		echo 'Nenhum Status a Exibir.';
	}
}

function List_categories(){
	global $mysqli;
	$q = $mysqli->query("SELECT nome,slug FROM zn_categories");
	$num_cat = $q->num_rows;
	if($num_cat>0){
		echo '<ul class="links-list-alt">';
	while($cat = $q->fetch_assoc()){
		echo '<li><a href="'.URLSITE.'/cat?p='.$cat['slug'].'">'.$cat['nome'].'</a></li>';
	}//while
		echo '</ul>';
	}else{
		echo 'Nenhuma Categoria a Exibir.';
	}

}

function Nome_cliente($id){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_clients WHERE id='$id'");
	while($lista = $q->fetch_assoc()){
		return $lista['nome_fan'];
	}
}
function Nome_cat($id){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_categories WHERE id='$id'");
	while($lista = $q->fetch_assoc()){
		return $lista['nome'];
	}
}
function Nome_marca($id){
	global $mysqli;
	$q = $mysqli->query("SELECT * FROM zn_marcas WHERE id='$id'");
	while($lista = $q->fetch_assoc()){
		return $lista['marca'];
	}
}
function Status_cobranca($status){
	if($status==1){
		echo '<span class="label label-success">Pago</span>';
	}elseif($status==0){
		echo '<span class="label label-default">Em Aberto</span>';
	}elseif($status==3){
		echo '<span class="label label-danger">Atrasado</span>';
	}
}
function Status_equip($status){
	if($status==1){
		return '<span class="label label-primary">Entrada</span>';
	}elseif($status==2){
		return '<span class="label label-danger">Saída</span>';
	}elseif($status==3){
		return '<span class="label label-info">Empresa</span>';
	}elseif($status==4){
		return '<span class="label label-warning">Atrasado</span>';
	}
}
function Numpost_pcat($slug){
	global $mysqli;
	$query = $mysqli->query("SELECT * FROM zn_posts WHERE categoria='$slug'");
	$numero = $query->num_rows;
		echo $numero;
}
function Numequip_marca($slug){
	global $mysqli;
	$query = $mysqli->query("SELECT * FROM zn_equipamentos WHERE marca='$slug'");
		echo $query->num_rows;
}
function Nomemarca_byid($id){
	global $mysqli;
	  $query = $mysqli->query("SELECT marca FROM zn_marcas WHERE id='$id'");
	while($exibe = $query->fetch_assoc()){
		  return $exibe['marca'];
	  }
  }
  function Nomeequip_byid($id){
	global $mysqli;
	  $query = $mysqli->query("SELECT nome FROM zn_equipamentos WHERE codpat='$id'");
	while($exibe = $query->fetch_assoc()){
		  return $exibe['nome'];
	  }
  }
function Nomecat_byslug($slug){
	global $mysqli;
	$sluglimpo = mysqli_real_escape_string($mysqli, $slug);
	$query = $mysqli->query("SELECT nome FROM zn_categories WHERE slug='$sluglimpo'");
	while($exibe = $query->fetch_assoc()){
		echo $exibe['nome'];
	}
}
function Nomecat_byid($id){
  global $mysqli;
	$query = $mysqli->query("SELECT nome FROM zn_categories WHERE id='$id'");
  while($exibe = $query->fetch_assoc()){
		echo $exibe['nome'];
	}
}

function List_ogmeta_post($id_post){
	global $mysqli;
	$query = $mysqli->query("SELECT * FROM zn_posts WHERE id='$id_post'");
	while($linha = $query->fetch_assoc()){
		echo '
		<meta property="og:title" content="'.$linha['titulo'].'"/>
		<meta property="og:image" content="http://niteroinofoco.com.br/'.$linha['imgdst'].'"/>
		';

	}
}
function remover_caracter($string){
    $string = preg_replace("/[Ã¡Ã Ã¢Ã£Ã¤]/", "a", $string);
    $string = preg_replace("/[ÃÃ€Ã‚ÃƒÃ„]/", "A", $string);
    $string = preg_replace("/[Ã©Ã¨Ãª]/", "e", $string);
    $string = preg_replace("/[Ã‰ÃˆÃŠ]/", "E", $string);
    $string = preg_replace("/[Ã­Ã¬]/", "i", $string);
    $string = preg_replace("/[ÃÃŒ]/", "I", $string);
    $string = preg_replace("/[Ã³Ã²Ã´ÃµÃ¶]/", "o", $string);
    $string = preg_replace("/[Ã“Ã’Ã”Ã•Ã–]/", "O", $string);
    $string = preg_replace("/[ÃºÃ¹Ã¼]/", "u", $string);
    $string = preg_replace("/[ÃšÃ™Ãœ]/", "U", $string);
    $string = preg_replace("/Ã§/", "c", $string);
    $string = preg_replace("/Ã‡/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
    $string = preg_replace("/ /", "-", $string);
    return $string;
}
/**
* Function Lista Temas
*
* Retorna listando os temas do site oficial do Zion CMS
*/
function List_zioncms_themes(){
	$arquivo = file_get_contents('http://zioncms.phpsec.com.br/temas/tema.json');
	$json = json_decode($arquivo, true);
	echo '<ul>';
	foreach($json['temas'] as $a){
		echo '<li>Nome: '.$a['temas']['nome']."</li>";
		echo '<li>Imagem: '.$a['temas']['imagem'].'</li>';
	}
	echo '</ul>';
}
function image_gravatar($email, $size){

  $email = trim($email);
  $email = strtolower($email);
  $email_hash = md5($email);

  $url = "http://www.gravatar.com/avatar/".$email_hash."/?s=".$size;
    return $url;
}
function Verify_roles($value, $id){
  if($value==0){
    echo '<a href="ajax/ativa_user?id='.base64_encode($id).'"><span class="label">Inativo</span></a>';
  }elseif($value==1){
    echo '<span class="label label-success">Ativo</span>';
  }elseif($value==3){
    echo '<span class="label label-warning">Pendente</span>';
  }
}
function is_ativo_cq($value){
  if($value==0){
    echo '<span class="label">Inativo</span>';
  }elseif($value==1){
    echo '<span class="label label-success">Ativo</span>';
  }elseif($value==3){
    echo '<span class="label label-warning">Pendente</span>';
  }
}
function plugins_folder(){
	$url = 'nfadm/plugins/';
	return $url;
}
function Del_btn_users($id_user){
	global $mysqli;
		$sel = $mysqli->query("SELECT * FROM zn_users WHERE id='$id_user'");
		$list = $sel->fetch_assoc();
		if($list['funcao']>1){
			echo ' <a href="ajax/rm_user?id='.base64_encode($id_user).'" class="btn btn-danger btn-sm">Remover</a>';
		}
}
function Send_recover($email,$codigo){
	//Set Infos
	$nmsender = "Webmaster";
	$emsender = "sis@phpsec.com.br";
	$rtsender = "sis@phpsec.com.br";
  
	$linksite = URLSITE;
	$mensagem = "Ol&aacute; <br>";
	$mensagem .= 'Clique <a href="'.$linksite.'/changepass?code='.$codigo.'">aqui</a> para mudar sua senha.<br>';
	$mensagem .= '<br><br>';
	$mensagem .= 'SPACEADMIN';
	$assunto = "Alterar Senha - SPACEADMIN";
  
	$headers =  "Content-Type:text/html; charset=UTF-8\n";
	$headers .= "From:  ".$nmsender." <".$emsender.">\n";
	$headers .= "X-Sender:  <".$emsender.">\n";
	$headers .= "X-Mailer: PHP  v".phpversion()."\n";
	$headers .= "X-IP:  ".$_SERVER['REMOTE_ADDR']."\n";
	$headers .= "Return-Path:  <".$rtsender.">\n";
	$headers .= "MIME-Version: 1.0\n";
		if($email !="" && $codigo !=""){
			mail($email, $assunto, $mensagem, $headers);
	  }
  }
function Expira_code($codigo){
	global $mysqli;
	if(!empty($codigo)){
		$sql = $mysqli->query("UPDATE zn_users SET codexp='1' WHERE codigo='$codigo'");
		if($sql){
			return true;
		}else{
			return false;
		}
	}
}
function Verify_code($codigo){
	global $mysqli;
	if(!empty($codigo)){
		$sqlcode = $mysqli->query("SELECT codexp FROM zn_users WHERE codigo='$codigo'");
		$lista = $sqlcode->fetch_assoc();
		if($lista['codexp']==1){
			return true;
		}else{
			return false;
		}
	}
}
function List_plugins_inativo(){
	global $mysqli;
	$sqlist = $mysqli->query("SELECT * FROM zn_plugins WHERE ativo='0'");
	$cont = $sqlist->num_rows;
	if($cont>0){
		echo '<select name="zn_plugins" class="bootstrap-select" style="width:180px;">';
		echo '<option value="">Selecione</option>';
	while($listar = $sqlist->fetch_assoc()){
		echo '<option value="'.$listar['id'].'">'.$listar['nome'].'</option>';
	}
		echo '</select>';
	}else{
		echo 'Nenhum plugin desativado!';
	}
}
function List_plugins_ativos(){
	global $mysqli;
	$sqlist = $mysqli->query("SELECT * FROM zn_plugins WHERE ativo='1'");
	$cont = $sqlist->num_rows;
	if($cont>0){
		echo '<select name="zn_plugins_ativo" class="bootstrap-select" style="width:180px;">';
		echo '<option value="">Selecione</option>';
	while($listar = $sqlist->fetch_assoc()){
		echo '<option value="'.$listar['id'].'">'.$listar['nome'].'</option>';
	}
		echo '</select>';
	}else{
		echo 'Nenhum plugin ativado!';
	}
}
function Existe_plugins_ativos(){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_plugins WHERE ativo='1'");
	$cont = $sql->num_rows;
	if($cont>0){
		return true;
	}else{
		return false;
	}
}
function Existe_plugins_inativos(){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_plugins WHERE ativo='0'");
	$cont = $sql->num_rows;
	if($cont>0){
		return true;
	}else{
		return false;
	}
}
function Menuif_plugin(){
	global $mysqli;
	$verify = $mysqli->query("SELECT * FROM zn_plugins WHERE ativo='1'");
	$contas = $verify->num_rows;
	if($contas >0){
		while($list = $verify->fetch_assoc()){
			echo '<li><a class="submenu" href="plugin-'.$list['slug'].'"><span class="hidden-tablet"> '.$list['nome'].'</span></a></li>';
		}
	}
}
function Menuif_pluginv2(){
global $mysqli;
	$verify = $mysqli->query("SELECT * FROM zn_plugins WHERE ativo='1'");
	$contas = $verify->num_rows;
	if($contas > 0){
		while($list = $verify->fetch_assoc()){
			echo '<li><a href="plugin-'.$list['slug'].'">'.$list['nome'].'</a></li>';
		}
	}
}
function Switch_onoff($option){
	if($option==1){
		return 'checked="checked"';
	}elseif($option==0){
		return;
	}
}
function Ver_panelbemvindo(){
	global $mysqli;
	$q = $mysqli->query("SELECT bemvindo FROM zn_options");
	while($lista = $q->fetch_assoc()){
		if($lista['bemvindo']==0){
			return false;
		}else{
			return true;
		}
	}
}
function Convert_role($role){
	if($role==1){
		return "Administrador";
	}elseif($role==2){
		return "T&eacute;cnico";
	}elseif($role==4){
		return "Funcion&aacute;rio";
	}
}
function ID_userisadmin($id){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_users WHERE id='$id'");
	while($listar = $sql->fetch_assoc()){
		if($listar['funcao']==1){
			return true;
		}else{
			return false;
		}
	}
}
function Proxima_cobranca($dia){
	$novadata = date($dia.'/m/Y', strtotime('+1 months', strtotime(date('Y-m-'.$dia))));
	return $novadata;
}
function Botao_conclui($id){
	global $mysqli;
	$seleciona = $mysqli->query("SELECT * FROM zn_cobrancas WHERE id='$id'");

	while($list = $seleciona->fetch_assoc()){
		if($list['id']==$id){
		if($list['status']==0){
			echo '<a class="btn btn-small btn-success" href="#?id='.base64_encode($list['id']).'">
										<i class="halflings-icon white ok"></i></a>';
		}
		}
	}
}
function Botao_atraso($id){
	global $mysqli;
	$seleciona = $mysqli->query("SELECT * FROM zn_cobrancas WHERE id='$id'");

	while($list = $seleciona->fetch_assoc()){
		if($list['id']==$id){
		if($list['status']==0 || $list['status']==1){
			echo '<a class="btn btn-small btn-warning" href="#?id='.base64_encode($list['id']).'">
										<i class="halflings-icon white calendar"></i></a>';
		}
		}
	}
}
function Logo_options($logo){
	if($logo!=""){
		return '<img src="'.$logo.'" alt="logomarca">';
	}
}
/*
*
* Dashboard Widgets
*/
function Clients_dbwid(){
	global $mysqli;
	$cliente = $mysqli->query("SELECT * FROM zn_clients");
	$numero = $cliente->num_rows;
	if($numero>0){
			echo '
			<div class="span3 statbox purple" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,4,2,4,8,2,3,3,2</div>
					<div class="number">'.$numero.'<i class="icon-arrow-up"></i></div>
					<div class="title">Clientes</div>
					<div class="footer">
						<a href="plugin-clientes#clicad"> Veja Mais</a>
					</div>
				</div>
			';
	}
}
function Cob_aberto_dbwid(){
	global $mysqli;
	$cobranca = $mysqli->query("SELECT * FROM zn_cobrancas WHERE status='0'");
	$numero = $cobranca->num_rows;
	if($numero>0){
			echo '
			<div class="span3 statbox yellow" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,4,2,4,8,2,3,3,2</div>
					<div class="number">'.$numero.'<i class="icon-arrow-up"></i></div>
					<div class="title">CobranÃ§as em Aberto</div>
					<div class="footer">
						<a href="plugin-cobrancas#clicad"> Veja Mais</a>
					</div>
				</div>
			';
	}
}
function Cob_atraso_dbwid(){
	global $mysqli;
	$cobranca = $mysqli->query("SELECT * FROM zn_cobrancas WHERE status='3'");
	$numero = $cobranca->num_rows;
	if($numero>0){
			echo '
			<div class="span3 statbox red" onTablet="span6" onDesktop="span3">
					<div class="boxchart">5,6,7,2,0,4,2,4,8,2,3,3,2</div>
					<div class="number">'.$numero.'<i class="icon-arrow-up"></i></div>
					<div class="title">CobranÃ§as em Atraso</div>
					<div class="footer">
						<a href="plugin-cobrancas#clicad"> Veja Mais</a>
					</div>
				</div>
			';
	}
}
function Ndias_cob_dbwid(){
	global $mysqli;
	$cob = $mysqli->query("SELECT * FROM zn_cobrancas WHERE status='0'");
	$numero = $cob->num_rows;
	if($numero>0){

			echo '
		<div class="box black span4 noMargin" onTablet="span12" onDesktop="span4">
			<div class="box-header">
				<h2><i class="halflings-icon white check"></i><span class="break"></span>Lembretes</h2>
			</div>
			<div class="box-content">
				<div class="todo metro">
					<ul class="todo-list">
	';
					while($listar = $cob->fetch_assoc()){
							echo'	<li class="blue">
										<a class="action icon-check-empty" href="#"></a>
											Faltam '.Faltam_n_dias(Proxima_cobranca($listar['data_pref'])).' dias para o(a) '.Nome_cliente($listar['id_cliente']).' pagar!
										<strong>'.Proxima_cobranca($listar['data_pref']).'</strong>
									</li>';
}
		echo '
				</ul>
			</div>
		</div>
	</div>';
		}
	}
  
  /*
  "Faltam ".Faltam_n_dias(Proxima_cobranca($linha['data_pref']))." dias"
  * CobranÃ§as
  * Data:16/06/2016
  * Pedro Laxe
  */
  function dateDiff($date1, $date2){
	 return ($date1 > $date2) ? floor(($date1 - $date2) / 86400)
							  : floor(($date2 - $date1) / 86400);
  }
  function formata_datacob($data) {
	  // o array $partes Ã© um dos parÃ¢metros de preg_match(), e retorna os padrÃµes encontrados na string.
	  if (preg_match("/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/", $data, $partes)) {
	  $data_formatada = $partes[3]."-".$partes[2]."-".$partes[1];
	  return $data_formatada;
	  }
  }
  function Faltam_n_dias($datapag){
	  $hoje = time();
	  $pagamento = strtotime(formata_datacob($datapag));
  
	  return dateDiff($hoje,$pagamento);
  
  }
  /*
  Name: Retfunc
  Args: user
  Return: numero da funÃ§ao administrativa
  */
  function Retfunc($username){
	  global $mysqli;
	  if(!empty($username)){
		  $q = $mysqli->query("SELECT funcao FROM zn_users WHERE usuario='$username'");
		  //$list = $query->fetch_assoc();
		  $list = $q->fetch_assoc();
			  return $list['funcao'];
	  }
  }
function Selectofunc($id){
	if(is_numeric($id)){
		if($id==1){
			echo '
			<select name="zn_roles" id="zn_roles" class="bootstrap-select" style="width:180px;">
				<option value="">Selecione</option>
				<option value="1">Administrador</option>
				<option value="2">T&eacute;cnico</option>
				<option value="4">Funcion&aacute;rio</option>
			</select>
			';
		}elseif($id==2){
			echo '
			<select name="zn_roles" id="zn_roles" class="form-control" style="width:180px;">
				<option value="">Selecione</option>
				<option value="4">Funcion&aacute;rio</option>
			</select>
			';
		}
	}
}
function RedirUser($id_adm){
	if(!empty($id_adm)){
		//if($id_adm==1)
	}
}
function Liberabyid($id){
	if($id==1){
		return 'adm';
	}elseif($id==2){
		return 'tec';
	}elseif($id==4){
		return 'fun';
	}
}
function admin_page($idadm){
	if($idadm!=1){
		header("Location: ".URLSITE."/index");
	}
}
function tec_page($idadm){
	if($idadm==4){
		header("Location: ".URLSITE."/acesso-cq");
	}
}
function SelectFuncionariosName(){
	global $mysqli;
	$select = $mysqli->query("SELECT id,usuario,nome_inteiro,funcao FROM zn_users WHERE funcao='4' ORDER BY nome_inteiro ASC");
	echo '<select name="zn_funcionarios" id="zn_funcionarios" data-rel="chosen" onchange="fetch_select(this.value);" class="bootstrap-select" data-live-search="true" style="width:180px;">';
	echo '<option value="">Selecione</option>';
	echo '<option value="tdsfunc">Todos os Funcion&aacute;rios</option>';
		while($listar = $select->fetch_assoc()){
			echo '<option value="'.$listar['id'].'">'.$listar['nome_inteiro'].' - CPF: '.$listar['usuario'].'</option>';
		}
	echo '</select>';
}
function SelectFuncionariosName2(){
	global $mysqli;
	$select = $mysqli->query("SELECT id,usuario,nome_inteiro,funcao FROM zn_users WHERE funcao='4' ORDER BY nome_inteiro ASC");
	echo '<select name="zn_func" id="zn_func" data-rel="chosen" class="form-control" style="width:180px;">';
	echo '<option value="">Selecione</option>';
		while($listar = $select->fetch_assoc()){
			echo '<option value="'.$listar['id'].'">'.$listar['nome_inteiro'].'</option>';
		}
	echo '</select>';
}
function SelectCliName(){
	global $mysqli;
	$select = $mysqli->query("SELECT id,nome_fan FROM zn_clients ORDER BY nome_fan ASC");
	echo '<select name="zn_selclientes" id="zn_selclientes" class="bootstrap-select" onchange="fetch_select(this.value);" class="form-control" style="width:180px;">';
	echo '<option value="">Selecione</option>';
		while($listar = $select->fetch_assoc()){
			echo '<option value="'.$listar['id'].'">'.$listar['nome_fan'].'</option>';
		}
	echo '</select>';
}
function Icontype($type){
	if($type=="pdf" or $type=="PDF"){
		return 'img/pdf.png';
	}elseif($type=="doc" or $type=="DOC" or $type=="docx" or $type=="DOCX"){
		return 'img/doc.png';
	}elseif($type=="xls" or $type=="XLS" or $type=="xlsx" or $type=="XLSX"){
		return 'img/xls.png';
	}elseif($type=="jpg" or $type=="JPG" or $type=="jpeg" or $type=="JPEG"){
		return 'img/jpg.png';
	}elseif($type=="png" or $type=="PNG"){
		return 'img/png.png';
	}
}
function IDfromUser($username){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_users WHERE usuario='$username'");
	while($list = $sql->fetch_assoc()){
		return $list['id'];
	}
}
function NomefromUser($username){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_users WHERE usuario='$username'");
	while($list = $sql->fetch_assoc()){
		return $list['nome_inteiro'];
	}
}
function Numtodoscq(){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_contracheques");
	$num = $sql->num_rows;
		return $num;
}
function Numtodosfunc(){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_users WHERE funcao='4' AND ativo='1'");
	$num = $sql->num_rows;
		return $num;
}
function Nummeuscq($id){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_contracheques WHERE id_user='$id'");
	$num = $sql->num_rows;
		return $num;
}
function RemoveCq($idcq, $idusr){
	global $mysqli;
	$sel = $mysqli->query("SELECT * FROM zn_contracheques WHERE id='$idcq' AND id_user='$idusr'");
	while($list = $sel->fetch_assoc()){
		$mont = '../'.$list['caminho'];
		system("rm ".$mont." ");
		//unlink($mont);
	}
}
/*
*	Function existe_usuario
*	Args: $username
*	Retorna se exite usuÃ¡rio no BD
*/
function existe_usuario($username){
		global $mysqli;
		  $query = $mysqli->query("SELECT usuario FROM zn_users WHERE usuario='$username'");
		  $num = $query->num_rows;
			  if($num>0){
				  return true;
			  }else{
				  return false;
		  }
}
function GeraMenu($idadm){
	if($idadm==1){
		include "includes/templates/menu_adm.php";
	}elseif($idadm==2){
		include "includes/templates/menu_tec.php";
	}elseif($idadm==4){
		include "includes/templates/menu_fun.php";
	}
}
function iscq_ativo(){
global $mysqli;
$sql = $mysqli->query("SELECT * FROM zn_plugins WHERE slug='contracheques'");
$list = $sql->fetch_assoc();
	if($list['ativo']==1){
	echo '<a class="quick-button span2" href="plugin-contracheques"><i class="icon-money"></i><p>Contracheques</p></a>';
	}else{
	echo '<div class="alert alert-error"><strong>Plugin Contracheques Inativo!!!</strong> Contate o Administrador do Sistema.</div>';
	}
}
/**
 *     API INSIDE FUTURE
**/

/*
* Function VerifyApi
* Args: $apikey
* Retorna: Se a chave e valida ou nÃ£o de acordo com a API 
*/
function VerifyApi($apikey){
	global $mysqli;
	$montaurl = 'https://insidefuture.com.br/verifica/?lic='.$apikey.'&ws='.$_SERVER['HTTP_HOST'];
	$request = file_get_contents($montaurl);

	$json = json_decode($request, true);

		if($json['codigo']=="100"){
		echo '<font color="#32cd32">V&aacute;lido </font><br> Data de Expira&ccedil;&atilde;o: '.$json['data_exp'];
		$mysqli->query("UPDATE zn_options SET retcode='100'");
		}elseif($json['codigo']=="800"){
		echo '<font color="#be0000">Licen&ccedil;a Inativa ou Expirada</font>';
		$mysqli->query("UPDATE zn_options SET retcode='800'");
		}elseif($json['codigo']=="801"){
		echo '<font color="#333333">O seu Host n&atilde;o &eacute; o mesmo desta licen&ccedil;a!</font>';
		$mysqli->query("UPDATE zn_options SET retcode='801'");
		}elseif($json['codigo']=="802"){
		echo '<font color="#be0000">Licen&ccdil;a Inv&aacute;lida!</font>';
		$mysqli->query("UPDATE zn_options SET retcode='802'");
		}elseif($json['codigo']=="803"){
		echo '<font color="#be0000">Faltam Argumentos! Contate o Administrador!</font>';
		$mysqli->query("UPDATE zn_options SET retcode='803'");
		}
}
function AlertnoApi(){
	global $mysqli;
	$sql = $mysqli->query("SELECT retcode FROM zn_options");
	$list = $sql->fetch_assoc();
	if($list['retcode']!=100 || $list['retcode']==""){
		echo '
		<div class="alert alert-danger alert-bordered">
				Seu SPACEADMIN n&atilde;o est&aacute; Ativado!</strong> Utilize uma vers&atilde;o original para fazer atualiza&ccedil;&otilde;es e manter o sistema livre de bugs.
		</div>
		';
	}
}
function ReturnMyAPI(){
	global $mysqli;
	$sql = $mysqli->query("SELECT apikey FROM zn_options");
	$list = $sql->fetch_assoc();
	if($list['apikey']!=""){
		return $list['apikey'];
	}
}
function VerifyUpdates($apikey, $version){
	$montaurl = 'https://insidefuture.com.br/updates/?lic='.$apikey.'&v='.$version;
	$request = file_get_contents($montaurl);

	$json = json_decode($request, true);

		if($json['codigo']=="105"){
		echo '<strong>Seu sistema est&aacute; atualizado!<strong>';
		}elseif($json['codigo']=="700"){
		echo '<font color="#be0000">Atualiza&ccedil;&atilde;o Dispon&iacute;vel!</font><br><a href="#" class="btn btn-primary">Fazer Atualiza&ccedil;&atilde;o</a>';
		}elseif($json['codigo']=="701"){
		echo '<font color="#be0000">Voc&etilde; est&aacute; utilizando uma vers&atilde;o muito antiga ou desconhecida!</font>';
		}elseif($json['codigo']=="702"){
		echo '<font color="#be0000">Licen&ccdil;a Inv&aacute;lida!</font>';
		}elseif($json['codigo']=="703"){
		echo '<font color="#be0000">Faltam Argumentos! Contate o Administrador!</font>';
		}
}
	
function ScriptLoad(){
	$page = strtok(str_replace("/superadmin/", "", $_SERVER['REQUEST_URI']), '?');
	if($page=="index"){
		echo '<script type="text/javascript" src="assets/js/pages/dashboard.js"></script>';
	}elseif($page=="instalar-plugins" 
	|| $page=="todos-usuarios" 
	|| $page=="meu-perfil" 
	|| $page=="edit-user" 
	|| $page=="plugin-clientes"
	|| $page=="edit_clientes")
	{
		echo '<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
			<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
			<script type="text/javascript" src="assets/js/plugins/notifications/pnotify.min.js"></script>
			<script type="text/javascript" src="assets/js/plugins/uploaders/fileinput.min.js"></script>
			<script type="text/javascript" src="assets/js/pages/mask.js"></script>
			<script type="text/javascript" src="assets/js/pages/form_bootstrap_select.js"></script>
			<script type="text/javascript" src="assets/js/pages/datatables_basic.js"></script>
			<script type="text/javascript" src="assets/js/pages/uploader_bootstrap.js"></script>
			<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
			';
	}elseif($page=="configuracoes"){
		echo '<script type="text/javascript" src="assets/js/pages/form_checkboxes_radios.js"></script>';
	}elseif(
		$page=="novo-post" 
		|| $page=="editar-post" 
		|| $page=="plugin-pedidos" 
		|| $page=="plugin-contracheques" 
		|| $page=="plugin-entradasaida" 
		|| $page=="plugin-equipamentos"
		|| $page=="plugin-pedidos-listar"
		|| $page=="plugin-recibos"
		|| $page=="edit_equipamentos"
		|| $page=="edit-entradasaida"
		)
		{
		echo '<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
		<script type="text/javascript" src="assets/js/plugins/editors/wysihtml5/wysihtml5.min.js"></script>
		<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
		<script type="text/javascript" src="assets/js/plugins/editors/wysihtml5/toolbar.js"></script>
		<script type="text/javascript" src="assets/js/plugins/editors/wysihtml5/parsers.js"></script>
		<script type="text/javascript" src="assets/js/plugins/editors/wysihtml5/locales/bootstrap-wysihtml5.pt-BR.js"></script>
		<script type="text/javascript" src="assets/js/pages/editor_wysihtml5.js"></script>
		<script type="text/javascript" src="assets/js/pages/form_bootstrap_select.js"></script>
		<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
		<script type="text/javascript" src="assets/js/plugins/pickers/anytime.min.js"></script>
		<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.js"></script>
		<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.date.js"></script>
		<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.time.js"></script>
		<script type="text/javascript" src="assets/js/plugins/forms/tags/tagsinput.min.js"></script>
		<script type="text/javascript" src="assets/js/plugins/forms/tags/tokenfield.min.js"></script>
		<script type="text/javascript" src="assets/js/plugins/ui/prism.min.js"></script>
		<script type="text/javascript" src="assets/js/pages/mask.js"></script>
		<script type="text/javascript" src="assets/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>
		';
	}
}
function GetFotoPerfil($usuario){
	global $mysqli;
	$sql = $mysqli->query("SELECT url_img FROM zn_users WHERE usuario='$usuario'");
	while($list = $sql->fetch_assoc()){
	if($list['url_img']!=""){
		echo $list['url_img'];
	}else{
		echo URLSITE.'/assets/images/avatar.png';
	}
	}
}
function GetFotoProd(){
		echo URLSITE.'/assets/images/super.png';
	}
function Widget_Funcionarios(){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_users WHERE funcao='4' AND ativo='1'");
	$numfunc = $sql->num_rows;
	echo '
	<div class="panel bg-teal-400">
	<div class="panel-body">
		<div class="heading-elements">
		</div>

		<h3 class="no-margin">'.$numfunc.'</h3>
		Funcion&aacute;rios Cadastrados
	</div>

	<div class="container-fluid">
	</div>
	</div>
	';
}
function limpaCPF_CNPJ($valor){
	$valor = trim($valor);
	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", "", $valor);
	$valor = str_replace("-", "", $valor);
	$valor = str_replace("/", "", $valor);
	return $valor;
}

function Get_CNPJbyid($id){
	global $mysqli;
	$sql = $mysqli->query("SELECT cnpj FROM zn_clients WHERE id='$id'");
		$list = $sql->fetch_assoc();
			return $list['cnpj'];
}
function GetNumEntradaSaida(){
	global $mysqli;
	$sql = $mysqli->query("SELECT * FROM zn_entradasaida WHERE status='1' OR status='2'");
		$num = $sql->num_rows;
			if($num >0){
				return $num.' Ativos';
			}else{
				return 'Nenhum Ativo';
			}
}
function ExplodeList($lista){

	$string = explode(",",$lista);
	foreach ($string as $str) {
		echo "<li style='list-style:none'><strong>SU ".$str."</strong> - ".Nomeequip_byid($str)."</li>";
	}
}
function IfListtoExplode($codigo){
	$findme   = ',';
	$pos = strpos($codigo, $findme);
	if ($pos === false) {
		return false;
	}else{
		return true;
	}
}
function SetStatusLista($lista, $status){
	global $mysqli;

	$string = explode(",",$lista);

	foreach ($string as $str) {
		$mysqli->query("UPDATE zn_equipamentos SET status='$status' WHERE codpat='$str' ");
	}
}
function SetStatus($codigo, $status){
	global $mysqli;
	$mysqli->query("UPDATE zn_equipamentos SET status='$status' WHERE codpat='$codigo' ");
}
/*
*	Function VerifyisProject
*	Args: $codpat
*	Verificar se equipamento ja esta sendo usado em outro proj
*/
function VerifyisProject($codpat){
	global $mysqli;
	
	if(count($codpat) > 1) {
		
		$contar = array();
		foreach ($codpat as $str) {
			$query = $mysqli->query("SELECT status FROM zn_entradasaida WHERE codpat='$str'");
			
			$b = $query->fetch_assoc();
			if($b['status']==2){
				array_push($contar, 'true');
			}else{
				array_push($contar, 'false');
			}
		
		}

		if(in_array("true", $contar)){
			return true;
		}else{
			return false;
		}
		
	
	} elseif(count($codpat) == 1) {
	
		$query = $mysqli->query("SELECT * FROM zn_entradasaida WHERE codpat='$codpat[0]'");

		$b = $query->fetch_assoc();
			if($b['status']==2){
				return true;
			}else{
				return false;
			}
		}
}
function GeraTableProd($json){
	if(!empty($json)){
		$someArray = json_decode($json, true);
		(float)$soma = 0.00;
		echo "<table class='table'>";
		echo "<tr>
			<th>Servi&ccedil;o</th>
			<th>Quant.</th>
			<th>Valor Unit.</th>
			<th>Valor Total.</th>
		</tr>";

		foreach ($someArray as $key => $value) {
			if(!empty($value["servico"])){
				echo "<tr>";
				if($value["servico"]==52){
					echo "<td>Autenticações</td>";
				}elseif($value["servico"]==53){
					echo "<td>Reconhecimento de firmas - Autenticidade</td>";
				}elseif($value["servico"]==55){
					echo "<td>Abertura de firmas</td>";
				}elseif($value["servico"]==56){
					echo "<td>Reconhecimento de firmas - Semelhança</td>";
				}
				echo "<td>".$value["quant"]."</td>";
				echo "<td>".$value["vunitario"]."</td>";
				echo "<td>".$value["vtotal"]."</td>";
				echo "</tr>"; 
			}
			$soma += (float)$value["vtotal"];
			}
		echo "</table>";
		
		echo "<strong>Total dos Serviços:</strong> R$ ".number_format($soma, 2, ',', '.');
	}
}
function meses_ano($mes){
	if(!empty($mes)){
		if($mes == '01'){
			return 'Janeiro';
		}elseif($mes == '02'){
			return 'Fevereiro';
		}elseif($mes == '03'){
			return 'Março';
		}elseif($mes == '04'){
			return 'Abril';
		}elseif($mes == '05'){
			return 'Maio';
		}elseif($mes == '06'){
			return 'Junho';
		}elseif($mes == '07'){
			return 'Julho';
		}elseif($mes == '08'){
			return 'Agosto';
		}elseif($mes == '09'){
			return 'Setembro';
		}elseif($mes == '10'){
			return 'Outubro';
		}elseif($mes == '11'){
			return 'Novembro';
		}elseif($mes == '12'){
			return 'Dezembro';
		}
	}
}