<?php


//User Fisico;
if ($_POST['typespessoa'] == "fisica")
{
	//Form variables;
	$nome=$_POST['tr_nome'];
	$senha=hash('sha256', $_POST['tr_senha']);
	$data=$_POST['tr_datanascimento'];
	$email=$_POST['tr_email'];
	$endereco=$_POST['tr_endereco'];
	$tel_princ=$_POST['tr_tel_princ'];
	$tel_op=$_POST['tr_tel_op'];
	$rg=$_POST['tr_rg'];
	$cpf=$_POST['tr_cpf'];
	$sexo=$_POST['tr_sexo'];

	//Formating date;
	$date_formated = date_create_from_format('d/m/Y', $data);
	$date_final = date_format($date_formated, 'Y/m/d');

	//Open Database as CORE;
	$mysqli = new mysqli('localhost','core','core','sce');

	//Checking if user exists;
	$validate_user = "select nomeUsuario,email,senha,tipoAcesso from USUARIO where email='$email';";
	$results = $mysqli->query($validate_user);
	$validate = $results->num_rows;

	//If yes, break processing and return to register.html;
	if ($validate == 1)
	{
		echo "<script>alert('Usuário já existente, por favor preencha novamente.');</script>";
		echo $twig->render('register.html');
		break;
	}
	
	//If no, register user and return to index.html;
	else
	{
		$insert_user = "insert into USUARIO values ('','$nome','$date_final','$email','$senha','$endereco','$tel_princ','U','$tel_op');";
		$resultado_user = $mysqli->query($insert_user);
		$insert_type_user = "insert into CONSUMIDOR values ('$cpf','$rg','$sexo',(select idUsuario from USUARIO where nomeUsuario='$nome'));";
		$resultado_type_user = $mysqli->query($insert_type_user);
	}

	//Close Connection;
	require("php/CloseConnection.php");

}

// User Juridico;
else
{
	//Form variables;
	$nome=$_POST['tr_nome'];
	$senha=hash('sha256', $_POST['tr_senha']);
	$data=$_POST['tr_datanascimento'];
	$email=$_POST['tr_email'];
	$endereco=$_POST['tr_endereco'];
	$tel_princ=$_POST['tr_tel_princ'];
	$tel_op=$_POST['tr_tel_op'];
	$cnpj=$_POST['tr_cnpj'];

	//Formating date;
	$date_formated = date_create_from_format('d/m/Y', $data);
	$date_final = date_format($date_formated, 'Y/m/d');

	//Open Database as CORE;
	$mysqli = new mysqli('localhost','core','core','sce');

	//Checking if user exists;
	$validate_user = "select nomeUsuario,email,senha,tipoAcesso from USUARIO where email='$email';";
	$results = $mysqli->query($validate_user);
	$validate = $results->num_rows;

	//If yes, break processing and return to register.html;
	if ($validate == 1)
	{
		echo "<script>alert('Usuário já existente, por favor preencha novamente.');</script>";
		echo $twig->render('register.html');
		break;
	}

	//If no, register user and return to index.html;
	else
	{
		//Insert User;
		$insert_user = "insert into USUARIO values ('','$nome','$date_final','$email','$senha','$endereco','$tel_princ','U','$tel_op');";
		$resultado_user = $mysqli->query($insert_user);
		//Insert User Juridico;
		$insert_type_user = "insert into JURIDICO values ('$cnpj',(select idUsuario from USUARIO where nomeUsuario='$nome'));";
		$resultado_type_user = $mysqli->query($insert_type_user);
	}

	//Close Connection;
	require("php/CloseConnection.php");

}

?>