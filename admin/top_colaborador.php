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

  $submit_ok = false;
}

if (isset($_POST['submit'])) {

  $submit_ok = true;

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
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Faturamento</title>

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

  <form action='top_colaborador.php' method='post'>

  <div class="row">

    <div class="col-4">
      <h1>Top Colaborador</h1>

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


    <br><br><br>

    <hr style="opacity: 0">

    <br>

    <!-- <div class="col-1"></div> -->

  <div class="col-6">
    <h2 align="center">Faturamento</h2><br>
    <canvas id="faturamento" width="100" height="70"></canvas>
  </div>



  <div class="col-6">
    <h2 align="center">Quantidade Vendida</h2><br>
    <canvas id="qtd_vendida" width="100" height="70"></canvas>
  </div>

  <!-- <div class="col-1"></div> -->
  
  </div>
</div>
<br><br>

<?php

      $submit_ok = false;

      $array_nome = [];
      $array_qtd  = [];
      $array_fat  = [];

      if(isset($_POST['submit'])) {

            # flag
            $submit_ok = true;

              $query = "SELECT c.nome_colaborador, SUM(p.quantidade), SUM(p.valor*p.quantidade) FROM PEDIDO p INNER JOIN COLABORADOR c ON p.id_colaborador = c.id_colaborador INNER JOIN COMANDA com ON p.id_comanda = com.id_comanda WHERE DATE(p.data) >= '$data1' AND DATE(p.data) <= '$data2' AND com.status = 'fechado' AND p.status_pedido IS NULL AND c.status_colaborador IS NULL GROUP BY c.id_colaborador";
              $result = $con->query($query);

              foreach ($result as $value) {

               $nome_colaborador = $value[0];
                $qtd = $value[1];
                $fat = $value[2];

                array_push($array_nome, $value[0]);
                array_push($array_qtd, $value[1]);
                array_push($array_fat, $value[2]);

                $max_value = max($array_fat);


              }

            }

            if (!$submit_ok) {

              $query = "SELECT c.nome_colaborador, SUM(p.quantidade), SUM(p.valor*p.quantidade) FROM PEDIDO p INNER JOIN COLABORADOR c ON p.id_colaborador = c.id_colaborador INNER JOIN COMANDA com ON p.id_comanda = com.id_comanda WHERE com.status = 'fechado' AND p.status_pedido IS NULL AND c.status_colaborador IS NULL GROUP BY c.id_colaborador";
              $result = $con->query($query);

              foreach ($result as $value) {

                $nome_colaborador = $value[0];
                $qtd = $value[1];
                $fat = $value[2];



                array_push($array_nome, $value[0]);
                array_push($array_qtd, $value[1]);
                array_push($array_fat, $value[2]);

                $max_value = max($array_fat);


              }

            }
             ?>



</body>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script>

<?php

$array_nome = json_encode($array_nome);
echo "var array_nome = ". $array_nome . ";\n";

$array_qtd = json_encode($array_qtd);
echo "var array_qtd = ". $array_qtd . ";\n";

$array_fat = json_encode($array_fat);
echo "var array_fat = ". $array_fat . ";\n";

?>

function show_item(item) {
  return item;
}

let nomes = array_nome.map(show_item);
let qtd   = array_qtd.map(show_item);
let fat   = array_fat.map(show_item);


var canvas = document.getElementById("faturamento");
var ctx = canvas.getContext('2d');

Chart.defaults.global.defaultFontColor = 'black';
Chart.defaults.global.defaultFontSize = 14;
var theHelp = Chart.helpers;

var data = {
  labels: nomes,
  datasets: [{
    fill: true,
    backgroundColor: [
      'blue',
      'rgb(54, 162, 235)',
      'grey',
      'green',
      'orange'
    ],
    data: fat,
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

  scales: {
        yAxes: [{
            display: true,
            ticks: {
              suggestedMin: 0,
              beginAtZero: true,
              fontSize: 14,
              fontFamily: 'Ubuntu',
                
            },
            afterDataLimits(scale) {
              scale.max *= 1.1;
            }
        }],

        xAxes: [{
            ticks: {
              fontSize: 20,
              fontFamily: 'Ubuntu',
            },
            gridLines : {
              drawOnChartArea: false
            }
        }]
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

var canvas = document.getElementById("qtd_vendida");
var ctx = canvas.getContext('2d');

Chart.defaults.global.defaultFontColor = 'black';
Chart.defaults.global.defaultFontSize = 12;
Chart.defaults.global.defaultFontStyle = 'Bold';
var theHelp = Chart.helpers;

var data = {
  labels: nomes,
  datasets: [{
    fill: true,
    backgroundColor: [
      'blue',
      'rgb(54, 162, 235)',
      'grey',
      'green',
      'orange'
    ],
    data: qtd,
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

  scales: {
        yAxes: [{
            display: true,
            ticks: {
              suggestedMin: 0,
              beginAtZero: true,
              fontSize: 14,
              fontFamily: 'Ubuntu',
  
            },
            afterDataLimits(scale) {
              scale.max *= 1.1;
            },

        }],
        xAxes: [{
            ticks: {
              fontSize: 20,
              fontFamily: 'Ubuntu',
            },
            gridLines : {
              drawOnChartArea: false
            }
        }]
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
          var fontSize = 28;
          var fontStyle = 'bold';
          var fontFamily = 'Ubuntu';
          ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
          // Just naively convert to string for now
          var dataString = dataset.data[index].toString();
          // Make sure alignment settings are correct
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          var padding = 0;
          var position = element.tooltipPosition();
          ctx.fillText(dataString + '', position.x, position.y - (fontSize / 2) - padding);
        });
      }
    });
  }
});

</script>
</html>