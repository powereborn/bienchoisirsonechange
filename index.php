<?php

session_start();

require_once 'urlParse.php';

$urlparse = new urlParse();

$_URL = array();
$controllerName = array();
$actionName = array();

$urlparse->getLoadDetails($controllerName, $actionName);

$linkFileController = 'Control/' . $controllerName . '.php';

if(file_exists($linkFileController))
{
    include $linkFileController;
    $Control = new $controllerName;
    $Function = $Control->$actionName();
}
else if(empty($controllerName))
{
    include 'Control/Universities.php';
    $Control = new Universities();
    $Function = $Control->searchMap();
}
else
{
    echo "Oups";
}


