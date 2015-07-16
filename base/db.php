<?php

class DB {
  protected static $instance;
  public $conn;

  private function __construct() {
    $this->conn = $this->connect();
  }

  private function __clone() {}

  public static function getInstance() {
      if ( null === self::$instance ) {
          self::$instance = new self();
      }

      return self::$instance;
  }

  private function connect() {
    $host = Config::get('db.host');
    $name = Config::get('db.name');
    $user = Config::get('db.user');
    $password = Config::get('db.password');

    $conn = new PDO("mysql:host={$host};dbname={$name}", $user, $password);

    $stmt = $conn->prepare('SET NAMES `utf8`');
    $stmt->execute();

    return $conn;
  }
}