<?php

require '../bootstrap.php';

session_start();

$dsn = 'mysql:dbname=sce;host=localhost';
$dbh = new PDO($dsn, 'guest', 'guest');


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
			break;

		case "Produtos":
			$pesquisa = "Pesquisa de Produtos";
			$tipo = "PRODUTO";
			$coluna = "nomeProduto";
			$busca_explode = explode(" (", $busca);
			$operadora_explode = explode(")", $busca_explode[1]);
			$select = "select * from $tipo t, OPERADORA o where $coluna='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and t.idOperadora = o.IdOperadora;";
			break;

		case "Serviços":
			$pesquisa = "Pesquisa de Serviços";
			$tipo = "SERVICO";
			$coluna = "nomeServico";
			$busca_explode = explode(" (", $busca);
			$operadora_explode = explode(")", $busca_explode[1]);
			$select = "select * from $tipo t, OPERADORA o where $coluna='$busca_explode[0]' and o.nomeOperadora='$operadora_explode[0]' and t.idOperadora = o.IdOperadora;";
			break;
	}

	$results = $dbh->query($select);
	$dados = $results->fetch();

	/*
	    Criando formulario para edição;
	*/
	echo $twig->render('getSearch.html', array('nome' => $dados[1], 'endereco' => $dados[2],'tel_princ' => $dados[3], 'tel_op' => $dados[4], 'descricao' => utf8_encode($dados[5]), 'pesquisa' => $pesquisa));

}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{


}
?>