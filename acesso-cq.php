<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
$idusuario = IDfromUser($_SESSION['usuario_admin']);
?>﻿
<?php include HEADER; ?>

<?php GeraMenu($_SESSION['id_adm']); ?>

				</div>
			</div>

			<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header page-header-default">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-tree6"></i> Meus Contracheques</h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
						<li class="active">Meus Contracheques</li>
					</ul>
				</div>
			</div>
				
				<div class="content">

  					<div class="row">
				<div class="col-md-12">
                <div class="panel panel-flat">
				<div class="panel-heading">
					<h6 class="panel-title">Meus Arquivos</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
							<li><a data-action="reload"></a></li>
						</ul>
					</div>
				</div>

					<div class="panel-body">
                    <table class="table table-striped table-bordered">
                      <thead>
                       <tr>
                         <th>Tipo</th>
                         <th>Arquivo</th>
                         <th>Data</th>
                         <th>Baixar</th>
                       </tr>
                     </thead>
                     <tbody>
                         <?php
                         $select_cq = $mysqli->query("SELECT * FROM zn_contracheques WHERE id_user='$idusuario'");

                         while($lista = $select_cq->fetch_assoc()){

                         ?>
                         <tr>
                           <td><img src="<?php echo URLSITE."/".Icontype($lista['tipo']); ?>" alt="tipo arquivo"></td>
                           <td><?php echo $lista['nome']; ?></td>
                           <td><?php echo $lista['data']; ?></td>
                           <td><a href="<?php echo URLSITE; ?>/<?php echo $lista['caminho'];?>" target="_blank"><i class="icon-file-download"></i></a></td>
                         </tr>
                         <?php } ?>

                     </tbody>
                    </table>
						</div>
					</div>
				</div>


  					</div><!--/row -->
  	
					<?php include FOOTER; ?>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
<script>
$(document).ready(function(){

$('#cad').click(function(){

	var nome_cat=$("#nome_cat").val();
	var slug_cat=$("#slug_cat").val();
	var dataString = 'nome_cat='+nome_cat+'&slug_cat='+slug_cat;
if($.trim(nome_cat).length>0 && $.trim(slug_cat).length>0){

$.ajax({
	type: "POST",
	url: "ajax/cad_categories.php",
	data: dataString,
	cache: false,
	beforeSend: function(){ $("#resultado").html('<i class="icon-spinner2 spinner"></i>');},
	success: function(data){
	if(data){
		window.location.href = "categorias";
	}
	else{
		$("#resultado").html("<span style='color:#cc0000'>Erro:</span> Preencha Todos os campos!");
	}
	}
});

}
return false;
});

});
</script>
</body>
</html>
