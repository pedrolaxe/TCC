<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

$is_admin = ID_userisadmin($_SESSION['user_id']);

if(!$is_admin) {
  header("Location: " . LINK_SITE );
}

if(!isset($_POST['submit'])) {
  $data1 = date("Y-m-d");
  $data2 = date("Y-m-d");
}

// if (isset($_POST['submit'])) {
  $faturamento = 0;
  $existe_pedido = false;

  $qtdList  = [];
  $nomeList = [];
  $precoList = [];

  if(isset($_POST['data1']) AND isset($_POST['data2'])) {

  $data1 = $_POST['data1'];
  $data2 = $_POST['data2'];

  if (empty($data1) || empty($data2)) {
    echo '<div style="margin:0" class="alert alert-primary" role="alert"><center>Preencha as Datas</center></div>';
    $existe_pedido = true;
  }

  elseif($data1 > $data2) {
    echo '<div style="margin:0" class="alert alert-primary" role="alert"><center>Primeira Data Não Pode Ser Maior Que A Segunda</center></div>';
    $existe_pedido = true;
  }

}

$query  = "

      SELECT * FROM PEDIDO 
      INNER JOIN PRODUTO ON
      PEDIDO.id_produto = PRODUTO.id_produto 
      INNER JOIN COMANDA ON 
      PEDIDO.id_comanda = COMANDA.id_comanda
                  
";

$result = $con->query($query);

foreach($result as $row) { 

  $status = $row['status'];
    
  if($status == 'fechado') { 

    $id_comanda   = $row['id_comanda'];
    $id_pedido    = $row['id_pedido'];
    $data_pedido  = $row['data'];
    $nome         = $row['nome'];
    $nome_produto = $row['nome_produto'];
    $qtd          = $row['quantidade'];
    $preco        = $row['preco'];

    $data_pedido = date("Y-m-d", strtotime($data_pedido));


    if ($data_pedido >= $data1 && $data_pedido <= $data2) {

      # PRODUTOS MAIS VENDIDOS
      # CRIAR 2 ARRAYS
      // $qtdList  = [];
      // $nomeList = [];

      if (in_array($nome_produto, $nomeList)) {
        # Achar Posição do $nome_produto
        $search = array_search($nome_produto, $nomeList);


        # Adicionar $qtd no $qtdList na Posição do nome
        $qtdList[$search] = $qtd + $qtdList[$search];

      } else {

        array_push($nomeList, $nome_produto);
        array_push($qtdList, $qtd);
        array_push($precoList, $preco);
      }

    } else {
      # MELHORAR MENSAGEM
      // echo "NÃO EXISTEM PEDIDOS NESSA DATA";
    }

  }

} 

$nomeTop = [];
$qtdTop  = [];
$produtoTop = [];

// echo '<pre>'; print_r($qtdList); echo '</pre>';
// echo '<pre>'; print_r($nomeList); echo '</pre>';
// echo 'TOP 1: '.$nomeList[array_search(max($qtdList), $qtdList)]. ' x '.$qtdList[array_search(max($qtdList), $qtdList)];

if(sizeof($qtdList) >= 5) {

$tamanho_qtdList = sizeof($qtdList);

for ($i = 0; $i < $tamanho_qtdList; $i++) {

array_push($nomeTop, $nomeList[array_search(max($qtdList), $qtdList)]);
array_push($qtdTop, $qtdList[array_search(max($qtdList), $qtdList)]);

#copia $qtd_list
if($i == 0) $copia_qtdList = $qtdList;

if($i != $tamanho_qtdList-1) unset($qtdList[array_search(max($qtdList), $qtdList)]);

}


$qtdList = $copia_qtdList;

for ($i = 0; $i < sizeof($nomeList); $i++) {

  $produtoList[$i] = $qtdList[$i] * $precoList[$i];

  // echo "qtdList: ".$qtdList[$i]."<br>";
  // echo "precoList: ".$precoList[$i]."<br>";
  // echo "produtoList: ".$produtoList[$i]."<br><br>";
}

$nomeTop2   = [];
$produtoTop = [];

for ($i = 0; $i < sizeof($nomeList); $i++) {

  array_push($nomeTop2, $nomeList[array_search(max($produtoList), $produtoList)]);
  array_push($produtoTop, $produtoList[array_search(max($produtoList), $produtoList)]);


  if($i != $tamanho_qtdList-1) unset($produtoList[array_search(max($produtoList), $produtoList)]);
}

// echo $produtoTop[0]."<br>";
// echo $produtoTop[1]."<br>";
// echo $produtoTop[2]."<br>";
$existe_pedido = true;


} elseif(sizeof($qtdList) > 0 && sizeof($qtdList) < 6) {
  echo '<div style="margin:0" class="alert alert-primary" role="alert"><center>Cadastre Mais Produtos Nessa Data</center></div>';
  $existe_pedido = true;
}

