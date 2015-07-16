<?php

$validPasswords = [
  "admin" => "admin"
];

$validUsers = array_keys($validPasswords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = ( in_array($user, $validUsers) ) && ( $pass == $validPasswords[$user] );

if ( !$validated ) {
  header('WWW-Authenticate: Basic realm="Security Check"');
  header('HTTP/1.0 401 Unauthorized');

  die ("Access Denied");
}