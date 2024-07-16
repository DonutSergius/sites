<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['error' => '', 'confirm' => ''];

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

            $start = new DateTime($dateStart);
            $end = new DateTime($dateEnd);

            $errors = array_merge(
                cheсkStartDate($start),
                cheсkStartEndDate($start, $end)
            );

            $response['error'] = implode(". \n", $errors);
        } else {
            $response['error'] = 'Please fill all fields';
        }
    } else {
        if ($vacationTime === "specificTime") {
            if ($datetimeStart && $datetimeEnd && $approval && $reason) {
                $start = new DateTime($datetimeStart);
                $end = new DateTime($datetimeEnd);
                $errors = array_merge(
                    cheсkStartDate($start),
                    cheсkStartEndDate($start, $end),
                    checkDateTime($start, $end),
                );
                $response['error'] = implode(". \n", $errors);
            } else {
                $response['error'] = 'Please fill all fields';
            }
        } else {
            if ($dateStart && $dateEnd && $approval && $reason) {
                $start = new DateTime($dateStart);
                $end = new DateTime($dateEnd);
                $errors = array_merge(
                    cheсkStartDate($start),
                    cheсkStartEndDate($start, $end),
                );
                $response['error'] = implode(". \n", $errors);
            } else {
                $response['error'] = 'Please fill all fields';
            }
        }
    }
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Unknow error']);
}

function checkDateTime($dateStart, $dateEnd)
{
    $errors = [];

    if (
        $dateStart->format('h') < 9 || $dateStart->format('h') > 18
        || $dateEnd->format('h') < 9 || $dateEnd->format('h') > 18
    ) {
        $errors[] = 'Unpaid vacation cannot take in out work time';
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