// echo 'TOP 3: '.$nomeList[array_search(max($qtdList), $qtdList)]. ' x '.$qtdList[array_search(max($qtdList), $qtdList)];

// echo $faturamento;

if (!$existe_pedido) {
  echo '<div style="margin:0" class="alert alert-primary" role="alert"><center>Não Existem Pedidos Nessa Data</center></div>';
}
// }

// echo $produtoTop[0]."<br>";
// echo $produtoTop[1]."<br>";
// echo $produtoTop[2]."<br>";


?>

<!DOCTYPE html>
<html>
<head>
	<title>Top Produtos</title>

  <!-- META TAGS AND IMPORTS (ICONES, CSS, JS, FONTES...) -->
  <?php include '../includes/head.php' ?>

  <!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?=LINK_SITE;?>assets/css/index.css" media="screen" />


  <style type="text/css">
    
    .form-control {
      height: 70px;
      margin-bottom: 20px; 
      font-size: 22px;
    }

    .logo {
      height: auto;
      /*width: auto;*/
    }

    button {
  border: 3px solid !important;
}

button:hover {
  border: 3px solid grey !important;
  background-color: black;
  color: white !important;
}

  </style>

</head>

<body>

<!-- Header and Nav Content -->
<?php include '../includes/header_admin.php'; ?>

<div class='container'>
  <br>

  <form action='top_produtos.php' method='post'>

  <div class="row">

    <div class="col-4">
  	  <h1>Top Produtos</h1>

    </div>

      <div class="col-3">
        <input name="data1" type="date" style="height:60px; width: 250px" value="<?php if(isset($data1)) echo $data1; else echo date("Y-m-d"); ?>"></div>

      <div class="col-3">
        <input name="data2" type="date" value="<?php if(isset($data2)) echo $data2; else echo date("Y-m-d"); ?>" style="height:60px; width: 250px">
      </div>

      <div class="col-1">
        <button class="btn-lg btn-outline" type="submit" name="submit" style="height:60px;">Ok</button>
      </div>

    </form>


    <br><br><br><br>

  	<hr>

  	<br>

    <div class="col-1"></div>

  <div class="col-4">
    <h2 align="center">Faturamento - Produto</h2>
    <canvas id="faturamento_produto" width="200" height="200"></canvas>
  </div>

  <div class="col-2">
    <!-- <canvas id="aportes" width="200" height="200"></canvas> -->
  </div>

  <div class="col-4">
    <h2 align="center">Produtos Mais Vendidos</h2>
    <canvas id="qtd_produto" width="200" height="200"></canvas>
  </div>

  <div class="col-1"></div>
  
  </div>
</div>
<br><br>
</body>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script>


var canvas = document.getElementById("faturamento_produto");
var ctx = canvas.getContext('2d');

Chart.defaults.global.defaultFontColor = 'black';
Chart.defaults.global.defaultFontSize = 14;
var theHelp = Chart.helpers;

var data = {
  labels: [
    '<?php echo $nomeTop2[0]; ?>',
    '<?php echo $nomeTop2[1]; ?>',
    '<?php echo $nomeTop2[2]; ?>',
    '<?php echo $nomeTop2[3]; ?>',
    '<?php echo $nomeTop2[4]; ?>'],
  datasets: [{
    fill: true,
    backgroundColor: [
      'blue',
      'rgb(54, 162, 235)',
      'grey',
      'green',
      'orange'
    ],
    data: ['<?php echo $produtoTop[0]; ?>', '<?php echo $produtoTop[1] ?>', '<?php echo $produtoTop[2]; ?>', '<?php echo $produtoTop[3]; ?>', '<?php echo $produtoTop[4]; ?>'],
    borderColor: ['black', 'black', 'black', 'black', 'black'],
    borderWidth: [2, 2, 2, 2, 2]
  }]
};

