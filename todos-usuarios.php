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
							<h4><i class="icon-user"></i> Todos os Usuários</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Todos os Usuários</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->

				<!-- Content area -->
				<div class="content">

          <div class="row">
            <div class="col-md-4">
              <div class="panel panel-flat">
                <div class="panel-heading">
                  <h5 class="panel-title">Criar Usuários</h5>
                  <div class="heading-elements">
                    <ul class="icons-list">
						<li><a data-action="collapse"></a></li>
					</ul>
				</div>
                </div>

                <div class="panel-body">

                    <form class="form-horizontal" action="" method="post">
                      <fieldset>
                      <div class="form-group">
                        <label class="control-label">Nome: </label>
                        <input name="nome" id="nome" class="form-control" type="text">
                      </div>

                      <div class="form-group">
                        <label class="control-label">CPF: </label>
                        <input name="nome_user" id="nome_user" class="form-control" type="text" required>
                      </div>

                      <div class="form-group">
                        <label class="control-label">Senha: </label>
                        <input name="senha_user" id="senha_user" type="password" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label class="control-label">E-mail: </label>
                        <input name="email_user" id="email_user" class="form-control" type="email" required>
                      </div>

                      <div class="form-group">
                        <label class="control-label">Função: </label>
                        <?php Selectofunc($_SESSION['id_adm']); ?>
                      </div>

                      <div class="form-group">
                        <label class="control-label">Status: </label>
							<select name="zn_status" id="zn_status" class="bootstrap-select">
								<option value="1">Ativo</option>
								<option value="0">Inativo</option>
							</select>
                      </div>

                      <div class="form-group">
                        <button type="button" id="send" class="btn btn-primary">Cadastrar</button>
                        <br>
                        <div id="resultado"></div>
                      </div>
                      </fieldset>
                    </form>

                </div>
              </div>
            </div>

            <div class="col-md-8">
              <div class="panel panel-flat">
                <div class="panel-heading">
									<h5 class="panel-title">Todos os Usuários</h5>
                  <div class="heading-elements">
                    <ul class="icons-list">
                              <li><a data-action="collapse"></a></li>
                              <li><a data-action="reload"></a></li>
                            </ul>
                          </div>
                </div>

                <div class="panel-body">
			<div class="table-responsive">
				<table class="table datatable-basic">
						<thead>
							<tr>
								<th>Foto</th>
								<th>Nome</th>
								<th>CPF</th>
								<th>Última Alteração</th>
								<th>Função</th>
								<th>Status</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if($_SESSION['id_adm']==1){
							$select_user = $mysqli->query("SELECT * FROM zn_users");
						}elseif($_SESSION['id_adm']==2){
							$select_user = $mysqli->query("SELECT * FROM zn_users WHERE funcao='2' OR funcao='4'");
						}
						while($lista = $select_user->fetch_assoc()){

						?>
						<tr>
							<td><img src="<?php GetFotoPerfil($lista['usuario']); ?>" width="32" height="32"></td>
							<td><?php echo $lista['nome_inteiro']; ?></td>
							<td><?php echo $lista['usuario']; ?></td>
							<td class="text-center"><?php echo $lista['data']; ?></td>
							<td class="text-center"><?php echo Convert_role($lista['funcao']); ?></td>
							<td class="text-center">
								<?php Verify_roles($lista['ativo'], $lista['id']); ?>
							</td>
							<td class="text-center">
								<ul class="icons-list">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="edit-user?id=<?php echo base64_encode($lista['id']); ?>"><i class="icon-pencil5 text-info"></i> Editar</a></li>
									</ul>
								</li>
							</ul>
							</td>
						</tr>
						<?php }	?>

						</tbody>
					</table>
				</div>
                </div>
              </div>
            </div>
            </div>

<script>
$(document).ready(function(){

$('#send').click(function(){
	var nome=$("#nome").val();
	var nome_user=$("#nome_user").val();
	var senha_user=$("#senha_user").val();
	var email_user=$("#email_user").val();
	var zn_roles=$("#zn_roles").val();
	var zn_status=$("#zn_status").val();

	var dataString = 'nome='+nome+'&nome_user='+nome_user+'&senha_user='+senha_user+'&email_user='+email_user+'&zn_roles='+zn_roles+'&zn_status='+zn_status;
if($.trim(nome).length>0 && $.trim(nome_user).length>0 && $.trim(senha_user).length>0 && $.trim(email_user).length>0 && $.trim(zn_roles).length>0){
	$.ajax({
		type: "POST",
		url: "ajax/cad_users.php",
		data: dataString,
		cache: false,
		beforeSend: function(){ $("#resultado").html('<i class="icon-spinner2 spinner"></i>');},
		success: function(data){
		if(data=='true'){
		window.location.href = "todos-usuarios";
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

</body>
</html>
