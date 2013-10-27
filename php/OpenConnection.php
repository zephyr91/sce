<?php

	$mysqli = new mysqli('localhost','guest','guest','sce');
	$dsn = 'mysql:dbname=sce;host=localhost';
	$dbh = new PDO($dsn, 'guest', 'guest');
	$dbh->exec("set names utf8");

?>
