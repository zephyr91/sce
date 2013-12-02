<?php

require '../bootstrap.php';

session_start();

$dsn = 'mysql:dbname=sce;host=localhost';
$dbh = new PDO($dsn, 'guest', 'guest');
$dbh->exec("set names utf8");

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

	$tipo=$_GET['tipo'];
	$escolhido=$_GET['escolhido'];
	$nome=$_SESSION['nome'];
	
	if (isset($escolhido))
	{
		switch ($tipo)
		{
			case 'Operadora':
				switch ($escolhido)
				{
					case 'Quantidade por região':
						$select="SELECT COUNT(a.idAvaliacao) as quantidade, u.unidadeFederativa FROM AVALIACAO a, USUARIO u,OPERADORA o WHERE a.idUsuario = u.idUsuario and a.idOperadora=o.idOperadora and o.nomeOperadora='$nome'  GROUP BY u.unidadeFederativa;";
						$result=$dbh->query($select);
						$dados=$result->fetchAll();

							$qntd_regiao = new pData();
							$qntd_regiao->addPoints(array($dados[0][0],$dados[1][0],$dados[2][0],$dados[3][0],$dados[4][0],$dados[5][0],$dados[6][0],$dados[7][0],$dados[8][0],$dados[9][0],$dados[10][0],$dados[11][0],$dados[12][0],$dados[13][0],$dados[14][0],$dados[15][0],$dados[16][0],$dados[17][0],$dados[18][0],$dados[19][0],$dados[20][0],$dados[21][0],$dados[22][0],$dados[23][0],$dados[24][0],$dados[25][0],$dados[26][0]),"Quantidade");
							$qntd_regiao->setAxisName(0,"QUANTIDADE");
							$qntd_regiao->addPoints(array($dados[0][1],$dados[1][1],$dados[2][1],$dados[3][1],$dados[4][1],$dados[5][1],$dados[6][1],$dados[7][1],$dados[8][1],$dados[9][1],$dados[10][1],$dados[11][1],$dados[12][1],$dados[13][1],$dados[14][1],$dados[15][1],$dados[16][1],$dados[17][1],$dados[18][1],$dados[19][1],$dados[20][1],$dados[21][1],$dados[22][1],$dados[23][1],$dados[24][1],$dados[25][1],$dados[26][1]),"UF");
							$qntd_regiao->setSerieDescription("UF","unidades");
							$qntd_regiao->setAbscissa("UF");
							$qntd_regiao->setAbscissaName("UNIDADE FEDERATIVA");

							/* Create the pChart object */
							$qntd_regiao_pic = new pImage(700,380,$qntd_regiao);

							/* Turn of Antialiasing */
							$qntd_regiao_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$qntd_regiao_pic->drawGradientArea(0,0,700,380,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$qntd_regiao_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$qntd_regiao_pic->drawText(300,0,"Quantidade de avaliações por região",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$qntd_regiao_pic->setGraphArea(100,30,680,340);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$qntd_regiao_pic->drawScale($scaleSettings);

							/* Turn on shadow computing */ 
							$qntd_regiao_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$qntd_regiao_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$qntd_regiao_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$qntd_regiao_pic->autoOutput("qntd_regiao.png");

						break; 
					
					case 'Média por região':
						$select="SELECT truncate(SUM(a.media)/COUNT(a.media),2), u.unidadeFederativa FROM AVALIACAO a, USUARIO u,OPERADORA o WHERE a.idUsuario = u.idUsuario and o.nomeOperadora='$nome' GROUP BY u.unidadeFederativa;";
						$result=$dbh->query($select);
						$dados=$result->fetchAll();

							$media_regiao = new pData();
							$media_regiao->addPoints(array($dados[0][0],$dados[1][0],$dados[2][0],$dados[3][0],$dados[4][0],$dados[5][0],$dados[6][0],$dados[7][0],$dados[8][0],$dados[9][0],$dados[10][0],$dados[11][0],$dados[12][0],$dados[13][0],$dados[14][0],$dados[15][0],$dados[16][0],$dados[17][0],$dados[18][0],$dados[19][0],$dados[20][0],$dados[21][0],$dados[22][0],$dados[23][0],$dados[24][0],$dados[25][0],$dados[26][0]),"MÉDIA");
							$media_regiao->setAxisName(0,"MÉDIA");
							$media_regiao->addPoints(array($dados[0][1],$dados[1][1],$dados[2][1],$dados[3][1],$dados[4][1],$dados[5][1],$dados[6][1],$dados[7][1],$dados[8][1],$dados[9][1],$dados[10][1],$dados[11][1],$dados[12][1],$dados[13][1],$dados[14][1],$dados[15][1],$dados[16][1],$dados[17][1],$dados[18][1],$dados[19][1],$dados[20][1],$dados[21][1],$dados[22][1],$dados[23][1],$dados[24][1],$dados[25][1],$dados[26][1]),"UF");
							$media_regiao->setSerieDescription("UF","unidades");
							$media_regiao->setAbscissa("UF");
							$media_regiao->setAbscissaName("UNIDADE FEDERATIVA");

							/* Create the pChart object */
							$media_regiao_pic = new pImage(700,380,$media_regiao);

							/* Turn of Antialiasing */
							$media_regiao_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$media_regiao_pic->drawGradientArea(0,0,700,380,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$media_regiao_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$media_regiao_pic->drawText(300,0,"Média das avaliações por região",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$media_regiao_pic->setGraphArea(100,30,680,340);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$media_regiao_pic->drawScale($scaleSettings);

							/* Turn on shadow computing */ 
							$media_regiao_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$media_regiao_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$media_regiao_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$media_regiao_pic->autoOutput("media_regiao.png");
						break;
					
					case 'Média de idade por região':
						$select="SELECT truncate(SUM((SELECT EXTRACT(YEAR FROM current_timestamp)) - (SELECT EXTRACT(YEAR FROM u.dataNascimento)))/COUNT(u.idUsuario),0) as idade_media, u.unidadeFederativa FROM USUARIO u, AVALIACAO a,OPERADORA o WHERE a.idUsuario = u.idUsuario and o.nomeOperadora='$nome' GROUP BY u.unidadeFederativa;";
						$result=$dbh->query($select);
						$dados=$result->fetchAll();

							$idade_regiao = new pData();
							$idade_regiao->addPoints(array($dados[0][0],$dados[1][0],$dados[2][0],$dados[3][0],$dados[4][0],$dados[5][0],$dados[6][0],$dados[7][0],$dados[8][0],$dados[9][0],$dados[10][0],$dados[11][0],$dados[12][0],$dados[13][0],$dados[14][0],$dados[15][0],$dados[16][0],$dados[17][0],$dados[18][0],$dados[19][0],$dados[20][0],$dados[21][0],$dados[22][0],$dados[23][0],$dados[24][0],$dados[25][0],$dados[26][0]),"Média");
							$idade_regiao->setAxisName(0,"MÉDIA");
							$idade_regiao->addPoints(array($dados[0][1],$dados[1][1],$dados[2][1],$dados[3][1],$dados[4][1],$dados[5][1],$dados[6][1],$dados[7][1],$dados[8][1],$dados[9][1],$dados[10][1],$dados[11][1],$dados[12][1],$dados[13][1],$dados[14][1],$dados[15][1],$dados[16][1],$dados[17][1],$dados[18][1],$dados[19][1],$dados[20][1],$dados[21][1],$dados[22][1],$dados[23][1],$dados[24][1],$dados[25][1],$dados[26][1]),"UF");
							$idade_regiao->setSerieDescription("UF","unidades");
							$idade_regiao->setAbscissa("UF");
							$idade_regiao->setAbscissaName("UNIDADE FEDERATIVA");

							/* Create the pChart object */
							$idade_regiao_pic = new pImage(700,380,$idade_regiao);

							/* Turn of Antialiasing */
							$idade_regiao_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$idade_regiao_pic->drawGradientArea(0,0,800,400,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$idade_regiao_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$idade_regiao_pic->drawText(300,0,"Média de idade dos usuários por região",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$idade_regiao_pic->setGraphArea(100,30,680,340);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$idade_regiao_pic->drawScale($scaleSettings);

							/* Turn on shadow computing */ 
							$idade_regiao_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$idade_regiao_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$idade_regiao_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$idade_regiao_pic->autoOutput("idade_regiao.png");
						break;
					
					case 'Média por sexo':
						$select="SELECT truncate(SUM(a.media)/COUNT(a.media),2) as media, uc.sexo FROM AVALIACAO a, USUARIO u, CONSUMIDOR uc, OPERADORA o WHERE a.idUsuario = u.idUsuario AND u.idUsuario = uc.idUsuario and o.nomeOperadora='$nome' GROUP BY uc.sexo;";
						$result=$dbh->query($select);
						$dados=$result->fetchAll();

							$sexo_regiao = new pData();
							$sexo_regiao->addPoints(array($dados[0][0],$dados[1][0]),"Média");
							$sexo_regiao->setAxisName(0,"MÉDIA");
							$sexo_regiao->addPoints(array($dados[0][1],$dados[1][1]),"SEXO");
							$sexo_regiao->setSerieDescription("SEXO","sexo");
							$sexo_regiao->setAbscissa("SEXO");
							$sexo_regiao->setAbscissaName("SEXO");

							/* Create the pChart object */
							$sexo_regiao_pic = new pImage(600,400,$sexo_regiao);

							/* Turn of Antialiasing */
							$sexo_regiao_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$sexo_regiao_pic->drawGradientArea(0,0,600,500,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$sexo_regiao_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$sexo_regiao_pic->drawText(300,0,"Média por sexo dos usuários",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$sexo_regiao_pic->setGraphArea(100,30,580,340);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$sexo_regiao_pic->drawScale($scaleSettings);

							/* Turn on shadow computing */ 
							$sexo_regiao_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$sexo_regiao_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$sexo_regiao_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$sexo_regiao_pic->autoOutput("sexo_regiao.png");
						break;
				}
			break;

			case 'Produtos':
				switch ($escolhido)
				{
					case 'Os 5 melhores produtos avaliados':
						$select="select max(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p,OPERADORA o where a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and a.idOperadora=o.idOperadora and o.nomeOperadora='$nome' group by nomeProduto order by media desc limit 0, 5;";
						$result=$dbh->query($select);
						$dados=$result->fetchAll();
							$prod_cinco_melhores = new pData();
							$prod_cinco_melhores->addPoints(array($dados[0][0],$dados[1][0],$dados[2][0],$dados[3][0],$dados[4][0]),"Média");
							$prod_cinco_melhores->setAxisName(0,"MÉDIA");
							$prod_cinco_melhores->addPoints(array($dados[0][1],$dados[1][1],$dados[2][1],$dados[3][1],$dados[4][1]),"Produtos");
							$prod_cinco_melhores->setSerieDescription("Produtos","unidades");
							$prod_cinco_melhores->setAbscissa("Produtos");
							$prod_cinco_melhores->setAbscissaName("PRODUTOS");

							/* Create the pChart object */
							$prod_cinco_melhores_pic = new pImage(700,380,$prod_cinco_melhores);

							/* Turn of Antialiasing */
							$prod_cinco_melhores_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$prod_cinco_melhores_pic->drawGradientArea(0,0,700,380,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$prod_cinco_melhores_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$prod_cinco_melhores_pic->drawText(300,0,"Os cinco produtos mais bem avaliados",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$prod_cinco_melhores_pic->setGraphArea(100,30,680,340);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$prod_cinco_melhores_pic->drawScale($scaleSettings);

							/* Turn on shadow computing */ 
							$prod_cinco_melhores_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$prod_cinco_melhores_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$prod_cinco_melhores_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$prod_cinco_melhores_pic->autoOutput("prod_cinco_melhores.png");
						break;

					case 'Os 5 piores produtos avaliados':
						$select="select min(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p,OPERADORA o where a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and a.idOperadora=o.idOperadora and o.nomeOperadora='$nome' group by nomeProduto order by media desc limit 0, 5;";
						$result=$dbh->query($select);
						$dados=$result->fetchAll();
							$prod_cinco_piores = new pData();
							$prod_cinco_piores->addPoints(array($dados[0][0],$dados[1][0],$dados[2][0],$dados[3][0],$dados[4][0]),"Média");
							$prod_cinco_piores->setAxisName(0,"MÉDIA");
							$prod_cinco_piores->addPoints(array($dados[0][1],$dados[1][1],$dados[2][1],$dados[3][1],$dados[4][1]),"Produtos");
							$prod_cinco_piores->setSerieDescription("Produtos","unidades");
							$prod_cinco_piores->setAbscissa("Produtos");
							$prod_cinco_piores->setAbscissaName("PRODUTOS");

							/* Create the pChart object */
							$prod_cinco_piores_pic = new pImage(700,380,$prod_cinco_piores);

							/* Turn of Antialiasing */
							$prod_cinco_piores_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$prod_cinco_piores_pic->drawGradientArea(0,0,700,380,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$prod_cinco_piores_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$prod_cinco_piores_pic->drawText(300,0,"Os cinco produtos menos bem avaliados",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$prod_cinco_piores_pic->setGraphArea(100,30,680,340);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$prod_cinco_piores_pic->drawScale($scaleSettings);

							/* Turn on shadow computing */ 
							$prod_cinco_piores_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$prod_cinco_piores_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$prod_cinco_piores_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$prod_cinco_piores_pic->autoOutput("prod_cinco_piores.png");
						break;

					case 'Questões que mais e menos aumentaram a nota do produto':
						echo "grafico";
						break;
				}
			break;
				
			case 'Serviços':
				switch ($escolhido)
				{
					case 'Os 5 melhores serviços avaliados':
						$select="select max(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s, OPERADORA o where a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and a.idOperadora=o.idOperadora and o.nomeOperadora='$nome' group by nomeServico order by media limit 0, 5;";
						$result=$dbh->query($select);
						$dados=$result->fetchAll();
							$serv_cinco_melhores = new pData();
							$serv_cinco_melhores->addPoints(array($dados[0][0],$dados[1][0],$dados[2][0],$dados[3][0],$dados[4][0]),"Média");
							$serv_cinco_melhores->setAxisName(0,"MÉDIA");
							$serv_cinco_melhores->addPoints(array($dados[0][1],$dados[1][1],$dados[2][1],$dados[3][1],$dados[4][1]),"Serviços");
							$serv_cinco_melhores->setSerieDescription("Serviços","unidades");
							$serv_cinco_melhores->setAbscissa("Serviços");
							$serv_cinco_melhores->setAbscissaName("SERVIÇOS");

							/* Create the pChart object */
							$serv_cinco_melhores_pic = new pImage(700,380,$serv_cinco_melhores);

							/* Turn of Antialiasing */
							$serv_cinco_melhores_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$serv_cinco_melhores_pic->drawGradientArea(0,0,700,380,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$serv_cinco_melhores_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$serv_cinco_melhores_pic->drawText(300,0,"Os cinco produtos menos bem avaliados",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$serv_cinco_melhores_pic->setGraphArea(100,30,680,340);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$serv_cinco_melhores_pic->drawScale($scaleSettings);

							/* Turn on shadow computing */ 
							$serv_cinco_melhores_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$serv_cinco_melhores_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$serv_cinco_melhores_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$serv_cinco_melhores_pic->autoOutput("serv_cinco_melhores.png");
						break;

					case 'Os 5 piores serviços avaliados':
						$select="select min(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s, OPERADORA o where a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and a.idOperadora=o.idOperadora and o.nomeOperadora='$nome' group by nomeServico order by media limit 0, 5;";
						$result=$dbh->query($select);
						$dados=$result->fetchAll();
							$serv_cinco_piores = new pData();
							$serv_cinco_piores->addPoints(array($dados[0][0],$dados[1][0],$dados[2][0],$dados[3][0],$dados[4][0]),"Média");
							$serv_cinco_piores->setAxisName(0,"MÉDIA");
							$serv_cinco_piores->addPoints(array($dados[0][1],$dados[1][1],$dados[2][1],$dados[3][1],$dados[4][1]),"Serviços");
							$serv_cinco_piores->setSerieDescription("Serviços","unidades");
							$serv_cinco_piores->setAbscissa("Serviços");
							$serv_cinco_piores->setAbscissaName("SERVIÇOS");

							/* Create the pChart object */
							$serv_cinco_piores_pic = new pImage(700,380,$serv_cinco_piores);

							/* Turn of Antialiasing */
							$serv_cinco_piores_pic->Antialias = FALSE;

							/* Add a border to the picture */
							$serv_cinco_piores_pic->drawGradientArea(0,0,700,380,DIRECTION_VERTICAL,array("StartR"=>219,"StartG"=>215,"StartB"=>215,"EndR"=>219,"EndG"=>215,"EndB"=>215));

							/* Set the default font */
							$serv_cinco_piores_pic->setFontProperties(array("FontName"=>"../pChart2.1.3/fonts/verdana.ttf","FontSize"=>9));
							$serv_cinco_piores_pic->drawText(300,0,"Os cinco produtos menos bem avaliados",array("FontSize"=>15,"Align"=>TEXT_ALIGN_TOPMIDDLE));

							/* Define the chart area */
							$serv_cinco_piores_pic->setGraphArea(100,30,680,340);

							/* Draw the scale */
							$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
							$serv_cinco_piores_pic->drawScale($scaleSettings);

							/* Turn on shadow computing */ 
							$serv_cinco_piores_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

							/* Draw the chart */
							$serv_cinco_piores_pic->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
							$settings = array("DisplayValues"=>TRUE,"Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0);
							$serv_cinco_piores_pic->drawBarChart($settings);

							/* Render the picture (choose the best way) */
							$serv_cinco_piores_pic->autoOutput("serv_cinco_piores.png");
						break;

					case 'Questões que mais e menos aumentaram a nota do serviço':
						echo "grafico";
						break;
				}
			break;
			
		}
	}
	else
	{
		switch ($tipo)
		{
			case 'Operadora':
				echo "<option>Quantidade por região</option>";
				echo "<option>Média por região</option>";
				echo "<option>Média de idade por região</option>";
				echo "<option>Média por sexo</option>";
				
				break;
			
			case 'Produtos':
				echo "<option>Os 5 melhores produtos avaliados</option>";
				echo "<option>Os 5 piores produtos avaliados</option>";
				echo "<option>Questões que mais e menos aumentaram a nota do produto</option>";
				
				break;
				
			case 'Serviços':
				echo "<option>Os 5 melhores serviços avaliados</option>";
				echo "<option>Os 5 piores serviços avaliados</option>";
				echo "<option>Questões que mais e menos aumentaram a nota do serviço</option>";
				
				break;
			
			//Maior e menor média de nota de questão de avaliacao
		}
	}
}

?>