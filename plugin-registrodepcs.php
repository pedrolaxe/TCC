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
							<h4><i class="icon-user"></i> Relatório de Máquinas</h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Relatório de Máquinas</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->

				<!-- Content area -->
				<div class="content">

  					<div class="row">
  						<div class="col-md-6">
                <div class="panel panel-flat">
				<div class="panel-heading">
					<h6 class="panel-title">Cadastrar Máquina</h6>
					<div class="heading-elements">
						<ul class="icons-list">
					<li><a data-action="collapse"></a></li>
				</ul>
			</div>
				</div>

  								<div class="panel-body">
                    <form class="form-horizontal" method="post" action="ajax/envia-relpc.php" enctype="multipart/form-data">

						<div class="form-group">
							<label>Nome do Computador</label>
							<input type="text" class="form-control" name="nomepc" id="nomepc">
						</div>

						<div class="form-group">
							<label>Usuário</label>
							<input type="text" class="form-control" name="usuariopc" id="usuariopc">
						</div>

                        <div class="form-group">
                          <label>Sistema Operacional</label>
                          <select name="sispc" id="sispc" class="form-control">
							<option value="">Selecione</option>
							<option value="win7">Windows 7</option>
							<option value="win8">Windows 8</option>
							<option value="win10">Windows 10</option>
							<option value="linux">Linux</option>
							<option value="mac">Mac OS</option>
						</select>
                        </div>

							<div class="form-group">
							<label>Localização</label>
							<input type="text" class="form-control" name="localpc" id="localpc">
						</div>

							<div class="form-group">
							<label>Arquivo SIW</label>
								<input type="file" class="file-styled" name="siwpc[]" id="siwpc">
						</div>

                        <div class="form-group">
							<label>Cliente</label>
							<?php Select_clients(); ?>
						</div>

						<div class="text-right">
                          <button type="submit" class="btn btn-primary">Cadastrar</button>
						</div>
    							</form>
                 			 <div id="resultado"></div>
  								</div>
  							</div>
  						</div>

  						<div class="col-md-6">
  							<div class="panel panel-flat">
  								<div class="panel-heading">
  									<h6 class="panel-title">Máquinas Cadastradas</h6>
  									<div class="heading-elements">
  										<ul class="icons-list">
  					                		<li><a data-action="collapse"></a></li>
  					                		<li><a data-action="reload"></a></li>
  					                	</ul>
  				                	</div>
  								</div>

  						<div class="panel-body">
								<h4>Selecionar Cliente</h4>
								<?php SelectCliName();?>
								<br>
                <div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
						<th>OS</th>
						<th>Nome do PC</th>
						<th>Usuário</th>
						<th>Localização</th>
						<th>Cliente</th>
						<th>Link para Relatório</th>
						<th>Ações</th>
						</tr>
					</thead>
					<tbody id="respmaq">

					</tbody>

				</table>
              </div>
              </div>
    		
				</div>
  					</div><!--/row -->
  					<!-- /panel heading options -->

					<!-- Footer -->
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
/*
  $('#cadpc').click(function()
  {
  var nomepc	       = $("#nomepc").val();
  var usuariopc 	   = $("#usuariopc").val();
  var zn_clients 	   = $("#zn_clients").val();


  var dataString = 'nomepc='+nomepc+'&usuariopc='+usuariopc+'&zn_clients='+zn_clients;

  if($.trim(nomepc).length>0)
  {
  $.ajax({
  type: "POST",
  url: "ajax/cad_relatoriopcs.php",
  data: dataString,
  cache: false,
  beforeSend: function(){
     $("#resultado").html('Aguarde...');
     $("#relatoriohtml").fileinput({
        uploadUrl: "ajax/up-relat-html.php", // server upload action
				showClose: true,
			  showCaption: false,
			  showUpload: true,
			  showRemove: false,
			  showBrowse: false,
			  browseOnZoneClick: true,
			  allowedFileExtensions: ["html"], // change to what u want
			  maxFilePreviewSize: 3072, // change to what u want
			  maxFileSize: 3072, // change to what u want
			  dropZoneTitle: 'Drag & drop Photos here …', // change to what u want

         initialCaption: "Nenhum Arquivo Selecionado"
     });
   },
  success: function(data){
  if(data){
      $("#resultado").html(data);

  }
  }
  });

  }
  return false;
  });
*/
		$(".file-styled").uniform({
			fileButtonClass: 'action btn btn-default'
		});

  });

  		</script>
		<script type="text/javascript">
		function fetch_select(val){
				$.ajax({
				type: 'post',
				url: 'ajax/maqbyclient.php',
				data: {
				get_option:val
			},
			success: function (response) {
				$('#respmaq').html(response);
			}
			});
		}
			</script>
</body>
</html>
