<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

spl_autoload_register(function ($className) {
  require "src/" . str_replace('\\', '/', $className) . ".php";
});

$router = new Framework\Router();

$router->add("/home/index", [
  "controller" => "home",
  "action" => "index"
]);

$router->add("/products", [
  "controller" => "products",
  "action" => "index"
]);

$router->add("/", [
  "controller" => "home",
  "action" => "index"
]);

$params = $router->match($path);

if (!$params) {
  exit("No route matched");
}

$action = $params['action'];
$controller = "App\Controllers\\" . ucwords($params['controller']);


$controllerObj = new $controller;

$controllerObj->$action();
