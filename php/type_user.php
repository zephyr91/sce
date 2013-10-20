<?php

	$select_login = "select  idUsuario from USUARIO where email='$userid' and senha='$pass';";

	$results = $dbh->query($select_login);
	//var_dump($results);

	//$type = $results->num_rows;
	//var_dump($auth_status);

	// Array com os dados do usuário;
	$type_dados = $results->fetch();
	//var_dump($dados);


	$tipo_user = "select idUsuario from CONSUMIDOR where idUsuario='$type_dados[0]'";
	//$tipo_adm = "select tipoAcesso from USUARIO where email='$type_dados[1]'";

	$result_type = $dbh->query($tipo_user);
	//$result_adm = $mysqli->query($tipo_adm);

	$num_result_type = $result_type->rowCount();

	if ($num_result_type == 1)
	{
		$session_type = "fisico";
	}
	else                 //if ($num_result_type == 0 && $result_adm != 'A')
	{
		$session_type = "juridico";
	}
	/*
	else if ($result_adm == 'A')
	{
		$session_type = "administrador";
	}
	*/
?>