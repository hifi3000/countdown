<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


function preprint($name) {
  echo "<pre>";
  print_r ($name);
  echo "</pre>";
}

function output($value) {
  header('Content-Type: application/json');
  echo json_encode($value);
  die;
}