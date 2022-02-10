<?php
header('Content-Type: application/json');

include '../config/db.php';

try {
    $params = array(
        $_POST['docNo'],
        $_POST['qId'],
        $_POST['deptId'],
        $_POST['locaId'],
        $_POST['rating']
    );

    $sql = "INSERT INTO [HoN].[dbo].[SpaSurveyDetails] ([DocNo], [QuesID], [DeptID], [LocaID], [Rating]) 
            VALUES (?, ?, ?, ?, ?)";
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
