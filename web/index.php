<?php

define(DEBUG, true); // set false at production

ini_set('display_errors', DEBUG);

include __DIR__ . '/security.php';
include __DIR__ . '/../base/config.php';
include __DIR__ . '/../base/router.php';

Router::start();