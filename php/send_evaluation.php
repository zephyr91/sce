<?php


	//Open Database;
	$dsn = 'mysql:dbname=sce;host=localhost';
	$dbh = new PDO($dsn, 'core', 'core');
	$dbh->exec("set names utf8");
	session_start();
	$email = $_SESSION['login'];
	$idusuario = "select idUsuario from USUARIO where email='$email'";
	$queryidusuario = $dbh->query($idusuario);
	$resultidusuario = $queryidusuario->fetch();
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		
		// Adicionei para parar o erro de variavel não existente.
		$num_result =0;

		if (isset($_GET['search']))
		{
			$item = $_GET['search'];
			$item_explode = explode(" [", $item);
			$operadora_explode = explode("]", $item_explode[1]);
			$email = $_SESSION['login'];
			$getidoperadora = "select idOperadora from OPERADORA where nomeOperadora='$operadora_explode[0]'";
			$querygetidoperadora = $dbh->query($getidoperadora);
			$resultgetidoperadora = $querygetidoperadora->fetch();
		
			$select_servico = "select nomeServico from SERVICO where nomeServico='$item_explode[0]';";

			$results = $dbh->query($select_servico);
		
			$num_result = $results->rowCount();
			
		}
	
		//verifica se é produto ou serviço item pesquisado
		//switch 
		
		if ($num_result >= 1)
		{
			$tipo_item = "servico";
			$select_questao = "select texto from ESTRUTURA_QUESTAO where tipoQuestao='SERVICO';";
			$result = $dbh->query($select_questao);
			$select_idservico = "select idServico from SERVICO where nomeServico='$item_explode[0]' and idOperadora='$resultgetidoperadora[0]'";
			$query_idservico = $dbh->query($select_idservico);
			$resultiditem = $query_idservico->fetch();
	

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
			$select_idproduto = "select idProduto from PRODUTO where nomeProduto='$item_explode[0]' and idOperadora='$resultgetidoperadora[0]'";
			$query_idproduto = $dbh -> query($select_idproduto);
			$resultiditem = $query_idproduto->fetch();
		
			
			$questoes = [];
			foreach($result->fetchAll() as $questao)
			{
				$questoes[] = $questao;
			}
		}
	
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$comentario = $_POST['a_comentario'];
		$idoperadora=$_POST['a_idoperadora'];
		$nomeitem=$_POST['a_nomeitem'];
		$iditem=$_POST['a_iditem'];
		$nota1=$_POST['nota1'];
		$nota2=$_POST['nota2'];
		$nota3=$_POST['nota3'];
		$nota4=$_POST['nota4'];
		$nota5=$_POST['nota5'];
		$questao1=$_POST['q1'];
		$questao2=$_POST['q2'];
		$questao3=$_POST['q3'];
		$questao4=$_POST['q4'];
		$questao5=$_POST['q5'];
		
		$select_servico = "select nomeServico from SERVICO where nomeServico='$nomeitem' and idOperadora='$idoperadora'";
		$results = $dbh->query($select_servico);
		$num_result = $results->rowCount();
		
		if ($num_result == 1)
		{
			$tipo_item = "servico";
		}
		else
		{
			$tipo_item = "produto";
		}
		
		
		if ($comentario != '')
		{
			//se tiver algum comentario, passar pro administrador e mandar mensagem pro usuario de q a avaliaçao sera auditada para dps ser enviada
		}
		
		else
		{
			if ($tipo_item == "produto")
			{
				$insert_aval = "insert into AVALIACAO values ('','','0','$resultidusuario[0]','$idoperadora');";
				$validate_aval = $dbh->query($insert_aval);			
				//como pegar o idAvaliacao pro insert abaixo se o mesmo usuario pode ter mais de uma avaliaçao da mesma operadora? o select pode trazer mais de um resultado :(
				$insert_type_aval = "insert into AVALIACAO_PRODUTO values ((select AVALIACAO.idAvaliacao from AVALIACAO INNER JOIN PRODUTO on AVALIACAO.idUsuario='$resultidusuario[0]' and AVALIACAO.idOperadora='$idoperadora' and PRODUTO.idProduto='$iditem'),(select idProduto from PRODUTO where nomeProduto='$nomeitem' and idOperadora='$idoperadora'));";
				$validate_type = $dbh->query($insert_type_aval);
				
				//inserts de notas	
				$insert_nota1 = "insert into RESPOSTA values ('$nota1',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao1'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota1 = $dbh->query($insert_nota1);
				$insert_nota2 = "insert into RESPOSTA values ('$nota2',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao2'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota2 = $dbh->query($insert_nota2);
				$insert_nota3 = "insert into RESPOSTA values ('$nota3',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao3'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota3 = $dbh->query($insert_nota3);
				$insert_nota4 = "insert into RESPOSTA values ('$nota4',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao4'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota4 = $dbh->query($insert_nota4);
				$insert_nota5 = "insert into RESPOSTA values ('$nota5',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao5'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota5 = $dbh->query($insert_nota5);
			
			}
			
			elseif ($tipo_item == "servico")
			{
				$insert_aval = "insert into AVALIACAO values ('','','0','$resultidusuario[0]','$idoperadora');";
				$validate_aval = $dbh->query($insert_aval);			
				$insert_type_aval = "insert into AVALIACAO_SERVICO values ((select AVALIACAO.idAvaliacao from AVALIACAO INNER JOIN SERVICO on AVALIACAO.idUsuario='$resultidusuario[0]' and AVALIACAO.idOperadora='$idoperadora' and SERVICO.idServico='$iditem'),(select idServico from SERVICO where nomeServico='$nomeitem' and idOperadora='$idoperadora'));";
				$validate_type = $dbh->query($insert_type_aval);

				//inserts de notas
				$insert_nota1 = "insert into RESPOSTA values ('$nota1',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao1'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota1 = $dbh->query($insert_nota1);
				$insert_nota2 = "insert into RESPOSTA values ('$nota2',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao2'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota2 = $dbh->query($insert_nota2);
				$insert_nota3 = "insert into RESPOSTA values ('$nota3',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao3'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota3 = $dbh->query($insert_nota3);
				$insert_nota4 = "insert into RESPOSTA values ('$nota4',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao4'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota4 = $dbh->query($insert_nota4);
				$insert_nota5 = "insert into RESPOSTA values ('$nota5',$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao5'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0]));";
				$validatenota5 = $dbh->query($insert_nota5);
			
			
			}
		}
	}
	
	
	/*
	1)devemos impedir o sistema de gerar avalia?o pra algo que nao est?no banco
	ao clicar no 'gerar avalia?o', deve ser executado um select verificando se o item pesquisado est?no banco (select em produto e servi? nos ids e num_rows = 1?).
	caso o item nao exista, exibir um alert em javascript informando o usuario para escolher algum item da lista e nao gerar a avalia?o (if no botao?)
	
	2)ap? a verifica?o de existencia do item, verificar se ?um produto ou servi?, isso pode ser feito pela propria fun?o de select acima q possa setar se ?um produto caso encontre nessa tabela ou servi? na outra
	dependendo de qual for o tipo do item, trazer as questoes inerentes a ele (select estrutura questao, ids 1 ao 5 pra produto por ex e 6 ao 10 pra servi? por ex)
	
	3)no bot? de enviar avalia?o, deve existir uma fun?o que verifique se todas as quest?es foram preenchidas (input type do html que armazena as notas e posteriormente passa pro php nao pode ser null)
	semelhante ao "if" do botao de gerar avalia?o, o if desse botao impedira o usuario de enviar a avalia?o com um alert caso as questoes nao estejam preenchidas.
	finalmente, quando todas estiverem devidamente avaliadas, 
	?feito o(s) insert(s) -> (insert na avalia?o + avalia?o produto por exemplo e o insert das respostas (valores dos input types hidden),
	al? de analisar o cupom do usu?io (mas creio que aqui ?um select na propria pagina de controle do usario q ser?feito posteriormente para verificar quantos cupoms ele possui))
	*/
	
?>