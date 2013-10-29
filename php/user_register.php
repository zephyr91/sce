<?php


//User Fisico;
if ($_POST['typespessoa'] == "fisica")
{
	//Form variables;
	$nome=$_POST['tr_nome'];
	$senha=hash('sha256', $_POST['tr_senha']);
	$data=$_POST['tr_datanascimento'];
	$email=$_POST['tr_email'];
	$uf=$_POST['tr_uf'];
	$municipio=$_POST['tr_municipio'];
	$bairro=$_POST['tr_bairro'];
	$endereco=$_POST['tr_endereco'];
	$tel_princ=preg_replace("/[^0-9]/", "",$_POST['tr_tel_princ']);
	$tel_op=preg_replace("/[^0-9]/", "",$_POST['tr_tel_op']);
	$rg= preg_replace("/[^0-9X]/", "",$_POST['tr_rg']);
	$cpf=preg_replace("/[^0-9]/", "",$_POST['tr_cpf']);
	$sexo=$_POST['tr_sexo'];

	//Formating date;
	$date_formated = date_create_from_format('d/m/Y', $data);
	$date_final = date_format($date_formated, 'Y/m/d');

	//Open Database as CORE;
	$dsn = 'mysql:dbname=sce;host=localhost';
	$dbh = new PDO($dsn, 'core', 'core');
	$dbh->exec("set names utf8");

	//Checking if user exists;
	$validate_user = "select nomeUsuario,email,senha,tipoAcesso from USUARIO where email='$email';";
	$results = $dbh->query($validate_user);
	$validate = $results->rowCount();

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
		$insert_user = "insert into USUARIO values ('','$nome','$date_final','$email','$senha','$uf','$municipio','$bairro','$endereco','$tel_princ','U','$tel_op');";
		$resultado_user = $dbh->query($insert_user);
		$insert_type_user = "insert into CONSUMIDOR values ('$cpf','$rg','$sexo',(select idUsuario from USUARIO where nomeUsuario='$nome'));";
		$resultado_type_user = $dbh->query($insert_type_user);
	}

}

// User Juridico;
else
{
	//Form variables;
	$nome=$_POST['tr_nome'];
	$senha=hash('sha256', $_POST['tr_senha']);
	$data=$_POST['tr_datanascimento'];
	$email=$_POST['tr_email'];
	$uf=$_POST['tr_uf'];
	$municipio=$_POST['tr_municipio'];
	$bairro=$_POST['tr_bairro'];
	$endereco=$_POST['tr_endereco'];
	$tel_princ=$_POST['tr_tel_princ'];
	$tel_op=$_POST['tr_tel_op'];
	$cnpj=$_POST['tr_cnpj'];

	//Formating date;
	$date_formated = date_create_from_format('d/m/Y', $data);
	$date_final = date_format($date_formated, 'Y/m/d');

	//Open Database as CORE;
	$dsn = 'mysql:dbname=sce;host=localhost';
	$dbh = new PDO($dsn, 'core', 'core');
	$dbh->exec("set names utf8");

	//Checking if user exists;
	$validate_user = "select nomeUsuario,email,senha,tipoAcesso from USUARIO where email='$email';";
	$results = $dbh->query($validate_user);
	$validate = $results->rowCount();

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
		$insert_user = "insert into USUARIO values ('','$nome','$date_final','$email','$senha','$uf','$municipio','$bairro','$endereco','$tel_princ','U','$tel_op');";
		$resultado_user = $dbh->query($insert_user);
		//Insert User Juridico;
		$insert_type_user = "insert into JURIDICO values ('$cnpj',(select idUsuario from USUARIO where nomeUsuario='$nome'));";
		$resultado_type_user = $dbh->query($insert_type_user);
	}

}

?>