<?php

class Config {
	private static $params = [];

	public static function init() {
		self::$params = self::$params ?: include_once __DIR__ . '/../app/config/base.php';
	}

	public static function get( $key, $default = null ) {
		self::init();
	
		return isset(self::$params[$key])
			? self::$params[$key]
			: $default;
	}

  public function getAll() {
	 self::init();
    
    return self::$params;
  }
}