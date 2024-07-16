<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['error' => '', 'confirm' => ''];

    $dateStart = $_POST['date-start'] ?? null;
    $dateEnd = $_POST['date-end'] ?? null;
    $approval = $_POST['approval'] ?? null;
    $reason = $_POST['reason'] ?? null;

    if ($dateStart && $dateEnd && $approval && $reason) {

        $startDate = new DateTime($dateStart);
        $currentDate = new DateTime();

        $formattedStartDate = $startDate->format('Y-m-d H:i:s');
        $formattedCurrentDate = $currentDate->format('Y-m-d H:i:s');

        $response['confirm'] = 'Complete success' .   $formattedStartDate . ' //' . $formattedCurrentDate;
    } else {
        $response['error'] = 'Please fill all field in form.';
    }

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Unknow error']);
}
