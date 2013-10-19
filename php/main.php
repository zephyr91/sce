<?php

$module=(isset($_GET['module'])) ? $_GET['module'] : "home";

switch ($module)
{

    case "home":
		echo $twig->render('main.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user']));
		break;

    case "panel":
    	if ($_SESSION['tipo_user'] == "fisico" && $_SESSION['permission'] != "A")
		{
			require("php/control_panel.php");
			
			//Format Date;
			$date_formated = date_create_from_format('Y/m/d', $dados_juridico[0]);
			$date_final = date_format($date_formated, 'd/m/Y');
			
			echo $twig->render('control_panel.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'], 'dtnasc' => $dados_fisico[0], 'email' => $dados_fisico[1], 'endereco' => $dados_fisico[2], 'tel_princ' => $dados_fisico[3], 'tel_op' => $dados_fisico[4], 'cpf' => $dados_fisico[5], 'rg' => $dados_fisico[6], 'sexo' => $dados_fisico[7]));
		}
		elseif ($_SESSION['tipo_user'] == "juridico" && $_SESSION['permission'] != "A")
		{
			require("php/control_panel.php");
			
			//Format Date;
			$date_formated = date_create_from_format('Y/m/d', $dados_juridico[0]);
			$date_final = date_format($date_formated, 'd/m/Y');
			
			echo $twig->render('control_panel.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'], 'dtnasc' => $dados_juridico[0], 'email' => $dados_juridico[1], 'endereco' => $dados_juridico[2], 'tel_princ' => $dados_juridico[3], 'tel_op' => $dados_juridico[4], 'cnpj' => $dados_juridico[5]));
		}
		elseif ($_SESSION['permission'] == "A")
		{
			if (isset($_GET['adminpanel']))
			{
				switch ($_GET['adminpanel'])
				{
					case "manteroperadora":
						echo $twig->render('manteroperadora.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user']));
						break;
				
					case "manterproduto":
						echo $twig->render('manterproduto.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user']));
						break;
					
					case "manterservico":
						echo $twig->render('manterservico.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user']));
						break;
					
					case "manterusuario":
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
		}
		
		require("php/send_evaluation.php");
		echo $twig->render('send_evaluation.html', array('nome' => $_SESSION['nome'],'tipouser' => $_SESSION['tipo_user'], 'gerarFormulario' => $gerarFormulario, 'item' => $_GET['search'], 'questao1' => utf8_encode($resultado_questao[0]), 'questao2' => utf8_encode($resultado_questao[1]), 'questao3' => utf8_encode($resultado_questao[2]), 'questao4' => utf8_encode($resultado_questao[3]), 'questao5' => utf8_encode($resultado_questao[4])));
		break;
		
};

?>