<?php
require_once 'pdo.php';
echo "Hello supremacy!";
use Google\Cloud\Samples\CloudSQL\Postgres;
$connection = Postgres\DatabaseUnix::initUnixDatabaseConnection();
print_r($connection);
