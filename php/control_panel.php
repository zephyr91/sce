<?php

	//Open Database;
	require("php/OpenConnection.php");

	$email = $_SESSION['login'];
	
	if ($_SESSION['tipo_user'] == "fisico")
	{
	
		//obtençao de informaçoes do usuario fisico 
		$select_fisico = "select USUARIO.dataNascimento, USUARIO.email, USUARIO.unidadeFederativa, USUARIO.municipio, USUARIO.bairro, USUARIO.endereco, USUARIO.telefonePrincipal, USUARIO.telefoneOpcional, CONSUMIDOR.cpf, CONSUMIDOR.rg, CONSUMIDOR.sexo from USUARIO INNER JOIN CONSUMIDOR ON USUARIO.email ='$email' AND USUARIO.idUsuario = CONSUMIDOR.idUsuario;";


		$results_fisico = $dbh->query($select_fisico);
		//var_dump($results_fisico);


		// Array com os dados do usuário;
		$dados_fisico = $results_fisico->fetch();
		//var_dump($dados_fisico);
	
	} 
	
	else if ($_SESSION['tipo_user'] == "juridico")
	{
	
		//obtençao de informaçoes do usuario juridico
		$select_juridico = "select USUARIO.dataNascimento, USUARIO.email, USUARIO.unidadeFederativa, USUARIO.municipio, USUARIO.bairro, USUARIO.endereco, USUARIO.telefonePrincipal, USUARIO.telefoneOpcional, JURIDICO.cnpj from USUARIO INNER JOIN JURIDICO ON USUARIO.email='$email' AND USUARIO.idUsuario = JURIDICO.idUsuario;";
		
		
		$results_juridico = $dbh->query($select_juridico);
		//var_dump($results_juridico);


		// Array com os dados do usuário;
		$dados_juridico = $results_juridico->fetch();
		//var_dump($dados_juridico);
	
	}

?>