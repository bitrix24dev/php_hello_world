<?php
require_once 'pdo.php';

use Google\Cloud\Samples\CloudSQL\Postgres;

// https://phpdelusions.net/pdo_examples/insert

// пример вызова https://php-hello-world-h4b6my3gjq-uc.a.run.app/user_create.php

// документация https://www.php.net/manual/en/book.pdo.php


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

// ищем, есть ли пользователь в базе с таким E-mail адресом

$sql = "SELECT id FROM users where email=:email";

$stmt = $connection->prepare($sql);
$stmt->execute(["email" => $data["email"]]);
$exists = $stmt->fetch();
print_r($exists);
die();


$sql = "INSERT INTO users (name, created, updated, email, account_id, roles) VALUES (:name, :created, :updated, :email, :account_id,:roles)";
$connection->prepare($sql)->execute($data);


echo "User Created";