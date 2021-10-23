<?php 


declare(strict_types = 1); //https://stackoverflow.com/questions/48723637/what-do-strict-types-do-in-php

spl_autoload_register(function(string $classNamespace){
    $path = str_replace(['\\', 'App/'],['/',''], $classNamespace);
    $path = "src/$path.php";
    require_once($path);
});

require_once("src/Utils/debug.php");
$configuration = require_once("config/config.php");

use App\Request;
use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Exception\AppException;
use App\Exception\ConfigurationException;

$request = new Request($_GET, $_POST, $_SERVER);

try{
  AbstractController::initConfiguration($configuration);
  (new NoteController($request))->run();
} catch(ConfigurationException $e){
    dump($e->getMessage());
    echo '<h1>Wystąpił błąd</h1>';
    echo 'Problem z konfiguracją.Proszę skontaktować się z administratorem';
} catch(AppException $e){
    echo "<h1>Wystąpił błąd</h1>";
    echo "<h3>" . $e->getMessage() . " </h3>";
} catch(Throwable $e){
    echo "<h1>Wystąpił błąd</h1>";
}







