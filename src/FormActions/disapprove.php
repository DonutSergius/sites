<?php

use Sites\Services\DBService;

require_once __DIR__ . '/../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['action']) ? intval($_POST['action']) : NULL;

    if ($id !== NULL) {
        $conn = (new DBService)->getDBConf();
        $table = "vacation_request";
        $data = [
            "vacation_status" => 'Disapproved',
        ];
        $condition = "vacation_id = " . (int)$id;

        $result = (new DBService)->updateData($table, $data, $condition);

        if ($result === TRUE) {
            header('Location: /sites/approval-vacation');
            exit;
        }

        echo $result;
    }
}
