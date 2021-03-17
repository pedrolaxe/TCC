<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
admin_page($_SESSION['id_adm']);
?>
<?php include HEADER; ?>

<?php GeraMenu($_SESSION['id_adm']); ?>

				</div>
			</div>
			<!-- /main sidebar -->

			<!-- Main content -->
			<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header page-header-default">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-tree6"></i> Marcas</h4>
				</div>

			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
					<li class="active">Marcas</li>
				</ul>
			</div>
		</div>
			
		<div class="content">

			<div class="row">
				<div class="col-md-6">
		<div class="panel panel-flat">
						<div class="panel-heading">
							<h6 class="panel-title">Cadastrar Marcas</h6>
							<div class="heading-elements">
								<ul class="icons-list">
									<li><a data-action="collapse"></a></li>
									<li><a data-action="reload"></a></li>
								</ul>
							</div>
						</div>

						<div class="panel-body">
			<form class="form-horizontal" action="" method="post">

			<div class="form-group">
				<label>Nome:</label>
				<input type="text" class="form-control" id="marca">
			</div>

			<div class="form-group">
				<label>Slug:</label>
				<input type="text" class="form-control" id="slug">
			</div>

			<div class="text-right">
				<button type="button" class="btn btn-primary" id="cad">Cadastrar </button>
			</div>
			</form>
			<div id="resultado"></div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-flat">
			<div class="panel-heading">
				<h6 class="panel-title">Listar Marcas</h6>
				<div class="heading-elements">
					<ul class="icons-list">
						<li><a data-action="collapse"></a></li>
						<li><a data-action="reload"></a></li>
					</ul>
				</div>
			</div>

	<div class="panel-body">

		<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Título</th>
					<th>Slug</th>
					<th>Data</th>
					<th>&#8470; de Equip.</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
		<?php
			$query = $mysqli->query("SELECT * FROM zn_marcas");
			while($linha = $query->fetch_assoc()){
		?>
			<tr>
			<td><?=$linha['marca'];?></td>
			<td><?=$linha['slug'];?></td>
			<td><?=$linha['data'];?></td>
			<td><?php Numequip_marca($linha['slug']); ?></td>
			<td class="center">
				<a href="ajax/rm_marcas?id=<?php echo base64_encode($linha["id"]); ?>" class="btn btn-danger">
				<i class="icon-trash"></i>
				</a>
			</td>
			</tr>
		<?php	} ?>
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

var marca=$("#marca").val();
var slug=$("#slug").val();
var dataString = 'marca='+marca+'&slug='+slug;
if($.trim(marca).length>0) {

    console.log(marca);
    console.log(slug);
    console.log(dataString);

$.ajax({
type: "POST",
url: "ajax/cad_marcas.php",
data: dataString,
cache: false,
beforeSend: function(){ $("#resultado").html('<i class="icon-spinner2 spinner"></i>');},
success: function(data){
if(data){
window.location.href = "cat-marcas";
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
