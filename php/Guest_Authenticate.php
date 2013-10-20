<?php

	$select_login = "select nomeUsuario,email,senha,tipoAcesso from USUARIO where email='$userid' and senha='$pass';";

	$results = $dbh->query($select_login);
	//var_dump($results);

	$auth_status = $results->rowCount();
	//var_dump($auth_status);

	// Array com os dados do usuário;
	$dados = $results->fetch();
	//var_dump($dados);

?>