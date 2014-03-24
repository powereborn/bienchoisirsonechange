<?php

$session_expiration = time() + 3600 * 24 * 2; // +2 days
session_set_cookie_params($session_expiration);
session_start();

require_once 'utils/urlParse.php';

$urlparse = new urlParse();

$_URL = array();
$controllerName = array();
$actionName = array();

$urlparse->getLoadDetails($controllerName, $actionName);

$linkFileController = 'Control/' . $controllerName . '.php';

if($controllerName != "ajax")
    include 'View/header.phtml';

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

if($controllerName != "ajax")
    include 'View/bottom.phtml';
