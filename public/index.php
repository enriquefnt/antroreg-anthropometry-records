<?php

include __DIR__ . '/../includes/autoload.php';
 
$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');

$AntroRegWebsite = new \ClassPart\AntroRegWebsite();
$entryPoint = new \ClassGrl\EntryPoint($AntroRegWebsite);
$entryPoint->run($uri, $_SERVER['REQUEST_METHOD']);
