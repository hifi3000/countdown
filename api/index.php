<?php

session_start();

require_once __DIR__ . '/modules/sk_header/header.php';

require_once __DIR__ . '/modules/sk_error/error.php';

require_once __DIR__ . '/php/db.php';
require_once __DIR__ . '/modules/sk_database/database.php';

require_once __DIR__ . '/modules/sk_login/login.php';


$requestBody = file_get_contents('php://input');
$requestBody = json_decode($requestBody, true);

$numbers = $requestBody['numbers'];

$responseArray = getResponseArray($numbers);

$message   = getMessage($responseArray);
$outcome   = isPossible($message);
$solutions = getSolutions($responseArray);
$tally     = count($solutions);

$response = array(
  'outcome'   => $outcome,
  'message'   => $message,
  'solutions' => $solutions,
  'tally'     => $tally,
);

header('Content-Type: application/json');echo json_encode($response);die;


function getResponseArray(string $numbers) {
  $responseString = shell_exec('python3 ./src/countdown_solver.py ' . $numbers . ' 2>&1');
  return preg_split("/\r\n|\n|\r/", $responseString);
}


function getMessage(array $array) {
  return array_slice($array, 0, 1)[0];
}


function isPossible(string $message) {
  if (strpos($message, 'by 0.') !== false) {
    return true;
  }
  return false;
}


function getSolutions(array $input) {
  $solutions = array();

  $array = array_slice($input, 1);
  
  foreach ($array as $key => $value) {
    if (!empty($value)) {
      $solutions[] = $value;
    }
  }

  return $solutions;
}