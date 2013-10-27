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

/*
Validando os dados do usuário;
*/
$endereco=$_POST['ed_endereco'];
$tel_princ=$_POST['ed_tel_princ'];
$tel_op=$_POST['ed_tel_op'];

$select = "select endereco,telefonePrincipal,telefoneOpcional from USUARIO where endereco='$endereco' and telefonePrincipal='$tel_princ' and telefoneOpcional='$tel_op' and email='$email';";

$validate = $dbh->query($select);
$results = $validate->rowCount();

if ($results != 0)
{
echo "erro";
}

else
{
$update_user = "UPDATE USUARIO SET endereco='$endereco', telefonePrincipal='$tel_princ', telefoneOpcional='$tel_op' WHERE email='$email';";
$resultado_update = $dbh->query($update_user);
echo "sucesso";
}
}
