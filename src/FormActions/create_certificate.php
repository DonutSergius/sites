<?php

use Sites\Form\CreateCertificateForm;

require_once __DIR__ . '/../../vendor/autoload.php';

$handler = new CreateCertificateForm();
$handler->validationForm();

/* if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [
        'error' => '',
        'confirm' => '',
    ];

    $date_start = new DateTime();

    $date_end = $_POST['date-end'] ?? null;
    $count_days = $_POST['count-days'] ?? null;
    $user_nickname = $_POST['user-nickname'] ?? null;
    $user_id = null;

    if ($date_end && $count_days && $user_nickname) {
        $date_end = new DateTime($date_end);
        if ($date_end < $date_start) {
            $response['error'] = 'Date end cannot make less then now';
        }
        $interval = $date_start->diff($date_end);
        $daysDifference = $interval->days;
        if ($count_days > 14) {
            $response['error'] = 'Certificate cannot be give more than 14 days';
        }

        $conn = (new DBService)->getDBConf();
        if ($conn === false) {
            $response['error'] = 'Database connection failed';
        } else {
            $sql = "SELECT user_id FROM user WHERE user_nickname = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $user_nickname);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                $user_id = $result->fetch_assoc()['user_id'];

                if ($user_id === NULL) {
                    $response['error'] = 'User does not exist';
                }

                mysqli_stmt_close($stmt);
            } else {
                $response['error'] = 'Failed to prepare the SQL statement';
            }

            mysqli_close($conn);
        }
    } else {
        $response['error'] = 'Please fill all fields';
    }

    if (empty($response['error'])) {
        $certificate_name = 'Bonus certificate to' . $user_nickname;
        $certificate_type = "Bonus";
        $start = $date_start->format('Y-m-d H:i:s');
        $end = $date_end->format('Y-m-d H:i:s');

        $sql = "INSERT INTO certificate (
        certificate_name, certificate_date_start, 
        certificate_date_end, certificate_count_days, 
        certificate_user_id, certificate_type)
        VALUES (?, ?, ?, ?, ?, ?)";

        $conn = (new DBService)->getDBConf();
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param(
                $stmt,
                "sssiis",
                $certificate_name,
                $start,
                $end,
                $count_days,
                $user_id,
                $certificate_type,
            );
            mysqli_stmt_execute($stmt);
        }
        mysqli_close($conn);

        $response['confirm'] = 'Goood';
    }

    echo json_encode($response);
}
 */