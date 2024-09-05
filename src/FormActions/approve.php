<?php

use Sites\Services\DBService;
use Sites\Services\Certificate;
use Sites\Services\Operation;

require_once __DIR__ . '/../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['action']) ? intval($_POST['action']) : NULL;
    $currentTime = new DateTime();
    $currentTimeFormatted = $currentTime->format("Y-m-d H:i:s");

    if ($id !== NULL) {
        $conn = (new DBService)->getDBConf();

        $table = "`vacation_request`";
        $lables = ["vacation_user_id", "vacation_date_start", "vacation_date_end"];
        $conditionVacation = "WHERE vacation_id = " . (int)$id;

        $vacationData = (new DBService)->getData($lables, $table, $conditionVacation);
        $vacationData = $vacationData->fetch_assoc();


        $start = new DateTime($vacationData['vacation_date_start']);
        $end = new DateTime($vacationData['vacation_date_end']);
        $interval = $start->diff($end);

        $daysInRequest = $interval->days + 1;
        $user_id = $vacationData["vacation_user_id"];

        $certificateService = new Certificate;
        $certificates = $certificateService->getActiveCertificates($user_id);
        $userBalance = $certificateService->getUserBalance($user_id);

        if ($daysInRequest > $userBalance) {
            require 'disapprove.php';
            exit;
        } else {
            $lost = $daysInRequest;
            $clear = FALSE;
            $op_name = "Approved vacation";
            foreach ($certificates as $certificate) {
                $use_days = 0;
                $lost_days = 0;
                $lost = $certificate['certificate_count_days'] - $lost;
                if ($lost < 0) {
                    $lost *= -1;
                    $use_days = $certificate['certificate_count_days'];
                    $lost_days = 0;
                } else {
                    $clear = TRUE;
                    $use_days = $certificate['certificate_count_days'] - $lost;
                    $lost_days = $lost;
                }

                $updateData = ['certificate_count_days' => $lost_days];
                (new Operation)->setOperation(
                    $user_id,
                    $op_name,
                    (int)$certificate['certificate_count_days'],
                    $use_days,
                    $lost_days,
                    $currentTimeFormatted,
                );

                $updateCertificatecondition = "certificate_id = " . $certificate['certificate_id'];
                $result = (new DBService)->updateData("`certificate`", $updateData, $updateCertificatecondition);

                if ($clear) {
                    break;
                }
            }
        }

        $data = [
            "vacation_status" => 'Approved',
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
