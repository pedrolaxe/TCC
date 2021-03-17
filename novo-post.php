<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
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
							<h4><i class="icon-hammer-wrench"></i> Novo Post</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Novo Post</li>
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
                  <h6 class="panel-title">Criar Novo Post</h6>
                  <div class="heading-elements">
                  </div>
                </div>

                <div class="panel-body">

                    <form class="form-horizontal" action="" method="post">
                      <fieldset>
                      <div class="form-group">
                        <label>Título: </label>
                        <input name="titulo" id="titulo" class="form-control" type="text" required>
                      </div>
                      <div class="form-group">
                        <label>Slug: </label>
                        <input name="slug" id="slug" class="form-control" type="text">
                      </div>

                      <div class="form-group">
                        <label>Categoria: </label>
                        <?php Select_categories(); ?>
                      </div>

                      <div class="form-group">
                        <label>Texto: </label>
                        <textarea cols="8" rows="10" name="textopost" id="textopost" class="wysihtml5 wysihtml5-min form-control" placeholder="Digite algo...">
                        </textarea>
                      </div>

                      <div class="form-group">
                        <button type="button" id="cadastra" class="btn btn-primary">Salvar Modificações</button>
                        <br>
                        <br>
                        <div id="resultado"></div>
                      </div>
                      </fieldset>
                    </form>

                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="panel panel-flat">
                <div class="panel-heading">
                  <h6 class="panel-title">Listar Posts</h6>
                  <div class="heading-elements"></div>
                </div>

                <div class="panel-body">
                    <table class="table table-responsive datatable-basic">
                      <thead>
  							  <tr>
  								  <th>Título</th>
                    <th>Slug</th>
  								  <th>Data</th>
  									<th>Categoria</th>
  								  <th>Destaque</th>
  								  <th>Ações</th>
  							  </tr>
  						  </thead>
  						  <tbody>

             		<?php
  							$query = $mysqli->query("SELECT * FROM zn_posts");
  							while($linha = $query->fetch_assoc()){
  							?>
                <tr>
  								<td><?=$linha['titulo'];?></td>
                  <td><?=$linha['slug'];?></td>
  								<td class="text-center"><?=$linha['data'];?></td>
  								<td class="text-center"><?php Nomecat_byid($linha['categoria']);?></td>
  								<td class="text-center"><?php is_ativo($linha['ativo'], $linha['id']);?></td>
  								<td class="text-center">
                    <ul class="icons-list">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                          <li><a href="editar-post?id=<?php echo base64_encode($linha['id']);?>"><i class="icon-pencil5 text-success"></i> Editar</a></li>
                          <li><a href="ajax/desativa_post?id=<?php echo base64_encode($linha['id']);?>"><i class="icon-switch2 text-info"></i> Desativar</a></li>
                          <li class="divider"></li>
                          <li><a href="ajax/rm_post?id=<?php echo base64_encode($linha['id']);?>"><i class="icon-bin text-danger"></i> Remover</a></li>
                        </ul>
                      </li>
                    </ul>
  			  			  </td>
                </tr>
              <?php	}	?>

                </tbody>
                </table>

                </div>
              </div>
            </div>
            </div>

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

  $('#cadastra').click(function(){

  var titulo=$("#titulo").val();
  var slug=$("#slug").val();
  var zn_categories=$("#zn_categories").val();
  var textopost=$("#textopost").val();

  var dataString = 'titulo='+titulo+'&slug='+slug+'&zn_categories='+zn_categories+'&textopost='+textopost;
  if($.trim(titulo).length>0){

  $.ajax({
  type: "POST",
  url: "ajax/cad_post.php",
  data: dataString,
  cache: false,
  beforeSend: function(){ $("#resultado").html('<i class="icon-spinner2 spinner"></i>');},
  success: function(data){
  if(data=='true'){
  window.location.href = "novo-post";
  }
  else{
  $("#resultado").html(data);
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
