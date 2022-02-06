<?php

if (isset($_GET['logins'])) {
  $requestBody = file_get_contents('php://input');
  $requestBody = json_decode($requestBody, true);

  $email = $requestBody['email'];
  $passwort = $requestBody['passwort'];

  $sql = "SELECT * FROM users WHERE email = '$email';";

  $result = queryFetch($sql);
  $user = (!empty($result)) ? $result[0] : false;

  if (!$user || !password_verify($passwort, $user['passwort'])) {
    header('HTTP/1.0 403 Forbidden');
    die;
  }

  $_SESSION['userid'] = $sha1;
  setcookie('login', $sha1, time() + (86400 * 30), "/");
  $_COOKIE['login'] = $sha1;
}


if (!isset($_COOKIE['login']) || ($_COOKIE['login'] !== $sha1)) {
  if (!isset($_SESSION['userid']) || ($_SESSION['userid'] !== $sha1)) {
    header('HTTP/1.0 403 Forbidden');
    die;
  }
}