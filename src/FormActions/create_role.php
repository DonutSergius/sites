<?php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require_once  PROJECT_ROOT . '/db_config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [
        'error' => '',
        'confirm' => '',
    ];

    $roleName = $_POST['role_name'] ?? null;
    $roleVacationDay = $_POST['role_vacation_day'] ?? null;

    $sql = 'INSERT INTO role (role_name, role_vacation_day) VALUES (?, ?)';

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $roleName, $roleVacationDay);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $response['confirm'] = "New role created";
    }

    echo json_encode($response);
}
