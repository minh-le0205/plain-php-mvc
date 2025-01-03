<?php

namespace Framework;

class Router
{
  private array $routes = [];

  public function add(string $path, array $params = []): void
  {
    $this->routes[] = [
      "path" => $path,
      "params" => $params,
    ];
  }

  public function match(string $path)
  {
    $path = urldecode($path);

    $path = trim($path, "/");

    foreach ($this->routes as $route) {
      $pattern = $this->getPatternFromRoutePath($route['path']);

      if (preg_match($pattern, $path, $matches)) {
        $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);

        $params = array_merge($matches, $route['params']);

        return $params;
      }
    }


    return false;
  }

  private function getPatternFromRoutePath(string $routePath): string
  {
    //Demo pattern : "#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#"


    $routePath = trim($routePath, "/");
    $segments = explode("/", $routePath);

    $segments = array_map(function (string $segment): string {

      if (preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches)) {
        return "(?<" . $matches[1] . ">[^/]*)";
      }

      if (preg_match("#^\{([a-z][a-z0-9]*):(.+)\}$#", $segment, $matches)) {
        return "(?<" . $matches[1] . ">" . $matches[2] . ")";
      }


      return $segment;
    }, $segments);

    $pattern = "#^" . implode("/", $segments) . "$#iu";

    return $pattern;
  }
}