var options = {
  title: {
    display: false,
    text: '',
    position: 'top'
  },

  rotation: -0.7 * Math.PI,
  legend: {
    display: false,
    
    // generateLabels changes from chart to chart,  check the source, 
    // this one is from the doughut :
    // https://github.com/chartjs/Chart.js/blob/master/src/controllers/controller.doughnut.js#L42
    labels: {
      generateLabels: function(chart) {
        var data = chart.data;
        if (data.labels.length && data.datasets.length) {
          return data.labels.map(function(label, i) {
            var meta = chart.getDatasetMeta(0);
            var ds = data.datasets[0];
            var arc = meta.data[i];
            var custom = arc && arc.custom || {};
            var getValueAtIndexOrDefault = theHelp.getValueAtIndexOrDefault;
            var arcOpts = chart.options.elements.arc;
            var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
            var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
            var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);
              return {
              // And finally : 
              // text: ds.data[i] + " " + label,
              text: label,
              fillStyle: fill,
              strokeStyle: stroke,
              lineWidth: bw,
              hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
              index: i
            };
          });
        }
        return [];
      }
    }
  }
};

// Chart declaration:
var myPieChart = new Chart(ctx, {
  type: 'bar',
  data: data,
  options: options
});

var canvas = document.getElementById("qtd_produto");
var ctx = canvas.getContext('2d');

Chart.defaults.global.defaultFontColor = 'black';
Chart.defaults.global.defaultFontSize = 12;
var theHelp = Chart.helpers;

var data = {
  labels: [
    '<?php echo $nomeTop[0]; ?>',
    '<?php echo $nomeTop[1]; ?>',
    '<?php echo $nomeTop[2]; ?>',
    '<?php echo $nomeTop[3]; ?>',
    '<?php echo $nomeTop[4]; ?>',],
  datasets: [{
    fill: true,
    backgroundColor: [
      'blue',
      'rgb(54, 162, 235)',
      'grey',
      'green',
      'orange'
    ],
    data: ['<?php echo $qtdTop[0]; ?>', '<?php echo $qtdTop[1]; ?>', '<?php echo $qtdTop[2]; ?>', '<?php echo $qtdTop[3]; ?>', '<?php echo $qtdTop[4]; ?>'],
    borderColor: ['black', 'black', 'black', 'black', 'black'],
    borderWidth: [2, 2, 2, 2, 2]
  }]
};

var options = {
  title: {
    display: false,
    text: '',
    position: 'top',

  },

  rotation: -0.7 * Math.PI,
  legend: {
    display: false,
    
    // generateLabels changes from chart to chart,  check the source, 
    // this one is from the doughut :
    // https://github.com/chartjs/Chart.js/blob/master/src/controllers/controller.doughnut.js#L42
    labels: {
      generateLabels: function(chart) {
        var data = chart.data;
        if (data.labels.length && data.datasets.length) {
          return data.labels.map(function(label, i) {
            var meta = chart.getDatasetMeta(0);
            var ds = data.datasets[0];
            var arc = meta.data[i];
            var custom = arc && arc.custom || {};
            var getValueAtIndexOrDefault = theHelp.getValueAtIndexOrDefault;
            var arcOpts = chart.options.elements.arc;
            var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
            var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
            var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);
              return {
              // And finally : 
              // text: ds.data[i] + " " + label,
              text: label,
              fillStyle: fill,
              strokeStyle: stroke,
              lineWidth: bw,
              hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
              index: i
            };
          });
        }
        return [];
      }
    }
  }
};

var myPieChart = new Chart(ctx, {
  type: 'bar',
  data: data,
  options: options
});


// console.log(myPieChart.generateLegend());



//Plugin from githubExample:
//https://github.com/chartjs/Chart.js/blob/master/samples/data_labelling.html


Chart.plugins.register({
  afterDatasetsDraw: function(chartInstance, easing) {
    // To only draw at the end of animation, check for easing === 1
    var ctx = chartInstance.chart.ctx;
    chartInstance.data.datasets.forEach(function(dataset, i) {
      var meta = chartInstance.getDatasetMeta(i);
      if (!meta.hidden) {
        meta.data.forEach(function(element, index) {
          // Draw the text in black, with the specified font
          ctx.fillStyle = 'black';
          var fontSize = 0;
          var fontStyle = 'normal';
          var fontFamily = 'Helvetica Neue';
          ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
          // Just naively convert to string for now
          var dataString = dataset.data[index].toString();
          // Make sure alignment settings are correct
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          var padding = -10;
          var position = element.tooltipPosition();
          ctx.fillText(dataString + '', position.x, position.y - (fontSize / 2) - padding);
        });
      }
    });
  }
});


</script>
</html>