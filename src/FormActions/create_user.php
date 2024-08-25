<?php
header('Content-Type: application/json');

use Sites\Services\DBService;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [
        'error' => '',
        'confirm' => '',
    ];

    $user_nickname = $_POST['user_nickname'] ?? NULL;
    $user_role = $_POST['user_role'] ?? NULL;
    $user_firstname = $_POST['user_firstname'] ?? NULL;
    $user_lastname = $_POST['user_lastname'] ?? NULL;
    $user_email = $_POST['user_email'] ?? NULL;
    $user_password = $_POST['user_password'] ?? NULL;

    if (
        $user_nickname &&
        $user_role &&
        $user_firstname &&
        $user_lastname &&
        $user_email &&
        $user_password
    ) {
        if (!checkUserNickname($user_nickname)) {
            $response['error'] = 'This nickname already exist';
        }

        if (!checkUserEmail($user_email)) {
            $response['error'] = 'This email already exist';
        }

        if (empty($response['error'])) {
            $insert_sql = "INSERT INTO user (user_nickname, user_role, user_first_name, user_last_name, user_email, user_password) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $insert_sql)) {
                mysqli_stmt_bind_param($stmt, "sissss", $user_nickname, $user_role, $user_firstname, $user_lastname, $user_email, $user_password);

                if (mysqli_stmt_execute($stmt)) {
                    $response['confirm'] = 'User added successfully';
                } else {
                    $response['error'] = 'Error adding user: ' . mysqli_error($conn);
                }
            } else {
                $response['error'] = 'Error preparing query: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $response['error'] = 'Please fill all fields';
    }

    echo json_encode($response);
}

function checkUserNickname($nickname)
{
    $conn = (new DBService)->getDBConf();
    $check_sql = "SELECT * FROM user WHERE user_nickname = ?";
    if ($stmt = mysqli_prepare($conn, $check_sql)) {
        mysqli_stmt_bind_param($stmt, "s", $nickname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            return FALSE;
        }
        mysqli_stmt_close($stmt);
    }

    return TRUE;
}

function checkUserEmail($email)
{
    $conn = getDBConf();
    $check_sql = "SELECT * FROM user WHERE user_email = ?";
    if ($stmt = mysqli_prepare($conn, $check_sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            return FALSE;
        }
        mysqli_stmt_close($stmt);
    }

    return TRUE;
}
