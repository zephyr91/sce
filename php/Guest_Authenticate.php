<?php

	$select_login = "select nomeUsuario,email,senha,tipoAcesso from USUARIO where email='$userid' and senha='$pass';";

	$results = $mysqli->query($select_login);
	//var_dump($results);

	$auth_status = $results->num_rows;
	//var_dump($auth_status);

	// Array com os dados do usuário;
	$dados = $results->fetch_row();
	//var_dump($dados);

?>