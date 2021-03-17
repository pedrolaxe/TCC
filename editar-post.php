<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
include HEADER;

GeraMenu($_SESSION['id_adm']);
$idpost = mysqli_real_escape_string($mysqli, base64_decode($_GET['id']));
?>

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-pencil4"></i> Editar Post</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Editar Post</li>
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
                  <h6 class="panel-title">Editar Post</h6>
                  <div class="heading-elements">
                  </div>
                </div>

                <div class="panel-body">
                  <?php
                  $query = $mysqli->query("SELECT * FROM zn_posts WHERE id='$idpost'");
    							while($linha = $query->fetch_assoc()){
                  ?>
                    <form class="form-horizontal" action="" method="post">
                      <fieldset>
                      <div class="form-group">
                        <label>Título: </label>
                        <input name="titulo" id="titulo" class="form-control" type="text" value="<?=$linha['titulo'];?>" required>
                      </div>
                      <div class="form-group">
                        <label>Slug: </label>
                        <input name="slug" id="slug" class="form-control" type="text" value="<?=$linha['slug'];?>">
                      </div>

                      <div class="form-group">
                        <label>Categoria: </label>
                        <?php Select_categories(); ?>
                      </div>

                      <div class="form-group">
                        <label>Texto: </label>
                        <textarea cols="8" rows="10" name="textopost" id="textopost" class="wysihtml5 wysihtml5-min form-control" placeholder="Digite algo...">
                          <?=$linha['texto'];?>
                        </textarea>
                      </div>

                      <div class="form-group">
												<input type="hidden" name="iduser" id="iduser" value="<?=$linha['id'];?>">
                        <button type="button" id="salvar" class="btn btn-primary">Salvar Modificações</button>
                        <br>
                        <br>
                        <div id="resultado"></div>
                      </div>
                      </fieldset>
                    </form>
                    <?php } ?>
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

  $('#salvar').click(function(){

  var titulo=$("#titulo").val();
  var slug=$("#slug").val();
  var zn_categories=$("#zn_categories").val();
  var textopost=$("#textopost").val();
	var iduser=$("#iduser").val();

  var dataString = 'titulo='+titulo+'&slug='+slug+'&zn_categories='+zn_categories+'&textopost='+textopost+'&iduser='+iduser;
  if($.trim(titulo).length>0 && $.trim(zn_categories).length>0){

  $.ajax({
  type: "POST",
  url: "ajax/edit_post.php",
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
