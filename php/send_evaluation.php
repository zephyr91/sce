<?php

	//Open Database;
	require("php/OpenConnection.php");
	
	$item = isset($_GET['search']);
	
	$select_servico = "select nomeServico from SERVICO where nomeServico='$item';";

	$results = $mysqli->query($select_servico);
	
	$num_result = $results->num_rows;

	//verifica se � produto ou servi�o o item pesquisado
	if ($num_result == 1)
	{
		//$tipo_item = "servico";
		$select_questao = "select texto from ESTRUTURA_QUESTAO where tipoQuestao='SERVICO';";
		$result = $mysqli->query($select_questao);
		$resultado_questao = $result->fetch_row();
	}
	else
	{
		//$tipo_item = "produto";
		$select_questao = "select texto from ESTRUTURA_QUESTAO where tipoQuestao='PRODUTO';";
		$result = $mysqli->query($select_questao);
		$resultado_questao = $result->fetch_all();
		//while(list($resultado_questao) = $result->fetch_row());
		//var_dump($resultado_questao);

		
		//break;
	}
	
	

	//Close Database;
	require("php/CloseConnection.php");

	/*
	1)devemos impedir o sistema de gerar avalia��o pra algo que nao est� no banco
	ao clicar no 'gerar avalia��o', deve ser executado um select verificando se o item pesquisado est� no banco (select em produto e servi�o nos ids e num_rows = 1?).
	caso o item nao exista, exibir um alert em javascript informando o usuario para escolher algum item da lista e nao gerar a avalia�ao (if no botao?)
	
	2)ap�s a verifica�ao de existencia do item, verificar se � um produto ou servi�o, isso pode ser feito pela propria fun�ao de select acima q possa setar se � um produto caso encontre nessa tabela ou servi�o na outra
	dependendo de qual for o tipo do item, trazer as questoes inerentes a ele (select estrutura questao, ids 1 ao 5 pra produto por ex e 6 ao 10 pra servi�o por ex)
	
	3)no bot�o de enviar avalia��o, deve existir uma fun��o que verifique se todas as quest�es foram preenchidas (input type do html que armazena as notas e posteriormente passa pro php nao pode ser null)
	semelhante ao "if" do botao de gerar avalia�ao, o if desse botao impedira o usuario de enviar a avalia�ao com um alert caso as questoes nao estejam preenchidas.
	finalmente, quando todas estiverem devidamente avaliadas, 
	� feito o(s) insert(s) -> (insert na avalia�ao + avalia�ao produto por exemplo e o insert das respostas (valores dos input types hidden),
	al�m de analisar o cupom do usu�rio (mas creio que aqui � um select na propria pagina de controle do usario q ser� feito posteriormente para verificar quantos cupoms ele possui))
	*/
	
?>





