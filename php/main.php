<?php

$module=(isset($_GET['module'])) ? $_GET['module'] : "home";

switch ($module)
{

    case "home":
		echo $twig->render('main.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'], 'permission' => $_SESSION['permission']));
		break;

    case "panel":
    	if ($_SESSION['tipo_user'] == "fisico" && $_SESSION['permission'] != "A")
		{
			require("php/control_panel.php");
			
			//Format Date;
			$date_formated = date_create_from_format('d/m/Y', $dados_fisico[0]);
			$date_final = date_format($date_formated, 'd/m/Y');
			
			echo $twig->render('control_panel.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'], 'dtnasc' => $dados_fisico[0], 'email' => $dados_fisico[1], 'uf' => $dados_fisico[2], 'municipio' => $dados_fisico[3], 'bairro' => $dados_fisico[4], 'endereco' => $dados_fisico[5], 'tel_princ' => $dados_fisico[6], 'tel_op' => $dados_fisico[7], 'cpf' => $dados_fisico[8], 'rg' => $dados_fisico[9], 'sexo' => $dados_fisico[10]));
		}
		elseif ($_SESSION['tipo_user'] == "juridico" && $_SESSION['permission'] != "A")
		{
			require("php/control_panel.php");
			
			//Format Date;
			$date_formated = date_create_from_format('Y/m/d', $dados_juridico[0]);
			$date_final = date_format($date_formated, 'd/m/Y');
			
			echo $twig->render('control_panel.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'], 'dtnasc' => $dados_juridico[0], 'email' => $dados_juridico[1], 'uf' => $dados_juridico[2], 'municipio' => $dados_juridico[3], 'bairro' => $dados_juridico[4], 'endereco' => $dados_juridico[5], 'tel_princ' => $dados_juridico[6], 'tel_op' => $dados_juridico[7], 'cnpj' => $dados_juridico[8]));
		}
		elseif ($_SESSION['permission'] == "A")
		{
			if (isset($_GET['adminpanel']))
			{
				switch ($_GET['adminpanel'])
				{
					case "manteroperadora":
						echo $twig->render('manteroperadora.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'],'permission' => $_SESSION['permission']));
						break;
				
					case "manterproduto":
						echo $twig->render('manterproduto.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'],'permission' => $_SESSION['permission']));
						break;
					
					case "manterservico":
						echo $twig->render('manterservico.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'],'permission' => $_SESSION['permission']));
						break;
					
					case "manterusuario":
						break;

					case "manterquestao":
						echo $twig->render('manterquestao.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'],'permission' => $_SESSION['permission']));
						break;
				}
			}
			else
			{
				require("php/control_panel.php");
				echo $twig->render('control_panel.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'],'permission' => $_SESSION['permission']));
			}
		}
		break;

	case "sendeval":
		
		$gerarFormulario = false;
		
		if (isset($_GET['search']))
		{
			$gerarFormulario = true;
			$item = $_GET['search'];
			require("php/send_evaluation.php");
			
			//echo $twig->render('send_evaluation.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'], 'gerarFormulario' => $gerarFormulario, 'item' => $item, 'questao1' => $questoes[0][0], 'questao2' => $questoes[1][0], 'questao3' => $questoes[2][0], 'questao4' => $questoes[3][0], 'questao5' => $questoes[4][0]));
			echo $twig->render('send_evaluation.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'], 'gerarFormulario' => $gerarFormulario, 'item' => $item, 'questao1' => $questoes[0][0], 'questao2' => $questoes[1][0], 'questao3' => $questoes[2][0], 'questao4' => $questoes[3][0], 'questao5' => $questoes[4][0], 'nomeit' => $item_explode[0], 'idop' => $resultgetidoperadora[0], 'idit' => $resultiditem[0]));
		}
		//Adicionei para parar o erro de variavel nao existente antes de gerar o formulario.
		else
		{
			$item="";
			echo $twig->render('send_evaluation.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'], 'gerarFormulario' => $gerarFormulario));
		}
		
		
		break;
		
};

?>