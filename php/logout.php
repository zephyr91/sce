<?php

	session_start();
	session_destroy();
	$_SESSION = array();
	header('Refresh: 0; url=/');

?>