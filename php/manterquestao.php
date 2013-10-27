<?php

//Open Database;
$dsn = 'mysql:dbname=sce;host=localhost';
$dbh = new PDO($dsn, 'core', 'core');
$dbh->exec("set names utf8");


// Verifica se a entrada é por método get
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
	
	if (isset($_GET['tipo']))
	{
		$tipo = $_GET['tipo'];

		switch ($tipo)
		{
			case 'Produto':
				$tipoQuestao = "PRODUTO";
				break;

			case 'Serviço':
				$tipoQuestao = "SERVICO";
				break;
		}

		$select = "select texto as questao from ESTRUTURA_QUESTAO where tipoQuestao='$tipoQuestao';";
		$results = $dbh->query($select);

		while ( $questao = $results->fetch())
		{
			echo "<option>" . $questao['questao'] . "</option>";
		}
	}
	elseif (isset($_GET['getquestao']))
	{
		$getquestao = $_GET['getquestao'];

		$select = "select texto as questao from ESTRUTURA_QUESTAO where texto='$getquestao';";
		$results = $dbh->query($select);

		while ( $questao = $results->fetch())
		{
			echo $questao['questao'];
		}
	}

}

// Verifica se a entrada é por método post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$ed_questao = $_POST['questao_descricao'];
	$questao = $_POST['questao_escolhida'];
	$tipo = $_POST['list_tipos'];


	/*
	$select = "select endereco,telefonePrincipal,telefoneOpcional from USUARIO where endereco='$endereco' and telefonePrincipal='$tel_princ' and telefoneOpcional='$tel_op' and email='$email';";

	$validate = $dbh->query($select);
	$results = $validate->rowCount();
	*/

	if ($ed_questao == "")
	{
		echo "erro_questao_vazio";
	}

	elseif ($ed_questao == $questao)
	{
		echo "erro_questao_igual";
	}

	else
	{
		$select = " select texto from ESTRUTURA_QUESTAO where tipoQuestao='$tipo' and texto='$questao' ";
		$result = $dbh->query($select);
		$count = $result->rowCount();
		if($count == 1)
		{
			$update = "update ESTRUTURA_QUESTAO set texto='$ed_questao' where texto='$questao' and tipoQuestao='$tipo';";
			$update_result = $dbh->query($update);
			echo "sucesso";
		}
		else
		{
			echo "erro_database";
		}
	}
}
