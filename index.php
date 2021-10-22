<?php 


declare(strict_types = 1); //https://stackoverflow.com/questions/48723637/what-do-strict-types-do-in-php

namespace App;

use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;

// include - includuje plik, w którym mamy jakiś kod, którego chcemy użyć.
include ("src/Utils/debug.php");
require_once("src/NoteController.php");
require_once("src/Request.php");

$configuration = require_once("config/config.php");

// include_once - zaimportowany może być tylko jeden raz, gdy zainkludujemy go drugi raz to już to php zignoruje.

// require - gdy nie uda się zaimportować skrypt przerwie swoje działanie , a include po niepoprawnym czytaniu dalej będzie wczytywać skrypt. 
// require_once - wczyta raz , analogicznie do include_once, gdy zainkludujemy do drugi raz to już php zignoruje. Różnice, że require_once wymaga ten plik, gdyż po nieznalezieniu
// skrypt przestanie działać.

// $test = 'test';

// dump($test);

$request = new Request($_GET, $_POST);

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







