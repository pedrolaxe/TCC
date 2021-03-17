<?php
if(!isset($_SESSION['usuario_admin'])){
	session_start();
}
include "../verifica.php";
global $mysqli;

$cliente    = anti_injection(mysqli_real_escape_string($mysqli, $_GET['cliente']));
$data_mes   = anti_injection(mysqli_real_escape_string($mysqli, $_GET['mes']));
$data_ano   = anti_injection(mysqli_real_escape_string($mysqli, $_GET['ano']));

if(!empty($cliente)){ $nome_cliente = Nome_cliente($cliente);}
if(!empty($data_mes)){ $nome_mes = meses_ano($data_mes);}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Recibo - 13 Notas</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style>
		body{margin-top:20px;background:#eee}.invoice{padding:30px}.invoice h2{margin-top:0;line-height:.8em}.invoice .small{font-weight:300}.invoice hr{margin-top:10px;border-color:#ddd}.invoice .table tr.line{border-bottom:1px solid #ccc}.invoice .table td{border:none}.invoice .identity{margin-top:10px;font-size:1.1em;font-weight:300}.invoice .identity strong{font-weight:600}.grid{position:relative;width:100%;background:#fff;color:#666;border-radius:2px;margin-bottom:25px;box-shadow:0 1px 4px rgba(0,0,0,.1)}	
	</style>
</head>
<body>

<div class="container">
<div class="row">

<div class="col-xs-12">
	<div class="grid invoice">
		<div class="grid-body">
			<div class="invoice-title">
				<div class="row">
					<div class="col-xs-6">
						<img src="<?php echo URLIMGS; ?>/13notas.jpg" />
					</div>
					<div class="col-xs-6 text-right">
					<address>
						<strong>Endereço:</strong><br>
						Av. Rio Branco, 135 sala 312<br> Centro - Rio de Janeiro/RJ<br>
						CEP 20040-912<br>
						(21) 4444-5555 / (21) 6666-8888<br>
					</address>
				</div>
				</div>
				
			</div>
			<hr>
			
			<div class="row">
				<div class="col-md-12">
					<h3>RECIBO DE PEDIDOS</h3>
					<p>Prestamos os seguintes serviços para: <strong><?php echo $nome_cliente; ?></strong> no mês de <strong><?=$nome_mes;?></strong> de <strong><?=$data_ano;?></strong>, listados abaixo:<br></p>
<?php

	$query = $mysqli->query("SELECT * FROM zn_pedidos WHERE codcliente='$cliente' ORDER BY datapedido ASC");

	function NomeServ($id){
		if($id == 52)
			return 'Autenticações';
		elseif($id == 53)
			return 'Reconhecimento de firmas - Autenticidade';
		elseif($id == 55)
			return 'Abertura de firmas';
		elseif($id == 56)
			return 'Reconhecimento de firmas - Semelhança';
	}

	echo '<table class="table table-striped">';
	echo '<thead>
	<tr class="line">';
	echo '
		<td><strong>#</strong></td>
		<td>Data</td>
		<td>Servi&ccedil;o</td>
		<td>Quant.</td>
		<td>Valor Unitário</td>
		<td>Valor Total.</td>
		';
	echo '</tr>
		</thead>
		<tbody>';

		$contareg = 1;
		
		while($linha = $query->fetch_assoc()){
		
			$json = $linha['save_cart']; 
			$datapedido = $linha['datapedido'];

			$dta_dia = substr($datapedido, 0, 2);
			$dta_mes = substr($datapedido, 3, 2);
			$dta_ano = substr($datapedido, 6, 4);
			

		if($dta_mes == $data_mes && $dta_ano == $data_ano &&!empty($json)){
			$someArray = json_decode($json, true);
			(float)$soma = 0.00;
			
			foreach ($someArray as $key => $value) {
				if(!empty($value["servico"])){
					echo "<tr>";
					echo "<td>".$contareg."</td>";
					echo "<td>".$datapedido."</td>";
					echo "<td>".NomeServ($value["servico"])."</td>";
					echo "<td>".$value["quant"]."</td>";
					echo "<td>R$ ".$value["vunitario"]."</td>";
					echo "<td>R$ ".$value["vtotal"]."</td>";
					echo "</tr>"; 
					$contareg += 1;
					}
					@$somaprod += (float)$value["vtotal"];
				}
			$soma += $somaprod;		
		}

	}
	echo "</tbody></table>";
	echo "<br>";
	echo "Recebemos um total de <strong> R$ ".number_format($soma, 2, ',', '.')."</strong> pelos serviços de Cartório.";
	$valortotal = number_format($soma, 2, ',', '.');
?>			
		</div>									
			</div>
			<div class="row">
				<div class="col-md-12 text-right identity">
					<p>Rio de Janeiro, <?php echo date('d'); ?> de <?php echo meses_ano(date('m')); ?> de <?php echo date('Y'); ?><br><br><br>__________________________<br>Assinatura &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
</div>

</body>
</html>