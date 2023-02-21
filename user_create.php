<?php
require_once 'pdo.php';
use Google\Cloud\Samples\CloudSQL\Postgres;

// https://phpdelusions.net/pdo_examples/insert

$connection = Postgres\DatabaseUnix::initUnixDatabaseConnection();

$time = time();

$user = [
  "email" => "123@mail.ru",
  "created" => $time,
  "updated" => $time,
  "roles" => "",
  "account_id" => 1,
];

$sql = "INSERT INTO users (email, created, updated,roles,account_id) VALUES (:name, :created, :updated, :roles, :account_id)";
$connection->prepare($sql)->execute($user);


echo "User Created";