<?php
header('Content-Type: application/json');
include '../config/db.php';

try {
    $sql = "SELECT ISNULL(MAX(DocNo), 0) + 1 FROM SpaSurveys";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $rs = $stmt->fetchColumn();

    echo json_encode($rs);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

$conn = NULL;
