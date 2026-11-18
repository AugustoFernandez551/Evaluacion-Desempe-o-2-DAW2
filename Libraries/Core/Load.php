<?php

$controllerFile = "Controllers/{$controller}Controller.php";

if (!file_exists($controllerFile)) {
    require_once "Controllers/ErrorController.php";
    exit;
}

require_once $controllerFile;
$className = "{$controller}Controller";
$object = new $className();

if (!method_exists($object, $method)) {
    require_once "Controllers/ErrorController.php";
    exit;
}

$param === null ? $object->$method() : $object->$method($param);
