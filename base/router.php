<?php

class Router {
  private static $defaultController = 'index';
  private static $defaultAction = 'index';

  public static function start() {
    $urlParams = self::parseUrl();

    $controller = $urlParams[0];
    $action = $urlParams[1];

    $params = [];
    for ( $i = 3; $i < count($urlParams); $i+=2 ) { 
      $params[$urlParams[$i-1]] = $urlParams[$i];
    }

    foreach ( $_REQUEST as $key => $value ) {
      $params[$key] = $value;
    }

    $html = self::initApp($controller, $action, $params);

    echo $html;
  }

  private static function parseUrl() {
    $internalUrl = trim(
      substr(
        $_SERVER['REQUEST_URI'],
        0,
        (false !== strpos($_SERVER['REQUEST_URI'], '?'))
          ? strpos($_SERVER['REQUEST_URI'], '?')
          : strlen($_SERVER['REQUEST_URI'])
      ),
      dirname($_SERVER['SCRIPT_NAME'])
    );

    $urlParams = [];
    foreach ( explode('/', $internalUrl) as $value ) {
      if ( $value ) {
        $urlParams[] = $value;
      }     
    }

    // Set defaulr controller - index
    if ( !isset( $urlParams[0] ) ) {
      $urlParams[0] = self::$defaultController;
    }

    // Set defaulr action - index
    if ( !isset( $urlParams[1] ) ) {
      $urlParams[1] = self::$defaultAction;
    }

    return $urlParams;
  }

  private static function initApp( $controller = null, $action = null, $params = [] ) {
    $controllerPath = __DIR__ . "/../app/controllers/{$controller}.php";

    if ( !file_exists($controllerPath) ) {
      throw new Exception("Controller {$controller} not found by path {$controllerPath}", 404);
    }

    include_once __DIR__ . '/controller.php';
    include_once $controllerPath;

    $className = ucfirst($controller) . "Controller";
    $methodName = "{$action}Action";

    $app = new $className;
    if ( !method_exists( $app, $methodName ) ) {
      throw new Exception("Action {$className}::{$methodName} not found at {$controllerPath}", 404);
    }

    $app->params = $params;

    return $app->{$methodName}();
  }
}
