<?php

require '../bootstrap.php';

session_start();

$dsn = 'mysql:dbname=sce;host=localhost';
$dbh = new PDO($dsn, 'guest', 'guest');
$dbh->exec("set names utf8");

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

	$relatorio = $_GET['item'];
	$busca = $_GET['search'];
	$relat = $_GET['relat'];

	switch ($relatorio)
	{
		//$pesquisa = "Pesquisa de Operadoras";
		//$tipo = "OPERADORA";
		//$coluna = "nomeOperadora";
		$select = "select o.nomeOperadora,round(sum(a.media)/count(*),2) from AVALIACAO a, AVALIACAO_SERVICO ap, OPERADORA o where a.idAvaliacao=ap.idAvaliacao and a.idOperadora=o.idOperadora and o.nomeOperadora='$busca' group by nomeOperadora;";
		$results = $dbh->query($select);
		$dados = $results->fetch();

		$select2 = "select o.nomeOperadora,round(sum(a.media)/count(*),2) from AVALIACAO a, AVALIACAO_PRODUTO ap, OPERADORA o where a.idAvaliacao=ap.idAvaliacao and a.idOperadora=o.idOperadora and o.nomeOperadora='$busca' group by nomeOperadora;";
		$results2 = $dbh->query($select2);
		$dados2 = $results2->fetch();

		$media_produto = $dados2[1];
		$media_servico = $dados[1];

		$MyData = new pData();
		$MyData->addPoints(array($media_produto,$media_servico),"Média");
		$MyData->setAxisName(0,"Média");
		$MyData->addPoints(array("PRODUTOS","SERVIÇOS"),"operadora");
		$MyData->setSerieDescription("operadora","operadora");
		$MyData->setAbscissa("operadora");
		$MyData->setAbscissaName("");

		/* Create the pChart object */
		$myPicture = new pImage(500,250,$MyData);
		$myPicture->drawGradientArea(0,0,500,500,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));
		$myPicture->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
		$myPicture->drawText(300,0,"Média geral de produtos e serviços",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

		/* Draw the chart scale */ 
		$myPicture->setGraphArea(100,70,480,240);
		$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM));
		


		/* Turn on shadow computing */ 
		$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

		/* Create the per bar palette */
		$Palette = array("0"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100),
						"1"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100));

		/* Draw the chart */ 
		$myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));

		/* Write the legend */ 
		//$myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

		/* Render the picture (choose the best way) */
		$myPicture->autoOutput("media_prod_serv.png");

	}
	
?>