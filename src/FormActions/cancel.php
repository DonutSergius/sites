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
        $table = "`vacation_request`";
        $conn = (new DBService)->getDBConf();
        
        $lables = ["vacation_user_id", "vacation_status", "vacation_date_start", "vacation_date_end", "vacation_type"];
        $conditionVacation = "WHERE vacation_id = " . (int)$id;
        $vacationData = (new DBService)->getData($lables, $table, $conditionVacation);
        $vacationData = $vacationData->fetch_assoc();

        if ($vacationData['vacation_status'] === "Approved" && $vacationData['vacation_type'] === "paid") {
            $start = new DateTime($vacationData['vacation_date_start']);
            $end = new DateTime($vacationData['vacation_date_end']);
            $interval = $start->diff($end);

            $daysInRequest = $interval->days + 1;
            $user_id = $vacationData['vacation_user_id'];

            $certificateService = new Certificate;
            $certificates = $certificateService->getActiveCertificates($user_id);
            $userBalance = $certificateService->getUserBalance($user_id);

            $lostMathDays = $daysInRequest;
            $op_name = "Canceled Approved vacation";
            foreach ($certificates as $certificate) {
                
                if ($certificate['certificate_count_days'] < 7) {
                   $daysAdd = 7 - $certificate['certificate_count_days'];
                   $daysMathAfter = $lostMathDays - $daysAdd;
                   $daysBefore = $certificate['certificate_count_days'];
                    if ($daysAfter > 0) {
                        $daysAdd;
                        $daysAfter = 7;
                    } else {
                        $daysAdd = $lostMathDays;
                        $daysAfter = $certificate['certificate_count_days'] + $daysAdd;
                    }
                    
                } else {
                    continue;
                }

                $updateData = ['certificate_count_days' => $daysAfter];
                (new Operation)->setOperation(
                    $user_id,
                    $op_name,
                    $daysBefore,
                    $daysAdd,
                    $daysAfter,
                    $currentTimeFormatted,
                );

                $updateCertificatecondition = "certificate_id = " . $certificate['certificate_id'];
                $result = (new DBService)->updateData("`certificate`", $updateData, $updateCertificatecondition);

                if ($lost == 0) {
                    break;
                }
            }
        }

        $data = [
            "vacation_status" => 'Canceled',
        ];
        $condition = "vacation_id = " . (int)$id;

        $result = (new DBService)->updateData($table, $data, $condition);

        if ($result === TRUE) {
            header('Location: /sites/my-vacation-request');
            exit;
        }

        echo $result;
    }
}
