<?php

require '../bootstrap.php';

session_start();

$dsn = 'mysql:dbname=sce;host=localhost';
$dbh = new PDO($dsn, 'guest', 'guest');
$dbh->exec("set names utf8");

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

	$tipo=$_GET['tipo'];
	$escolhido=$_GET['escolhido'];

	if (isset($escolhido))
	{
		switch ($tipo)
		{
			case 'Operadora':
				switch ($escolhido)
				{
					case 'melhor x por y':
						echo "grafico";
						break; 
					case 'melhor x por z':
						echo "grafico";
						break;
					case 'melhor x por d':
						echo "grafico";
						break;
					case 'melhor e por y':
						echo "grafico";
						break;
				}
			break;

			case 'Produtos':
				switch ($escolhido)
				{
					case 'melhor x por y':
						echo "grafico";
						break; 
					case 'melhor 2 por z':
						echo "grafico";
						break;
					case 'melhor x por 3':
						echo "grafico";
						break;
					case 'melhor 4 por y':
						echo "grafico";
						break;
				}
			break;
				
			case 'Serviços':
				switch ($escolhido)
				{
					case 'melhor x por s':
						echo "grafico";
						break; 
					case 'melhor d por y':
						echo "grafico";
						break;
					case 'melhor x por 2':
						echo "grafico";
						break;
					case 'melhor x por b':
						echo "grafico";
						break;
				}
			break;
			
		}
	}
	else
	{
		switch ($tipo)
		{
			case 'Operadora':
				echo "<option>melhor x por y</option>";
				echo "<option>melhor x por z</option>";
				echo "<option>melhor x por d</option>";
				echo "<option>melhor e por y</option>";
				
				break;
			
			case 'Produtos':
				echo "<option>melhor x por y</option>";
				echo "<option>melhor 2 por y</option>";
				echo "<option>melhor x por 3</option>";
				echo "<option>melhor 4 por y</option>";
				
				break;
				
			case 'Serviços':
				echo "<option>melhor x por s</option>";
				echo "<option>melhor d por y</option>";
				echo "<option>melhor x por 2</option>";
				echo "<option>melhor x por b</option>";
				
				break;
			
		}
	}
}

?>