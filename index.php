<?php 

// include - includuje plik, w którym mamy jakiś kod, którego chcemy użyć.
include ("src/Utils/debug.php");
// include_once - zaimportowany może być tylko jeden raz, gdy zainkludujemy go drugi raz to już to php zignoruje.

// require - gdy nie uda się zaimportować skrypt przerwie swoje działanie , a include po niepoprawnym czytaniu dalej będzie wczytywać skrypt. 
// require_once - wczyta raz , analogicznie do include_once, gdy zainkludujemy do drugi raz to już php zignoruje. Różnice, że require_once wymaga ten plik, gdyż po nieznalezieniu
// skrypt przestanie działać.

$test = 'test';

dump($test);
