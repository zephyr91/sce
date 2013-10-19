<?php
		
	//Open Database;
	$mysqli = new mysqli('localhost','guest','guest','sce');

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
				$select = "select concat(p.nomeProduto,' (', o.nomeOperadora,')') as suggest from OPERADORA o, PRODUTO p where p.nomeProduto like '%" . $search . "%' and o.idOperadora=p.idOperadora order by nomeProduto asc;";
				break;

			case "Serviços":
				$select = "select concat(s.nomeServico,' (', o.nomeOperadora,')') as suggest from OPERADORA o, SERVICO s where s.nomeServico like '%" . $search . "%' and o.idOperadora=s.idOperadora order by nomeServico asc;";
				break;
			
		}

		$suggest_query = $mysqli->query($select);


		while($suggest = $suggest_query->fetch_array())
		{
			//Return each page title seperated by a newline.
			echo utf8_encode($suggest['suggest'] . "\n");
		}
	}

?>