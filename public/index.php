<?php

if (getenv('APPLICATION_ENV') == 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    define('YII_DEBUG', true);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);

    define('YII_DEBUG', false);
}

// change the following paths if necessary
require __DIR__ . '/../vendor/autoload.php';

//$config=dirname(__FILE__).'/../protected/config/' . $_SERVER['SERVER_NAME'] . '.php';
$config = realpath('../protected/config/' . $_SERVER['SERVER_NAME'] . '.php');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

// TODO: set timezone from config
ini_set('date.timezone', 'Europe/Berlin');

Yii::createWebApplication($config)->run();
