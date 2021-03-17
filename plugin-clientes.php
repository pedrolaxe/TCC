<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
//admin_page($_SESSION['id_adm']);
?>
<?php include HEADER; ?>

<?php GeraMenu($_SESSION['id_adm']); ?>

				</div>
			</div>

			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-user"></i> Cadastro de Clientes</h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Cadastro de Clientes</li>
						</ul>
					</div>
				</div>
		<div class="content">

			<div class="row">
				<div class="col-md-4">
                <div class="panel panel-flat">
				<div class="panel-heading">
					<h6 class="panel-title">Cadastrar Cliente</h6>
					<div class="heading-elements">
					</div>
				</div>

		<div class="panel-body">
		<form class="form-horizontal" action="" method="post">

			<div class="form-group">
				<label>Razão Social</label>
				<input type="text" class="form-control" name="razao" id="razao">
			</div>

			<div class="form-group">
				<label>Nome Fantasia</label>
				<input type="text" class="form-control" name="nome_fan" id="nome_fan">
			</div>

			<div class="form-group">
				<label>CNPJ</label>
				<input type="text" class="form-control" name="cnpj" id="cnpj">
			</div>

			<div class="form-group">
				<label>E-mail</label>
				<input type="text" class="form-control" name="email" id="email">
			</div>

			<div class="form-group">
				<label>Telefone</label>
				<input type="text" class="form-control" name="telefone" id="telefone">
			</div>

			<div class="form-group">
				<label>Tel. Celular</label>
				<input type="text" class="form-control" name="celular" id="celular">
			</div>

			<div class="form-group">
				<label>CEP:</label>
				<input type="text" class="form-control" name="cep" id="cep">
			</div>

			<div class="form-group">
				<label>Endereço</label>
				<input type="text" class="form-control" name="endereco" id="endereco">
			</div>

			<div class="form-group">
				<label>Complemento</label>
				<input type="text" class="form-control" name="comp" id="comp">
			</div>

			<div class="form-group">
				<label>Bairro</label>
				<input type="text" class="form-control" name="bairro" id="bairro">
			</div>

			<div class="form-group">
				<label>Cidade</label>
				<input type="text" class="form-control" name="cidade" id="cidade">
			</div>

			<div class="form-group">
				<label>UF</label>
				<input type="text" class="form-control" name="uf" id="uf">
			</div>

			<div class="form-group">
				<label>Categoria</label>
				<?php Select_categories(); ?>
			</div>

			<div class="text-right">
				<button type="button" id="cadcli" class="btn bg-slate-800">Cadastrar</button>
			</div>
				</form>
					<div id="resultado"></div>
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h6 class="panel-title">Clientes Cadastrados</h6>
					<div class="heading-elements">
					</div>
				</div>

	<div class="panel-body">

	<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Razão Social</th>
				<th>Nome</th>
				<th>CNPJ</th>
				<th>E-mail</th>
				<th>Telefone</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>

		<?php
			$query = $mysqli->query("SELECT * FROM zn_clients ORDER BY data DESC");
			while($linha = $query->fetch_assoc()){
		?>
		<tr>
			<td><?=$linha['razao'];?></td>
			<td><?=$linha['nome_fan'];?></td>
			<td><?=$linha['cnpj'];?></td>
			<td><?=$linha['email'];?></td>
			<td><?=$linha['telefone'];?></td>
			<td class="text-center">
			<ul class="icons-list">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="edit_clientes?id=<?php echo base64_encode($linha['id']);?>"><i class="icon-pencil5 text-info"></i> Editar</a></li>
						<li><a href="ajax/rm_cli?id=<?php echo base64_encode($linha['id']);?>"><i class="icon-trash text-danger"></i>Remover</a></li>

					</ul>
					</li>
				</ul>
			</td>

		</tr>
		<?php } ?>

		</tbody>
	</table>
	</div>
	</div>
		
</div>
</div>
	<?php include FOOTER; ?>

</div>
<!-- /content area -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->
  <script>
  		jQuery(function($){
  		   $("#telefone").mask("(99) 9999-9999");
  		   $("#celular").mask("(99) 99999-9999");
  		   $("#cnpj").mask("99.999.999/9999-99");
  		   $("#cep").mask("99999-999");
  		});

  		 $("#cep").blur(function(){

  		 var cep = this.value.replace(/[^0-9]/, "");

  		 if(cep.length!=8){
  		 return false;
  		 }

  		 var url = "https://viacep.com.br/ws/"+cep+"/json/";

			$.getJSON(url, function(dadosRetorno){
				try{
					$("#endereco").val(dadosRetorno.logradouro);
					$("#bairro").val(dadosRetorno.bairro);
					$("#cidade").val(dadosRetorno.localidade);
					$("#uf").val(dadosRetorno.uf);
				}catch(ex){}
				});
  		 	});
  $(document).ready(function(){

  $('#cadcli').click(function(){

  var razao	   		= $("#razao").val();
  var nome_fan 	  	= $("#nome_fan").val();
  var cnpj 	   		= $("#cnpj").val();
  var email	   		= $("#email").val();
  var telefone	   	= $("#telefone").val();
  var celular	   	= $("#celular").val();
  var cep		   	= $("#cep").val();
  var endereco	   	= $("#endereco").val();
  var comp	   		= $("#comp").val();
  var bairro	   	= $("#bairro").val();
  var cidade	  	= $("#cidade").val();
  var uf		   	= $("#uf").val();
  var zn_categories = $("#zn_categories").val();

  var dataString = 'razao='+razao+'&nome_fan='+nome_fan+'&cnpj='+cnpj+'&email='+email+'&telefone='+telefone+'&celular='+celular+'&cep='+cep+'&endereco='+endereco+'&comp='+comp+'&bairro='+bairro+'&cidade='+cidade+'&uf='+uf+'&zn_categories='+zn_categories;

  if($.trim(cnpj).length>0){
	$.ajax({
		type: "POST",
		url: "ajax/cad_clients.php",
		data: dataString,
		cache: false,
		beforeSend: function(){ $("#resultado").html('Aguarde...');},
		success: function(data){
			if(data){
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
