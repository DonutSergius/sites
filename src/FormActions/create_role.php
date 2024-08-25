<?php

use Sites\Form\CreateRoleForm;

require_once __DIR__ . '/../../vendor/autoload.php';

$handler = new CreateRoleForm();
$handler->validationForm();

/* if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [
        'error' => '',
        'confirm' => '',
    ];

    $roleName = $_POST['role_name'] ?? null;
    $roleVacationDay = $_POST['role_vacation_day'] ?? null;

    $conn = (new DBService)->getDBConf();
    $sql = 'INSERT INTO role (role_name, role_vacation_day) VALUES (?, ?)';
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $roleName, $roleVacationDay);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $response['confirm'] = "New role created";
    }

    echo json_encode($response);
} */
