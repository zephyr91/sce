<?php

$cache = $_SERVER['DOCUMENT_ROOT'] . '/cache_twig';
require_once  __DIR__ . '/vendor/autoload.php';
require  __DIR__ . '/pChart2.1.3/class/pDraw.class.php';
require  __DIR__ . '/pChart2.1.3/class/pImage.class.php';
require  __DIR__ . '/pChart2.1.3/class/pData.class.php';

$loader = new Twig_Loader_Filesystem( __DIR__ . '/html');
$twig = new Twig_Environment($loader, array(
    'cache' =>  $cache,
));
