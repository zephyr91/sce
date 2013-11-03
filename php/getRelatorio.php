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
	$relat = $_GET['relat'];

	switch ($tipo)
	{
		
		case "Operadora":

			switch ($relat)
			{
				case '1':

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
								$myPicture->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/pf_arma_five.ttf","FontSize"=>6));

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
								$myPicture->autoOutput("media_prod_serv.png");

					break;


				case '2':

							$best_worst = new pData();
							$best_worst->addPoints(array(150,220,300,250,420,200,300,200,100),"Server A");
							$best_worst->addPoints(array(140,0,340,300,320,300,200,100,50),"Server B");
							$best_worst->setAxisName(0,"Hits");
							$best_worst->addPoints(array("January","February","March","April","May","Juin","July","August","September"),"Months");
							$best_worst->setSerieDescription("Months","Month");
							$best_worst->setAbscissa("Months");

							/* Create the pChart object */
							$best_worst_pic = new pImage(700,230,$best_worst);

							/* Turn of Antialiasing */
							$best_worst_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$best_worst_pic->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
							$best_worst_pic->drawGradientArea(0,0,700,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
							$best_worst_pic->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0));

							/* Set the default font */
							$best_worst_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/pf_arma_five.ttf","FontSize"=>6));

							/* Define the chart area */
							$best_worst_pic->setGraphArea(60,40,650,200);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$best_worst_pic->drawScale($scaleSettings);

							/* Write the chart legend */
							$best_worst_pic->drawLegend(580,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

							/* Turn on shadow computing */ 
							$best_worst_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$best_worst_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$best_worst_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$best_worst_pic->autoOutput("pictures/example.drawBarChart.spacing.png");

					break;
			}
			
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