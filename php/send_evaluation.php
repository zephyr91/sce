<?php

	//Open Database;
	require("php/OpenConnection.php");
	
	$item = isset($_GET['search']);
	
	$select_servico = "select nomeServico from SERVICO where nomeServico='$item';";

	$results = $dbh->query($select_servico);
	
	$num_result = $results->rowCount();


	//verifica se щ produto ou serviчo o item pesquisado
	if ($num_result == 1)
	{
		$tipo_item = "servico";
		$select_questao = "select texto from ESTRUTURA_QUESTAO where tipoQuestao='SERVICO';";
		$result = $dbh->query($select_questao);
		

		$questoes = [];
		foreach($result->fetchAll() as $questao)
		{
			$questoes[] = $questao;
		}

	}
	else
	{
		$tipo_item = "produto";
		$select_questao = "select texto from ESTRUTURA_QUESTAO where tipoQuestao='PRODUTO';";
		$result = $dbh->query($select_questao);
	
		
		$questoes = [];
		foreach($result->fetchAll() as $questao)
		{
			$questoes[] = $questao;
		}
			//var_dump($questoes);
			//break;
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$comentario = $_POST['a_comentario'];
		//$idusuario = "select idUsuario where email=$_SESSION['login']";
		//$idoperadora = "select idOperadora";

		if ($tipo_item = "produto")
		{
    	//$endereco=$_POST['ed_endereco'];
    	//$tel_princ=$_POST['ed_tel_princ'];
    	//$tel_op=$_POST['ed_tel_op'];

    	$insert_aval = "insert into AVALIACAO values ('',);";

    	$validate = $dbh->query($insert);
    	$results = $validate->rowCount();

    	}
    	elseif ($tipo_item = "servico")
    	{




    	}
 
	}
	
	

	//Close Database;
	require("php/CloseConnection.php");

	/*
	1)devemos impedir o sistema de gerar avaliaчуo pra algo que nao estс no banco
	ao clicar no 'gerar avaliaчуo', deve ser executado um select verificando se o item pesquisado estс no banco (select em produto e serviчo nos ids e num_rows = 1?).
	caso o item nao exista, exibir um alert em javascript informando o usuario para escolher algum item da lista e nao gerar a avaliaчao (if no botao?)
	
	2)apѓs a verificaчao de existencia do item, verificar se щ um produto ou serviчo, isso pode ser feito pela propria funчao de select acima q possa setar se щ um produto caso encontre nessa tabela ou serviчo na outra
	dependendo de qual for o tipo do item, trazer as questoes inerentes a ele (select estrutura questao, ids 1 ao 5 pra produto por ex e 6 ao 10 pra serviчo por ex)
	
	3)no botуo de enviar avaliaчуo, deve existir uma funчуo que verifique se todas as questѕes foram preenchidas (input type do html que armazena as notas e posteriormente passa pro php nao pode ser null)
	semelhante ao "if" do botao de gerar avaliaчao, o if desse botao impedira o usuario de enviar a avaliaчao com um alert caso as questoes nao estejam preenchidas.
	finalmente, quando todas estiverem devidamente avaliadas, 
	щ feito o(s) insert(s) -> (insert na avaliaчao + avaliaчao produto por exemplo e o insert das respostas (valores dos input types hidden),
	alщm de analisar o cupom do usuсrio (mas creio que aqui щ um select na propria pagina de controle do usario q serс feito posteriormente para verificar quantos cupoms ele possui))
	*/
	
?>