<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use Jasny\Config;
$confFile = realpath(__DIR__ . '/../config.ini');
$config = new Config($confFile);

//Set up Database Connection
try {
    $db = new PDO("mysql:host=" .$config->database->host . ";dbname=" . $config->database->dbname,$config->database->username,$config->database->password);
}
catch(PDOException $e){
    echo $e->getMessage();
}
ActiveRecord\Config::initialize(function($cfg){
    global $config;
    $arConStr = 'mysql://' . $config->database->username . ':' . $config->database->password . '@localhost/' . $config->database->dbname;
    $modelDir = realpath(__DIR__ . '/../models');
	$cfg->set_model_directory($modelDir);
    $cfg->set_connections(array(
        'development' => $arConStr));
});
\ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
//Set Up Twig
Twig_Autoloader::register();
$templates = realpath(__DIR__ . "/../templates");
$loader = new Twig_Loader_Filesystem($templates);
$twig = new Twig_Environment($loader, array(

));

session_start();