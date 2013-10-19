<?php

require '../bootstrap.php';

session_start();

$mysqli = new mysqli('localhost', 'guest', 'guest', 'sce');


if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

	$tipo = utf8_encode($_GET['item']);
	$busca = $_GET['search'];

	switch ($tipo) {
		case "Operadora":
			$pesquisa = "Pesquisa de Operadoras";
			$tipo = "OPERADORA";
			$coluna = "nomeOperadora";
			$select = "select * from $tipo where $coluna='$busca';";
			break;

		case "Produtos":
			$pesquisa = "Pesquisa de Produtos";
			$tipo = "PRODUTOS";
			$coluna = "nomeProdutos";
			//$bus
			$select = "select * from $tipo where $coluna='$busca';";
			break;

		case "Serviço":
			$pesquisa = utf8_encode("Pesquisa de Serviços");		
			$tipo = "SERVICO";
			$coluna = "nomeServico";
			break;
	}



	$results = $mysqli->query($select);
	$dados = $results->fetch_row();

	/*
	    Criando formulario para edição;
	*/
	echo $twig->render('getSearch.html', array('nome' => $dados[1], 'endereco' => $dados[2],'tel_princ' => $dados[3], 'tel_op' => $dados[4], 'descricao' => utf8_encode($dados[5]), 'pesquisa' => $pesquisa));

}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{


}
?>