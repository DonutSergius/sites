<?php

use Sites\Services\DBService;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config.php';
error_log("POST data: " . print_r($_POST, true));
error_log("Directory root: " . DIRECTORY_ROOT);

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
            $location = 'Location: ' . DIRECTORY_ROOT . '/approval-vacation';
            header($location);
            exit;
        }

        echo $result;
    }
}
