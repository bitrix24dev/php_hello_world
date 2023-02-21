<?php
require_once 'pdo.php';

use Google\Cloud\Samples\CloudSQL\Postgres;

// https://phpdelusions.net/pdo_examples/insert

$connection = Postgres\DatabaseUnix::initUnixDatabaseConnection();

$time = date("Y-m-d H:i:s");

$data = [
    "name" => "test",
    "created" => $time,
    "updated" => $time,
    "email" => "123@mail.ru",
    "account_id" => 1,
    "roles" => "{1,2}",
];

$sql = "INSERT INTO users (name, created, updated, email, account_id, roles) VALUES (:name, :created, :updated, :email, :account_id,:roles)";
$connection->prepare($sql)->execute($data);


echo "User Created";