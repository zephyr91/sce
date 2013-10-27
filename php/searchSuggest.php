<?php

	//Open Database;
	$dsn = 'mysql:dbname=sce;host=localhost';
	$dbh = new PDO($dsn, 'guest', 'guest');
	$dbh->exec("set names utf8");

	if (isset($_GET['search']) && $_GET['search'] != '')
	{
		$item = utf8_encode($_GET['item']);
		
		//Add slashes to any quotes to avoid SQL problems.
		$search = addslashes($_GET['search']);


		switch($item)
		{

			case "Operadora":
				$select = "select nomeOperadora as suggest from OPERADORA where nomeOperadora like '%" . $search . "%' order by nomeOperadora;";
				break;

			case "Produtos":
				$select = "select concat(p.nomeProduto,' [', o.nomeOperadora,']') as suggest from OPERADORA o, PRODUTO p where p.nomeProduto like '%" . $search . "%' and o.idOperadora=p.idOperadora order by nomeProduto asc;";
				break;

			case "Serviços":
				$select = "select concat(s.nomeServico,' [', o.nomeOperadora,']') as suggest from OPERADORA o, SERVICO s where s.nomeServico like '%" . $search . "%' and o.idOperadora=s.idOperadora order by nomeServico asc;";
				break;

		}

		$suggest_query = $dbh->query($select);

		while($suggest = $suggest_query->fetch())
		{
			//Return each page title seperated by a newline.
			echo $suggest['suggest'] . "\n";
		}
	}

?>