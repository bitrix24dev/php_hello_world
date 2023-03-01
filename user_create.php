<?php
require_once 'pdo.php';

use Google\Cloud\Samples\CloudSQL\Postgres;

// https://phpdelusions.net/pdo_examples/insert

// пример вызова https://php-hello-world-h4b6my3gjq-uc.a.run.app/user_create.php

// документация https://www.php.net/manual/en/book.pdo.php


$connection = Postgres\DatabaseUnix::initUnixDatabaseConnection();

$time = date("Y-m-d H:i:s");

$user_mock = [
    "name" => "test",
    "created" => $time,
    "updated" => $time,
    "email" => "123@mail.ru",
    "account_id" => 1,
    "roles" => "{1,2}",
];

$account_mock = [
    "created" => $time,
    "entitytype_id" => 1,
    "amount_twei" => 2500,
];

// ищем, есть ли пользователь в базе с таким E-mail адресом

$sql = "SELECT id FROM users where email=:email";

$stmt = $connection->prepare($sql);
$stmt->execute(["email" => $user_mock["email"]]);
$exists = $stmt->fetch();

if (is_array($exists) && $exists["id"]) {
    echo "Error. Exists user with such email address";
} else {
    $connection->beginTransaction();

    // создаем аккаунт
    $sql = "INSERT INTO accounts (created, entitytype_id, amount_twei) VALUES (:created, :entitytype_id, :amount_twei)";
    $connection->prepare($sql)->execute($account_mock);
    $account_id = $connection->lastInsertId();
    $user_mock["account_id"] = $account_id;

    // создаем пользователя и привязываем аккаунт
    $sql = "INSERT INTO users (name, created, updated, email, account_id, roles) VALUES (:name, :created, :updated, :email, :account_id,:roles)";
    $connection->prepare($sql)->execute($user_mock);
    $user_id = $connection->lastInsertId();

    // в аккаунт дописываем id вновь созданного пользователя
    $sql = "UPDATE accounts set entity_id=:entity_id where id=:id";
    $update_account_mock = ["entity_id" => $user_id, "id" =>$account_id];
    $connection->prepare($sql)->execute($update_account_mock);

    $connection->commit();

    echo "User Created";
}


