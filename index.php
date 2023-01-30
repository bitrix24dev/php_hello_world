<?php
require_once 'pdo.php';
echo "Hello supremacy!";
use Google\Cloud\Samples\CloudSQL\Postgres;
$connection = Postgres\DatabaseUnix::initUnixDatabaseConnection();

$connection->exec("INSERT INTO tools(name) VALUES ('666');");
/*
$stmt = $connection->query("SELECT * FROM tools");
while ($row = $stmt->fetch()) {
    echo $row['name']."<br />\n";
}
*/

