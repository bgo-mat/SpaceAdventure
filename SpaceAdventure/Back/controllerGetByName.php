<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");


use modeleUser\User;

include __DIR__ . "/request.php";

$create = new User();
$requestData = json_decode(file_get_contents("php://input"), true);
$input = isset($requestData['input']) ? $requestData['input'] : '';

$val = $create->getPlanetsByName($input);

if($val>0){
  $result=true;
}else{
    $result=false;
}


$tabResult = [
    "result" => $result,
    "val" => $val
];

header("Content-Type: application/json");

echo json_encode($tabResult);