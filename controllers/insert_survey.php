<?php

include '../config/db.php';
header('Content-Type: application/json');

try {
    $params = array(
        $_POST['docNo'],
        $_POST['emp'],
        $_POST['comment']
    );

    $sql = "INSERT INTO [HoN].[dbo].[SpaSurveys] ([DocNo], [EmpName], [Comments]) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    
    echo json_encode(array(
        "status" => "success",
        "message" => 'Success'
    ));
} catch (Exception $ex) {
    echo json_encode(array(
        "status" => "danger",
        "message" => "Fail " . $ex->getMessage()
    ));
}

$conn = NULL;
