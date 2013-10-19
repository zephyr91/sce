<?php

	//Open Database;
	require("php/OpenConnection.php");
	
	$item = isset($_GET['search']);
	
	$select_servico = "select nomeServico from SERVICO where nomeServico='$item';";

	$results = $mysqli->query($select_servico);
	
	$num_result = $results->num_rows;

	//verifica se é produto ou serviço o item pesquisado
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
	1)devemos impedir o sistema de gerar avaliação pra algo que nao está no banco
	ao clicar no 'gerar avaliação', deve ser executado um select verificando se o item pesquisado está no banco (select em produto e serviço nos ids e num_rows = 1?).
	caso o item nao exista, exibir um alert em javascript informando o usuario para escolher algum item da lista e nao gerar a avaliaçao (if no botao?)
	
	2)após a verificaçao de existencia do item, verificar se é um produto ou serviço, isso pode ser feito pela propria funçao de select acima q possa setar se é um produto caso encontre nessa tabela ou serviço na outra
	dependendo de qual for o tipo do item, trazer as questoes inerentes a ele (select estrutura questao, ids 1 ao 5 pra produto por ex e 6 ao 10 pra serviço por ex)
	
	3)no botão de enviar avaliação, deve existir uma função que verifique se todas as questões foram preenchidas (input type do html que armazena as notas e posteriormente passa pro php nao pode ser null)
	semelhante ao "if" do botao de gerar avaliaçao, o if desse botao impedira o usuario de enviar a avaliaçao com um alert caso as questoes nao estejam preenchidas.
	finalmente, quando todas estiverem devidamente avaliadas, 
	é feito o(s) insert(s) -> (insert na avaliaçao + avaliaçao produto por exemplo e o insert das respostas (valores dos input types hidden),
	além de analisar o cupom do usuário (mas creio que aqui é um select na propria pagina de controle do usario q será feito posteriormente para verificar quantos cupoms ele possui))
	*/
	
?>





