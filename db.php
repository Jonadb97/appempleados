<?php
$GLOBALS['connectionState'] = 'danger';

$servidor = 'localhost';
$db = 'appempleados';
$user = 'root';
$password = '';

try {
    $connection = new PDO("mysql:host=$servidor;dbname=$db", $user, $password);
    $GLOBALS['connectionState'] = 'success';
}   catch (Exception $ex) {
    echo $ex->getMessage();
}
