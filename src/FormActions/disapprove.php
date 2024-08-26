<?php

use Sites\Services\DBService;

require_once __DIR__ . '/../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['action']) ? intval($_POST['action']) : NULL;

    if ($id !== NULL) {
        $conn = (new DBService)->getDBConf();
        $sql = "UPDATE vacation_request SET vacation_status = 'Disapproved' WHERE vacation_id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: /sites/approval-vacation');
                exit;
            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
