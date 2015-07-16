<?php

class Controller {
	public $params = [];

	public function getParams() {
		return $this->params;
	}

	public function getParam( $key, $default = null ) {
		return isset($this->params[$key])
      ? $this->params[$key]
      : $default;
	}

	public function getDB() {
		include_once __DIR__ . '/../base/db.php';
		return DB::getInstance()->conn;
	}

	public function getModel( $model ) {
		$path = __DIR__ . "/../app/models/{$model}.php";

    if ( !file_exists($path) ) {
      throw new Exception("Model {$model} not found by path {$path}", 404);
    }

    include_once $path;

    $className = ucfirst($model);

    $model = new $className;
    $model->conn = $this->getDB();

    return $model;
	}

  public function render( $view, $params = [] ) {
    $path = __DIR__ . "/../app/views/{$view}";

    if ( !file_exists($path) ) {
      throw new Exception("View {$view} not found by path {$path}", 404);
    }

    ob_start();
    extract($params);
    include $path;
    $content = ob_get_contents();
    ob_end_clean();

    if ( 1 == $this->getParam('ajax') ) {
      echo $content;
    } else {
      include __DIR__ . '/../app/views/layout.phtml';
    }
  }
}