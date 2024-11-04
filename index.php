<?php

$action = $_GET['action'];
$controller = $_GET['controller'];

require "src/controllers/$controller.php";


$controllerObj = new $controller;

$controllerObj->$action();
