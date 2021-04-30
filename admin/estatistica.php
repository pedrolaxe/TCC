<?php

session_start();
include "../includes/functions.php";

autorizacao_super();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório</title>

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
  <div class="row">

    <div class="col-4">
      <br>
  	  <h1><i class="fas fa-chart-pie"></i> Estatísticas</h1>
    </div>

    <div class="col-4">De: <input type="month" style="height:60px"></div>

    <div class="col-4">Até: <input type="month" style="height:60px"></div>


    <br><br><br><br>

  	<hr>

  	<br><br>

    <div class="col-1"></div>

  <div class="col-4">
    <h2>Faturamento</h2>
    <br>
    <canvas id="myChart" width="200" height="200"></canvas>
  </div>

  <div class="col-2">
    <!-- <canvas id="aportes" width="200" height="200"></canvas> -->
  </div>

  <div class="col-4">
    <h2>Produtos Mais Vendidos</h2>
    <br>
    <canvas id="aportes" width="200" height="200"></canvas>
  </div>

  <div class="col-1"></div>




 <a href="painel.php"><button class="btn btn-lg btn-outline-secondary" style="float:right; width:120px; margin-top: 70px">Voltar</button></a>
  
  </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script>

new Chart(document.getElementById("myChart"), {
  type: 'bar',
  data: {
    labels: [1,2,3,4,5,6,7,8,9,10,11,12],
    datasets: [
      {
        label: "Faturamento",
        backgroundColor: "#3e95cd",
        data: [5500, 7000, 6500, 4700, 4400, 5900]
      }

    ]
  },
  options: {
    title: {
      display: false,
    },
    legend: {
      display: false,
    },
    scales: {
      yAxes: [{
      id: 'A',
      type: 'linear',
      position: 'left',
      ticks: {
        min: 0,
        max: 10000
      }
    }]
    }
  }
});


// APORTES
new Chart(document.getElementById("aportes"), {
  type: 'pie',
  data: {
  labels: [
    'Coca-cola 350ml',
    'Original 600ml',
    'Hamburguer'
  ],
  datasets: [{
    label: 'My First Dataset',
    data: [300, 50, 100],
    backgroundColor: [
      'blue',
      'rgb(54, 162, 235)',
      'grey'
    ],
    hoverOffset: 4
  }]
}
});

</script>
</html>