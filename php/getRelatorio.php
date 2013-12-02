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
								$select = "select o.nomeOperadora,round(sum(a.media)/count(*),2) from AVALIACAO a, AVALIACAO_SERVICO ap, OPERADORA o where a.idAvaliacao=ap.idAvaliacao and a.idOperadora=o.idOperadora and o.nomeOperadora='$busca' group by nomeOperadora;";
								$results = $dbh->query($select);
								$dados = $results->fetch();

								$select2 = "select o.nomeOperadora,round(sum(a.media)/count(*),2) from AVALIACAO a, AVALIACAO_PRODUTO ap, OPERADORA o where a.idAvaliacao=ap.idAvaliacao and a.idOperadora=o.idOperadora and o.nomeOperadora='$busca' group by nomeOperadora;";
								$results2 = $dbh->query($select2);
								$dados2 = $results2->fetch();

								$media_produto = $dados2[1];
								$media_servico = $dados[1];
								$tipo_s = "SERVIÇOS";
								$tipo_p = "PRODUTOS";

								if ($media_servico == 0)
								{
									$tipo_s = "Sem avaliações";
								}
								if ($media_produto == 0)
								{
									$tipo_p = "Sem avaliações";
								}

								$MyData = new pData();
								$MyData->addPoints(array($media_produto,$media_servico),"Média");
								$MyData->setAxisName(0,"Média");
								$MyData->addPoints(array("$tipo_p","$tipo_s"),"operadora");
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

							if ($dados1[0] == 0)
							{
								$dados1[1] = "Sem avaliações";
							}
							if ($dados2[0] == 0)
							{
								$dados2[1] = "Sem avaliações";
							}
							if ($dados3[0] == 0)
							{
								$dados3[1] = "Sem avaliações";
							}
							if ($dados4[0] == 0)
							{
								$dados4[1] = "Sem avaliações";
							}
							
							$best_worst = new pData();
							$best_worst->addPoints(array($dados4[0],$dados3[0],$dados2[0],$dados1[0]),"Média");
							$best_worst->setAxisName(0,"Média");
							$best_worst->addPoints(array("$dados4[1]","$dados3[1]","$dados2[1]","$dados1[1]"),"bests_worsts");
							$best_worst->setSerieDescription("bests_worsts","melhor_pior");
							$best_worst->setAbscissa("bests_worsts");
							$best_worst->setAbscissaName("Produto / Serviço");

							/* Create the pChart object */
							$best_worst_pic = new pImage(755,280,$best_worst);

							/* Turn of Antialiasing */
							$best_worst_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$best_worst_pic->drawGradientArea(0,0,755,380,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$best_worst_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$best_worst_pic->drawText(300,0,"Piores/Melhores produtos e serviços avaliados",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$best_worst_pic->setGraphArea(100,30,720,240);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$best_worst_pic->drawScale($scaleSettings);

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
			$pesquisa = "Pesquisa de Produtos";
			$tipo = "PRODUTO";
			$coluna = "nomeProduto";
			$busca_explode = explode(" [", $busca);
			$operadora_explode = explode("]", $busca_explode[1]);
			//$select = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_PRODUTO ap,PRODUTO p, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and  p.nomeProduto='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' group by rep.nota;";
			//$results = $dbh->query($select);
			//$dados = $results->fetch();

				$nota1 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_PRODUTO ap,PRODUTO p, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and p.idOperadora=o.idOperadora and p.nomeProduto='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=1;";
				$nota2 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_PRODUTO ap,PRODUTO p, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and p.idOperadora=o.idOperadora and p.nomeProduto='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=2;";
				$nota3 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_PRODUTO ap,PRODUTO p, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and p.idOperadora=o.idOperadora and p.nomeProduto='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=3;";
				$nota4 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_PRODUTO ap,PRODUTO p, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and p.idOperadora=o.idOperadora and p.nomeProduto='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=4;";
				$nota5 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_PRODUTO ap,PRODUTO p, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and p.idOperadora=o.idOperadora and p.nomeProduto='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=5;";
				$results1 = $dbh->query($nota1);
				$results2 = $dbh->query($nota2);
				$results3 = $dbh->query($nota3);
				$results4 = $dbh->query($nota4);
				$results5 = $dbh->query($nota5);
				$dados1 = $results1->fetch();
				$dados2 = $results2->fetch();
				$dados3 = $results3->fetch();
				$dados4 = $results4->fetch();
				$dados5 = $results5->fetch();

				if ($dados1[0] == 0)
				{
					$dados1[1] = "1";
				}
				if ($dados2[0] == 0)
				{
					$dados2[1] = "2";
				}
				if ($dados3[0] == 0)
				{
					$dados3[1] = "3";
				}
				if ($dados4[0] == 0)
				{
					$dados4[1] = "4";
				}
				if ($dados5[0] == 0)
				{
					$dados5[1] = "5";
				}							
				$total_notas = new pData();
				$total_notas->addPoints(array($dados1[0],$dados2[0],$dados3[0],$dados4[0],$dados5[0]),"totalnotas");
				$total_notas->setAxisName(0,"Total de notas");
				$total_notas->addPoints(array("$dados1[1]","$dados2[1]","$dados3[1]","$dados4[1]","$dados5[1]"),"total_notas");
				$total_notas->setSerieDescription("total_notas","nota");
				$total_notas->setAbscissa("total_notas");
				$total_notas->setAbscissaName("Notas");

				/* Create the pChart object */
				$total_notas_pic = new pImage(700,280,$total_notas);

				/* Turn of Antialiasing */
				$total_notas_pic->Antialias = FALSE;

				/* Add a border to the picture */
				$total_notas_pic->drawGradientArea(0,0,700,380,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

				/* Set the default font */
				$total_notas_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
				$total_notas_pic->drawText(300,0,"Quantidades de notas do produto",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

				/* Define the chart area */
				$total_notas_pic->setGraphArea(100,30,680,240);

				/* Draw the scale */
				$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
				$total_notas_pic->drawScale($scaleSettings);

				/* Turn on shadow computing */ 
				$total_notas_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

				/* Draw the chart */
				$total_notas_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
				$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
				$total_notas_pic->drawBarChart($settings);

				/* Render the picture (choose the best way) */
				$total_notas_pic->autoOutput("total_notas.png");
			
			break;

		case "Serviços":
			$pesquisa = "Pesquisa de Serviços";
			$tipo = "SERVICO";
			$coluna = "nomeServico";
			$busca_explode = explode(" [", $busca);
			$operadora_explode = explode("]", $busca_explode[1]);

				$nota1 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_SERVICO aser,SERVICO s, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and s.idOperadora=o.idOperadora and s.nomeServico='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=1;";
				$nota2 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_SERVICO aser,SERVICO s, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and s.idOperadora=o.idOperadora and s.nomeServico='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=2;";
				$nota3 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_SERVICO aser,SERVICO s, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and s.idOperadora=o.idOperadora and s.nomeServico='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=3;";
				$nota4 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_SERVICO aser,SERVICO s, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and s.idOperadora=o.idOperadora and s.nomeServico='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=4;";
				$nota5 = "select count(rep.nota),rep.nota from RESPOSTA rep, AVALIACAO a, AVALIACAO_SERVICO aser,SERVICO s, OPERADORA o where rep.idAvaliacao=a.idAvaliacao and a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and s.idOperadora=o.idOperadora and s.nomeServico='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and rep.nota=5;";
				$results1 = $dbh->query($nota1);
				$results2 = $dbh->query($nota2);
				$results3 = $dbh->query($nota3);
				$results4 = $dbh->query($nota4);
				$results5 = $dbh->query($nota5);
				$dados1 = $results1->fetch();
				$dados2 = $results2->fetch();
				$dados3 = $results3->fetch();
				$dados4 = $results4->fetch();
				$dados5 = $results5->fetch();

				if ($dados1[0] == 0)
				{
					$dados1[1] = "1";
				}
				if ($dados2[0] == 0)
				{
					$dados2[1] = "2";
				}
				if ($dados3[0] == 0)
				{
					$dados3[1] = "3";
				}
				if ($dados4[0] == 0)
				{
					$dados4[1] = "4";
				}
				if ($dados5[0] == 0)
				{
					$dados5[1] = "5";
				}							
				$total_notas = new pData();
				$total_notas->addPoints(array($dados1[0],$dados2[0],$dados3[0],$dados4[0],$dados5[0]),"totalnotas");
				$total_notas->setAxisName(0,"Total de notas");
				$total_notas->addPoints(array("$dados1[1]","$dados2[1]","$dados3[1]","$dados4[1]","$dados5[1]"),"total_notas");
				$total_notas->setSerieDescription("total_notas","nota");
				$total_notas->setAbscissa("total_notas");
				$total_notas->setAbscissaName("Notas");

				/* Create the pChart object */
				$total_notas_pic = new pImage(700,280,$total_notas);

				/* Turn of Antialiasing */
				$total_notas_pic->Antialias = FALSE;

				/* Add a border to the picture */
				$total_notas_pic->drawGradientArea(0,0,700,380,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

				/* Set the default font */
				$total_notas_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
				$total_notas_pic->drawText(300,0,"Quantidades de notas do serviço",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

				/* Define the chart area */
				$total_notas_pic->setGraphArea(100,30,680,240);

				/* Draw the scale */
				$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
				$total_notas_pic->drawScale($scaleSettings);

				/* Turn on shadow computing */ 
				$total_notas_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

				/* Draw the chart */
				$total_notas_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
				$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
				$total_notas_pic->drawBarChart($settings);

				/* Render the picture (choose the best way) */
				$total_notas_pic->autoOutput("total_notas.png");
			
			break;
	}

}

?>