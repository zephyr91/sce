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

					break;


				case '2':

							$maiorP = "select max(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p, OPERADORA o where o.nomeOperadora='$busca' and a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and p.idOperadora = o.idOperadora group by nomeProduto order by media desc limit 0, 1;";
							$maiorS = "select max(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s, OPERADORA o where o.nomeOperadora='$busca' and a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and s.idOperadora = o.idOperadora group by nomeServico order by media desc limit 0, 1;";
							$menorP = "select min(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p, OPERADORA o where o.nomeOperadora='$busca' and a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and p.idOperadora = o.idOperadora group by nomeProduto order by media limit 0, 1;";
							$menorS = "select min(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s, OPERADORA o where o.nomeOperadora='$busca'and a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and s.idOperadora = o.idOperadora group by nomeServico order by media limit 0, 1;";
							$results1 = $dbh->query($maiorS);
							$results2 = $dbh->query($maiorP);
							$results3 = $dbh->query($menorS);
							$results4 = $dbh->query($menorP);
							$dados1 = $results1->fetch();
							$dados2 = $results2->fetch();
							$dados3 = $results3->fetch();
							$dados4 = $results4->fetch();

							if ($dados1[0] == 0 || $dados2[0] == 0 || $dados3[0] == 0 || $dados4[0] == 0)
							{
								echo "<script>$('#best_worst_relat').attr('src', '/images/indisponivel.png');</script>";
								exit();
							}
							
							$best_worst = new pData();
							$best_worst->addPoints(array($dados4[0],$dados3[0],$dados2[0],$dados1[0]),"Media");
							$best_worst->setAxisName(0,"Média");
							$best_worst->addPoints(array("$dados4[1]","$dados3[1]","$dados2[1]","$dados1[1]"),"bests_worsts");
							$best_worst->setSerieDescription("bests_worsts","Month");
							$best_worst->setAbscissa("bests_worsts");
							$best_worst->setAbscissaName("Produto / Serviço");

							/* Create the pChart object */
							$best_worst_pic = new pImage(800,300,$best_worst);

							/* Turn of Antialiasing */
							$best_worst_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$best_worst_pic->drawGradientArea(0,0,800,500,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$best_worst_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$best_worst_pic->drawText(300,0,"Piores/Melhores produtos e serviços",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$best_worst_pic->setGraphArea(100,30,780,240);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$best_worst_pic->drawScale($scaleSettings);

							/* Write the chart legend */
							//$best_worst_pic->drawLegend(780,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

							/* Turn on shadow computing */ 
							$best_worst_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$best_worst_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$best_worst_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$best_worst_pic->autoOutput("best_worst.png");

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