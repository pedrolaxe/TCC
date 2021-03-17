<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "verifica.php";
$idcli = mysql_real_escape_string(anti_injection(base64_decode($_GET['id'])));
//admin_page($_SESSION['id_adm']);
?>
<?php include HEADER; ?>

<?php GeraMenu($_SESSION['id_adm']); ?>

				</div>
			</div>
		
			<div class="content-wrapper">

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
			<div class="col-md-6">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h6 class="panel-title">Editar Cliente</h6>
					<div class="heading-elements">
						<ul class="icons-list">
							<li><a data-action="collapse"></a></li>
							<li><a data-action="reload"></a></li>
						</ul>
					</div>
				</div>

				<div class="panel-body">
				<form class="form-horizontal" action="" method="post">
		<?php
			$editcli = $mysqli->query("SELECT * FROM zn_clients WHERE id='$idcli'");
			$contcli = $editcli->num_rows;
			if($contcli>0){
				while($list = $editcli->fetch_assoc()){
		?>
			<div class="form-group">
				<label>Razão Social</label>
				<input type="text" class="form-control" name="razao" id="razao" value="<?php echo $list['razao']; ?>">
			</div>

			<div class="form-group">
				<label>Nome Fantasia</label>
				<input type="text" class="form-control" name="nome_fan" id="nome_fan" value="<?php echo $list['nome_fan']; ?>">
			</div>

			<div class="form-group">
				<label>CNPJ</label>
				<input type="text" class="form-control" name="cnpj" id="cnpj" value="<?php echo $list['cnpj']; ?>">
			</div>

			<div class="form-group">
				<label>E-mail</label>
				<input type="text" class="form-control" name="email" id="email" value="<?php echo $list['email']; ?>">
			</div>

			<div class="form-group">
				<label>Telefone</label>
				<input type="text" class="form-control" name="telefone" id="telefone" value="<?php echo $list['telefone']; ?>">
			</div>

			<div class="form-group">
				<label>Tel. Celular</label>
				<input type="text" class="form-control" name="celular" id="celular" value="<?php echo $list['celular']; ?>">
			</div>

			<div class="form-group">
				<label>CEP:</label>
				<input type="text" class="form-control" name="cep" id="cep" value="<?php echo $list['cep']; ?>">
			</div>

			<div class="form-group">
				<label>Endereço</label>
				<input type="text" class="form-control" name="endereco" id="endereco" value="<?php echo $list['endereco']; ?>">
			</div>

			<div class="form-group">
				<label>Complemento</label>
				<input type="text" class="form-control" name="comp" id="comp" value="<?php echo $list['comp']; ?>">
			</div>

			<div class="form-group">
				<label>Bairro</label>
				<input type="text" class="form-control" name="bairro" id="bairro" value="<?php echo $list['bairro']; ?>">
			</div>

			<div class="form-group">
				<label>Cidade</label>
				<input type="text" class="form-control" name="cidade" id="cidade" value="<?php echo $list['cidade']; ?>">
			</div>

			<div class="form-group">
				<label>UF</label>
				<input type="text" class="form-control" name="uf" id="uf" value="<?php echo $list['uf']; ?>">
			</div>

			<input type="hidden" name="id_cli" id="id_cli" value="<?php echo base64_encode($list['id']); ?>">
			<?php
				}}else{ echo '<script>window.location.href = "plugin-clientes";</script>';}
			?>

			<div class="text-right">
				<button type="button" id="editcli" class="btn btn-success">Salvar Alterações</button>
			</div>
		</form>
		<div id="resultado"></div>
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

		 var url = "http://viacep.com.br/ws/"+cep+"/json/";

		 $.getJSON(url, function(dadosRetorno){
		 try{
		 $("#endereco").val(dadosRetorno.logradouro);
		 $("#bairro").val(dadosRetorno.bairro);
		 $("#cidade").val(dadosRetorno.localidade);
		 $("#uf").val(dadosRetorno.uf);
		 }catch(ex){}
		 });
		 });
		 $(document).ready(function()
{

$('#editcli').click(function()
{
var razao	   = $("#razao").val();
var nome_fan 	   = $("#nome_fan").val();
var cnpj 	   = $("#cnpj").val();
var email	   = $("#email").val();
var telefone	   = $("#telefone").val();
var celular	   = $("#celular").val();
var cep		   = $("#cep").val();
var endereco	   = $("#endereco").val();
var comp	   = $("#comp").val();
var bairro	   = $("#bairro").val();
var cidade	   = $("#cidade").val();
var uf		   = $("#uf").val();
var id_cli  = $("#id_cli").val();

var dataString = 'razao='+razao+'&nome_fan='+nome_fan+'&cnpj='+cnpj+'&email='+email+'&telefone='+telefone+'&celular='+celular+'&cep='+cep+'&endereco='+endereco+'&comp='+comp+'&bairro='+bairro+'&cidade='+cidade+'&uf='+uf+'&id_cli='+id_cli;

if($.trim(cnpj).length>0)
{
$.ajax({
type: "POST",
url: "ajax/edit_client.php",
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
