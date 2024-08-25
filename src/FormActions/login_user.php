<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../vendor/autoload.php';

use Sites\Services\DBService;


session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [
        'error' => '',
        'confirm' => '',
    ];

    $username = $_POST['user_nickname'] ?? null;
    $password = $_POST['user_password'] ?? null;

    if ($username && $password) {
        $conn = (new DBService)->getDBConf();
        $hashed_password = checkUserNickname($conn, $username);
        if ($hashed_password == $password) {
            $userData = loadSession($conn, $username);
            if ($userData) {
                $_SESSION['user_id'] = $userData['user_id'];
                $_SESSION['user_nickname'] = $userData['user_nickname'];
                $_SESSION['user_role'] = $userData['user_role'];
                $response['confirm'] = 'Login';
            }
        } else {
            $response['error'] = 'Invalid username or password';
        }
    } else {
        $response['error'] = 'Please fill all fields';
    }

    echo json_encode($response);
}

function loadSession($conn, $username)
{
    $conn = (new DBService)->getDBConf();
    $sql = 'SELECT user_id, user_nickname, user_role FROM user_info WHERE user_nickname = ?';
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id, $user_nickname, $user_role);
        if (mysqli_stmt_fetch($stmt)) {
            return [
                'user_id' => $user_id,
                'user_nickname' => $user_nickname,
                'user_role' => $user_role,
            ];
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}

function checkUserPassword($user_password, $hashed_password)
{
    return password_verify($user_password, $hashed_password);
}

function checkUserNickname($conn, $user_nickname)
{
    $conn = (new DBService)->getDBConf();
    $sql = "SELECT user_password FROM user WHERE user_nickname = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $user_nickname);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashed_password);
        if (mysqli_stmt_fetch($stmt)) {
            return $hashed_password;
        }
    }
    mysqli_stmt_close($stmt);
    return false;
}
