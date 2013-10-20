<?php

	require __DIR__ . '/bootstrap.php';

	//Start Session
	session_start();

	//Get module, if its not set, then set as "home";
	$module=(isset($_GET['module'])) ? $_GET['module'] : "home";

	//Check if user is not logged in;
	if (! isset($_SESSION['login']))
	{
		//Check if was sent any login data;
		if( isset($_POST['acessar']))
		{
			//Password
			$pass=hash('sha256', $_POST['password']);
			//Email - Login
			$userid=$_POST['login'];
			
			//Open Database;
			require("php/OpenConnection.php");

			// Authenticate user;
			require("php/Guest_Authenticate.php");
			
			//Close Database;
			require("php/CloseConnection.php");

			//Check if login was successful;
			if ($auth_status == 1)
			{
				//Open Database;
				require("php/OpenConnection.php");
				//Get user type;
				require("php/type_user.php");
				//Close Database;
				require("php/CloseConnection.php");

				$_SESSION['datelogin']=date("M d Y H:i:s");
				$_SESSION['nome']="$dados[0]";
				$_SESSION['login']="$dados[1]";
				$_SESSION['permission']="$dados[3]";
				$_SESSION['tipo_user']="$session_type";
				header('Refresh: 0; url=/');
			}

			//If login was not successful, then it returns to "index.html";
			else
			{
				echo "<script>alert('Login ou senha incorretos! Tente Novamente.');</script>";
				echo $twig->render('index.html');
			}

		}

		//Check if form user_form was sent by $_POST;
		elseif ( isset($_POST['registrar_user']))
		{
			
			if($_POST['typespessoa'] == "")
			{
				echo "<script>alert('Dados incorretos no formulario, por favor preencha novamente.');</script>";
				echo $twig->render('register.html');
				break;
			}
			
			//If form is completely filled in, then proceed to create user on Database;
			else
			{
				require('php/user_register.php');
				echo "<script>alert('Usuário registrado com sucesso, você ja pode realizar login em sua conta  (lembrando que seu login é o seu email registrado) !');</script>";
				echo $twig->render('index.html');
			}

		}

		//Check which module is set on $_GET;
		else
		{

			switch ($module)
			{
			    case "home":
					echo $twig->render('index.html');
			        break;
			    case "register":
					echo $twig->render('register.html');
			        break;
			}

		}

	}

	else
	{
		require ('php/main.php');
	}

?>