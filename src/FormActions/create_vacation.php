<?php
header('Content-Type: application/json');
require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require_once  PROJECT_ROOT . '/db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentDate = new DateTime();

    $response = [
        'error' => '',
        'confirm' => '',
    ];
    $response_log = [
        'date' => $currentDate->format('Y-m-d H:i:s'),
    ];

    $vacationType = $_POST['vacation-type'] ?? null;
    $vacationTime = $_POST['vacation-time'] ?? null;

    $datetimeStart = $_POST['datetime-start'] ?? null;
    $datetimeEnd = $_POST['datetime-end'] ?? null;

    $dateStart = $_POST['date-start'] ?? null;
    $dateEnd = $_POST['date-end'] ?? null;

    $approval = $_POST['approval'] ?? null;
    $reason = $_POST['reason'] ?? null;

    if ($vacationType === "paid") {
        if ($dateStart && $dateEnd && $approval && $reason) {
            $vacationTime = 'fullDay';
            $errors = checkFullDayVacation($dateStart, $dateEnd);
            $response['error'] = implode(". \n", $errors);
        } else {
            $response['error'] = 'Please fill all fields';
        }
    } else {
        if ($vacationTime === "specificTime") {
            if ($datetimeStart && $datetimeEnd && $approval && $reason) {
                $errors = checkSpecificTimeVacation($datetimeStart, $datetimeEnd);
                $response['error'] = implode(". \n", $errors);
            } else {
                $response['error'] = 'Please fill all fields';
            }
        } else {
            if ($dateStart && $dateEnd && $approval && $reason) {
                $errors = checkFullDayVacation($dateStart, $dateEnd);
                $response['error'] = implode(". \n", $errors);
            } else {
                $response['error'] = 'Please fill all fields';
            }
        }
    }
    if (empty($response['error'])) {

        if ($vacationTime == 'fullDay') {
            $start = new DateTime($dateStart);
            $end = new DateTime($dateEnd);
        } else {
            $start = new DateTime($datetimeStart);
            $end = new DateTime($datetimeEnd);
        }

        $date_start = $start->format('Y-m-d H:i:s');
        $date_end = $end->format('Y-m-d H:i:s');

        $sql = "INSERT INTO vacation_request 
        (vacation_user_id, vacation_type, vacation_date_type, vacation_date_start, 
        vacation_date_end, vacation_reason, vacation_approval) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $conn = getDBConf();
        $user_id = $_SESSION['user_id'];
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param(
                $stmt,
                "isssssi",
                $user_id,
                $vacationType,
                $vacationTime,
                $date_start,
                $date_end,
                $reason,
                $approval
            );

            if (mysqli_stmt_execute($stmt)) {
                $response_log['confirm'] = 'New row in db will be added';
                $response['confirm'] = "Vacation request send to moder";
            } else {
                $response_log['fatal'] = 'FATAL: Can not create new row: ' . mysqli_error($conn);
            }
        } else {
            $response_log['fatal'] = 'FATAL: can not load new query: ' . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
    if ($response['error']) {
        $response_log['error'] = $response['error'];
    }

    $responseString = json_encode($response_log, JSON_PRETTY_PRINT);
    $fileName = PROJECT_ROOT . '/vacation_log.txt';
    file_put_contents($fileName, $responseString . PHP_EOL, FILE_APPEND);

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Unknow error']);
}

function checkFullDayVacation($date_start, $date_end)
{
    $start = new DateTime($date_start);
    $end = new DateTime($date_end);

    $errors = array_merge(
        cheсkStartDate($start),
        cheсkStartEndDate($start, $end)
    );

    return $errors;
}

function checkSpecificTimeVacation($date_start, $date_end)
{
    $start = new DateTime($date_start);
    $end = new DateTime($date_end);
    $errors = array_merge(
        cheсkStartDate($start),
        cheсkStartEndDate($start, $end),
        checkDateTime($start, $end),
    );

    return $errors;
}

function checkDateTime($dateStart, $dateEnd)
{
    $errors = [];

    if ($dateStart->format('G') < 9 || $dateStart->format('G') > 18) {
        $errors[] = 'Start date time must be within work hours (09:00 - 18:00)';
    }

    if ($dateEnd->format('G') < 9 || $dateEnd->format('G') > 18) {
        $errors[] = 'End date time must be within work hours (09:00 - 18:00)';
    }

    return $errors;
}

function cheсkStartEndDate($dateStart, $dateEnd)
{
    $errors = [];
    $interval = $dateStart->diff($dateEnd);
    $daysDifference = $interval->days;

    if ($dateEnd < $dateStart) {
        $errors[] = 'Vacation cannot end before will start';
    }
    if ($daysDifference > 14) {
        $errors[] = 'Vacation cannot exist more than 14 days';
    }
    if ($daysDifference < 7 && in_array($dateEnd->format('N'), ['6', '7'])) {
        $errors[] = 'Vacation cannot end on Saturday or Sunday';
    }

    return $errors;
}

function cheсkStartDate($dateStart)
{
    $errors = [];
    $currentDate = new DateTime();

    if ($currentDate > $dateStart) {
        $errors[] = 'You cannot take vacation on past date';
    }
    if (in_array($dateStart->format('N'), ['6', '7'])) {
        $errors[] = 'Vacation cannot start on Saturday or Sunday';
    }

    return $errors;
}
