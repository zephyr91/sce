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

			$validate_aval = "select count(*) as existe from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s where a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico and a.idUsuario=$resultidusuario[0] and a.idOperadora=$idoperadora and aser.idServico=$iditem;";
			$result_validate = $dbh->query($validate_aval);
			$exist = $result_validate->fetch();

			if ($exist[0] == 1)
			{
				echo "erro_aval_existente";
				exit();
			}
		}
		else
		{
			$tipo_item = "produto";
			
			$validate_aval = "select count(*) as existe from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p where a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto and a.idUsuario=$resultidusuario[0] and a.idOperadora=$idoperadora and ap.idProduto=$iditem;";
			$result_validate = $dbh->query($validate_aval);
			$exist = $result_validate->fetch();

			if ($exist[0] == 1)
			{
				echo "erro_aval_existente";
				exit();
			}
		}
		
		
		if ($comentario != '')
		{
			//se tiver algum comentario, passar pro administrador e mandar mensagem pro usuario de q a avaliaçao sera auditada para dps ser enviada
			if ($tipo_item == "produto")
			{
				$insert_aval = "insert into AVALIACAO values ('','$comentario',5,$resultidusuario[0],$idoperadora);";
				$aval = $dbh->query($insert_aval);

				$insert_type_aval = "insert into AVALIACAO_PRODUTO values ((select a.idAvaliacao from AVALIACAO a, PRODUTO p, USUARIO u where a.idUsuario=$resultidusuario[0] and a.idOperadora=$idoperadora and p.idProduto=$iditem order by a.idAvaliacao desc limit 0, 1),(select idProduto from PRODUTO where nomeProduto='$nomeitem' and idOperadora=$idoperadora));";
				$aval_type = $dbh->query($insert_type_aval);
				
				//inserts de notas	
				$insert_nota1 = "insert into RESPOSTA values ('',$nota1,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao1'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota1 = $dbh->query($insert_nota1);
				$insert_nota2 = "insert into RESPOSTA values ('',$nota2,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao2'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota2 = $dbh->query($insert_nota2);
				$insert_nota3 = "insert into RESPOSTA values ('',$nota3,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao3'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota3 = $dbh->query($insert_nota3);
				$insert_nota4 = "insert into RESPOSTA values ('',$nota4,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao4'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota4 = $dbh->query($insert_nota4);
				$insert_nota5 = "insert into RESPOSTA values ('',$nota5,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao5'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota5 = $dbh->query($insert_nota5);

				echo "comment";
			
			}
			
			elseif ($tipo_item == "servico")
			{
				$insert_aval = "insert into AVALIACAO values ('','$comentario',5,$resultidusuario[0],$idoperadora);";
				$aval = $dbh->query($insert_aval);			
				$insert_type_aval = "insert into AVALIACAO_SERVICO values ((select a.idAvaliacao from AVALIACAO a, SERVICO s, USUARIO u where a.idUsuario=$resultidusuario[0] and a.idOperadora=$idoperadora and s.idServico=$iditem order by a.idAvaliacao desc limit 0, 1),(select idServico from SERVICO where nomeServico='$nomeitem' and idOperadora=$idoperadora));";
				$aval_type = $dbh->query($insert_type_aval);

				//inserts de notas
				$insert_nota1 = "insert into RESPOSTA values ('',$nota1,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao1'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota1 = $dbh->query($insert_nota1);
				$insert_nota2 = "insert into RESPOSTA values ('',$nota2,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao2'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota2 = $dbh->query($insert_nota2);
				$insert_nota3 = "insert into RESPOSTA values ('',$nota3,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao3'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota3 = $dbh->query($insert_nota3);
				$insert_nota4 = "insert into RESPOSTA values ('',$nota4,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao4'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota4 = $dbh->query($insert_nota4);
				$insert_nota5 = "insert into RESPOSTA values ('',$nota5,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao5'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota5 = $dbh->query($insert_nota5);
			
				echo "comment";
			}
		}
		else
		{
			if ($tipo_item == "produto")
			{
				$insert_aval = "insert into AVALIACAO values ('','',0,$resultidusuario[0],$idoperadora);";
				$aval = $dbh->query($insert_aval);

				$insert_type_aval = "insert into AVALIACAO_PRODUTO values ((select a.idAvaliacao from AVALIACAO a, PRODUTO p, USUARIO u where a.idUsuario=$resultidusuario[0] and a.idOperadora=$idoperadora and p.idProduto=$iditem order by a.idAvaliacao desc limit 0, 1),(select idProduto from PRODUTO where nomeProduto='$nomeitem' and idOperadora=$idoperadora));";
				$aval_type = $dbh->query($insert_type_aval);
				
				//inserts de notas	
				$insert_nota1 = "insert into RESPOSTA values ('',$nota1,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao1'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota1 = $dbh->query($insert_nota1);
				$insert_nota2 = "insert into RESPOSTA values ('',$nota2,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao2'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota2 = $dbh->query($insert_nota2);
				$insert_nota3 = "insert into RESPOSTA values ('',$nota3,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao3'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota3 = $dbh->query($insert_nota3);
				$insert_nota4 = "insert into RESPOSTA values ('',$nota4,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao4'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota4 = $dbh->query($insert_nota4);
				$insert_nota5 = "insert into RESPOSTA values ('',$nota5,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao5'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota5 = $dbh->query($insert_nota5);

				echo "sucesso";
			
			}
			
			elseif ($tipo_item == "servico")
			{
				$insert_aval = "insert into AVALIACAO values ('','',0,$resultidusuario[0],$idoperadora);";
				$aval = $dbh->query($insert_aval);			
				$insert_type_aval = "insert into AVALIACAO_SERVICO values ((select a.idAvaliacao from AVALIACAO a, SERVICO s, USUARIO u where a.idUsuario=$resultidusuario[0] and a.idOperadora=$idoperadora and s.idServico=$iditem order by a.idAvaliacao desc limit 0, 1),(select idServico from SERVICO where nomeServico='$nomeitem' and idOperadora=$idoperadora));";
				$aval_type = $dbh->query($insert_type_aval);

				//inserts de notas
				$insert_nota1 = "insert into RESPOSTA values ('',$nota1,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao1'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota1 = $dbh->query($insert_nota1);
				$insert_nota2 = "insert into RESPOSTA values ('',$nota2,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao2'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota2 = $dbh->query($insert_nota2);
				$insert_nota3 = "insert into RESPOSTA values ('',$nota3,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao3'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota3 = $dbh->query($insert_nota3);
				$insert_nota4 = "insert into RESPOSTA values ('',$nota4,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao4'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota4 = $dbh->query($insert_nota4);
				$insert_nota5 = "insert into RESPOSTA values ('',$nota5,$resultidusuario[0],(select idEstruturaQuestao from ESTRUTURA_QUESTAO where texto='$questao5'),(select idAvaliacao from AVALIACAO where idUsuario=$resultidusuario[0] order by idAvaliacao desc limit 0, 1));";
				$aval_nota5 = $dbh->query($insert_nota5);
			
				echo "sucesso";
			}
		}
	}
	
	
?>