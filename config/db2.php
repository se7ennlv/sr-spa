<?php

$data = array(
    "server" => "172.16.98.142",
    "db" => "PSA66",
    "user" => "sa",
    "password" => "Kiss@@33",
);

try {
    $conn2 = new PDO("sqlsrv:server=" . $data["server"] . "; database=" . $data["db"], $data["user"], $data["password"]);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, pdo::ERRMODE_EXCEPTION);
    
    // echo 'Connect pass';
} catch (Exception $ex) {
    echo 'Cannot connect to server! please check the connection';
    //echo 'ERROR' . $ex->getMessage();
}
