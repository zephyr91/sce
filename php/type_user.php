<?php

	$select_login = "select  idUsuario from USUARIO where email='$userid' and senha='$pass';";

	$results = $dbh->query($select_login);

	$type_dados = $results->fetch();

	$tipo_user = "select idUsuario from CONSUMIDOR where idUsuario='$type_dados[0]'";

	$result_type = $dbh->query($tipo_user);

	$num_result_type = $result_type->rowCount();

	if ($num_result_type == 1)
	{
		$session_type = "fisico";
	}
	else
	{
		$session_type = "juridico";
	}

?>