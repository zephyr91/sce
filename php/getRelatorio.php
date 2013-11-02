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
			echo $twig->render('getRelatorio.html', array('nome' => $dados[1]));
			
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