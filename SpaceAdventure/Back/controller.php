<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");


use modeleUser\User;

include __DIR__ . "/request.php";

$create = new User();


$val = $create->getAllPlanets();


$result =$val;

header("Content-Type: application/json");

echo json_encode($result);