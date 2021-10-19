<?php 

declare(strict_types = 1);

error_reporting(E_ALL);
ini_set('display errors', "1"); //ustawia rzeczy konfiguracyjne php 

function dump($data)
{
    echo '<br/><div 
    style="
    display: inline-block;
    padding: 0px 10px;
    border: 1px solid gray;
    background: lightgray
    ">
    <pre>';
    print_r($data);
    echo '</pre></div>
    <br/>';
}