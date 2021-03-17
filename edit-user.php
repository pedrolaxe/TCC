<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
global $mysqli;
tec_page($_SESSION['id_adm']);
include HEADER;

$iduser = mysqli_real_escape_string($mysqli, base64_decode($_GET['id']));

GeraMenu($_SESSION['id_adm']);
?>

				</div>
			</div>

			<div class="content-wrapper">

				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-pencil3"></i> Editar Usuário</h4>
						</div>


					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Editar Usuário</li>
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
                  <h6 class="panel-title">Editar Usuário</h6>
                  <div class="heading-elements">
                    </div>
                </div>

                <div class="panel-body">
                      <?php
                    $query = $mysqli->query("SELECT * FROM zn_users WHERE id='$iduser'");
                    while($linha = $query->fetch_assoc()){

                    ?>
                    <form class="form-horizontal" action="" method="post">
                      <fieldset>
                      <div class="form-group">
                        <label>Nome Inteiro: </label>
                        <input name="nome" id="nome" class="form-control" type="text" value="<?=$linha['nome_inteiro'];?>" required>
                      </div>
                      <div class="form-group">
                        <label>E-mail: </label>
                        <input name="email" id="email" class="form-control" type="email" value="<?=$linha['email'];?>" required>
                      </div>

                      <div class="form-group">
                        <label>Data de Nascimento: </label>
                        <input name="nasc" id="nasc" class="form-control" type="text" value="<?=$linha['nascimento'];?>" required>
                      </div>

                      <div class="form-group">
                        <label>URL Imagem: </label>
                        <input name="imagem" id="imagem" class="form-control" type="url" value="<?=$linha['url_img'];?>">
                      </div>

                      <div class="form-group">
                        <label>Senha: </label>
                        <input name="senha" id="senha" class="form-control" type="password">
                      </div>

                      <div class="form-group">
                        <label>URL Imagem: </label>
                        <input name="senha2" id="senha2" class="form-control" type="password">
                      </div>

                      <div class="form-group">
                        <input type="hidden" name="iduser" id="iduser" value="<?php echo base64_encode($iduser); ?>">
                        <a href="ajax/rm_user?id=<?php echo base64_encode($iduser); ?>" class="btn btn-default"><i class="icon-cross2 text-danger"></i> Remover Usuário</a><br>
                        <br>
                        <button type="submit" class="btn btn-success" id="cad">Salvar</button>
                        <div id="resultado"></div>
                      </div>
                      </fieldset>
                    </form>
                    <?php
                    }
                    ?>
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

  $('#cad').click(function(){
    var nome=$("#nome").val();
    var nasc=$("#nasc").val();
    var imagem=$("#imagem").val();
    var senha=$("#senha").val();
    var senha2=$("#senha2").val();
    var email=$("#email").val();
    var iduser=$("#iduser").val();
    var dataString = 'nome='+nome+'&nasc='+nasc+'&imagem='+imagem+'&senha='+senha+'&senha2='+senha2+'&iduser='+iduser+'&email='+email;
  if($.trim(email).length>0){
    $.ajax({
      type: "POST",
      url: "ajax/save_profile.php",
      data: dataString,
      cache: false,
      beforeSend: function(){ $("#resultado").html('<strong>Salvando...</strong>');},
      success: function(data){
      if(data){
          $("#resultado").html(data);     
          $("#senha").val('');
          $("#senha2").val('');
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
