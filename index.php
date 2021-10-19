<?php 


declare(strict_types = 1); //https://stackoverflow.com/questions/48723637/what-do-strict-types-do-in-php

namespace App;

// include - includuje plik, w którym mamy jakiś kod, którego chcemy użyć.
include ("src/Utils/debug.php");
require_once("src/View.php");

const DEFAULT_ACTION = 'list';

// include_once - zaimportowany może być tylko jeden raz, gdy zainkludujemy go drugi raz to już to php zignoruje.

// require - gdy nie uda się zaimportować skrypt przerwie swoje działanie , a include po niepoprawnym czytaniu dalej będzie wczytywać skrypt. 
// require_once - wczyta raz , analogicznie do include_once, gdy zainkludujemy do drugi raz to już php zignoruje. Różnice, że require_once wymaga ten plik, gdyż po nieznalezieniu
// skrypt przestanie działać.

// $test = 'test';

// dump($test);
$action = $_GET['action'] ?? DEFAULT_ACTION;

$view = new View();

$viewParams = [];
if($action === 'create') {
    $page = 'create';
    $viewParams['resultCreate'] = "udało się";
}
else {
    $page = 'list';
    $viewParams['resultList'] = "Wyświetlamy notatki";
}


$view->render($page, $viewParams);
//htmlentities($action) w celu unikniecia np. wykonywania się javascriptowego pliku który np. mółby wygrać dane do logowania z ciasteczek




