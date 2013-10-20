<?php

$mysqli = new mysqli('localhost','guest','guest','sce');

$dsn = 'mysql:dbname=sce;host=localhost';
$dbh = new PDO($dsn, 'guest', 'guest');

$SQL = 'SELECT idOperadora, COUNT( 1 ) AS numero
FROM `PRODUTO`
WHERE `idProduto` NOT
IN ( 2, 1, 5, 7, 3, 8, 10 )
GROUP BY `idOperadora`';

$result = $dbh->query($SQL);

$options = "";
$operadoras = [];
foreach($result->fetchAll() as $operadora){
	$operadoras[] = $operadora;
	$options .= "[{$operadora['idOperadora']}, {$operadora['numero']}],";
}



echo json_encode($operadoras);

/*
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chart Example</title>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart () {
      	var data = google.visualization.arrayToDataTable([
      		['id de operadora', 'numero de produtos'],
      		<?php echo $options; ?>
      	]);
      	var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);

      }

    </script>
</head>
<body>
	<div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>
*/