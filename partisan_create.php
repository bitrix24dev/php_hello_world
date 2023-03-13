<?php
require_once 'pdo.php';

use Google\Cloud\Samples\CloudSQL\Postgres;

// https://phpdelusions.net/pdo_examples/insert

// пример вызова https://php-hello-world-h4b6my3gjq-uc.a.run.app/user_create.php

// документация https://www.php.net/manual/en/book.pdo.php


$connection = Postgres\DatabaseUnix::initUnixDatabaseConnection();

$time = date("Y-m-d H:i:s");

$partisan_mock = [
    "active" => 1,
    "nickname" => "test_nickname",
    "level_id" => 1,
    "faction_id" => null,
    "post_num" => 0,
    "comment_num" => 0,
    "like_num" => 0,
    "dislike_num" => 0,
    "created" => $time,
    "updated" => $time,
    "user_id" => 1,
    "account_id" => 1,
    "ego_id" => 1,
    "experience_id" => 1,
    "avatar_id" => 1,
    "is_candidate" => 0,
    "archive" => 0,
    "description" => "",
    "topic_id" => "{0}",
    "code" => "test_nickname",
    "closet_capacity" => 1000,
];


// ищем, есть ли пользователь в базе с таким E-mail адресом

$sql = "SELECT id FROM partisans where nickname=:nickname";

$stmt = $connection->prepare($sql);
$stmt->execute(["nickname" => $partisan_mock["nickname"]]);
$exists = $stmt->fetch();


$partisan_mock_keys_with_colon = [];
foreach($partisan_mock as $key => $value){
    $partisan_mock_keys_with_colon[] = ":{$key}";
}

if (is_array($exists) && $exists["id"]) {
    echo "Error. Exists partisan with such nickname";
} else {
    $connection->beginTransaction();

    // создаем аккаунт
    $sql = "INSERT INTO partisans (".implode(",",array_keys($partisan_mock)).") VALUES (".implode(",",$partisan_mock_keys_with_colon).")";
    $connection->prepare($sql)->execute($partisan_mock);
    $partisan_id = $connection->lastInsertId();

    $connection->commit();

    echo "Partisan Created";
}


