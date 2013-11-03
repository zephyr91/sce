<?php

require '../bootstrap.php';


session_start();

$dsn = 'mysql:dbname=sce;host=localhost';
$dbh = new PDO($dsn, 'guest', 'guest');
$dbh->exec("set names utf8");

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

	$tipo = $_GET['item'];
	$busca = $_GET['search'];

	switch ($tipo)
	{
		
		case "Operadora":
			$pesquisa = "Pesquisa de Operadoras";
			$tipo = "OPERADORA";
			$coluna = "nomeOperadora";
			$select = "select * from $tipo where $coluna='$busca';";
			$results = $dbh->query($select);
			$dados = $results->fetch();

			$MyData = new pData();  
			$MyData->addPoints(array(13251,4118,3087,1460,1248,156,26,9,8),"Hits");
			$MyData->setAxisName(0,"Hits");
			$MyData->addPoints(array("VIVO","CLARO","Internet Explorer","Opera","Safari","Mozilla","SeaMonkey","Camino","Lunascape"),"Browsers");
			$MyData->setSerieDescription("Browsers","Browsers");
			$MyData->setAbscissa("Browsers");
			$MyData->setAbscissaName("Browsers");

			/* Create the pChart object */
			$myPicture = new pImage(500,500,$MyData);
			$myPicture->drawGradientArea(0,0,500,500,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
			$myPicture->drawGradientArea(0,0,500,500,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
			$myPicture->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/pf_arma_five.ttf","FontSize"=>8));

			/* Draw the chart scale */ 
			$myPicture->setGraphArea(100,30,480,480);
			$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM));

			/* Turn on shadow computing */ 
			$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

			/* Create the per bar palette */
			$Palette = array("0"=>array("R"=>188,"G"=>224,"B"=>46,"Alpha"=>100),
							"1"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100),
							"2"=>array("R"=>224,"G"=>214,"B"=>46,"Alpha"=>100),
							"3"=>array("R"=>46,"G"=>151,"B"=>224,"Alpha"=>100),
							"4"=>array("R"=>176,"G"=>46,"B"=>224,"Alpha"=>100),
							"5"=>array("R"=>224,"G"=>46,"B"=>117,"Alpha"=>100),
							"6"=>array("R"=>92,"G"=>224,"B"=>46,"Alpha"=>100),
							"7"=>array("R"=>224,"G"=>176,"B"=>46,"Alpha"=>100));

			/* Draw the chart */ 
			$myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));

			/* Write the legend */ 
			$myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

			/* Render the picture (choose the best way) */
			$myPicture->autoOutput("operadoras.png");
			//echo $twig->render('getRelatorio.html', array('nome' => $dados[1],'grafico' => "example.drawBarChart.palette.png"));
			
			break;

		case "Produtos":
			/*$pesquisa = "Pesquisa de Produtos";
			$tipo = "PRODUTO";
			$coluna = "nomeProduto";
			$busca_explode = explode(" [", $busca);
			$operadora_explode = explode("]", $busca_explode[1]);
			$select = "select o.nomeOperadora,t.nomeProduto,t.descricaoProduto from $tipo t, OPERADORA o where $coluna='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and t.idOperadora = o.IdOperadora;";
			$results = $dbh->query($select);
			$dados = $results->fetch();
			echo $twig->render('getSearch.html', array('tipo' => $tipo, 'operadora' => $dados[0],'nome' => $dados[1],'descricao' => $dados[2],'pesquisa' => $pesquisa));*/
			
			break;

		case "Serviços":
			/*$pesquisa = "Pesquisa de Serviços";
			$tipo = "SERVICO";
			$coluna = "nomeServico";
			$busca_explode = explode(" [", $busca);
			$operadora_explode = explode("]", $busca_explode[1]);
			$select = "select o.nomeOperadora,t.nomeServico,t.descricaoServico from $tipo t, OPERADORA o where $coluna='" . $busca_explode[0] . "' and o.nomeOperadora='" . $operadora_explode[0] . "' and t.idOperadora = o.IdOperadora;";
			$results = $dbh->query($select);
			$dados = $results->fetch();
			echo $twig->render('getSearch.html', array('tipo' => $tipo, 'operadora' => $dados[0],'nome' => $dados[1],'descricao' => $dados[2],'pesquisa' => $pesquisa));*/
			
			break;
	}

}

?>