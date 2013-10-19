<?php

require_once  __DIR__ . '/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem( __DIR__ . '/html');
$twig = new Twig_Environment($loader, array(
    'cache' =>  '/tmp/cache',
));
