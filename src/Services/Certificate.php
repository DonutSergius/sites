<?php

namespace Sites\Services;

use Sites\Services\DBService;
use Sites\Services\Operation;
use DateTime;

class Certificate
{
    public function getActiveCertificates($user_id)
    {
        $service = new DBService;
        $data = $service->getData(
            ["*"],
            "certificate WHERE certificate_status = 'Active' AND certificate_user_id = " . $user_id
        );

        return $data;
    }

    public function getUserBalance($user_id)
    {
        $certificates = (new Certificate)->getActiveCertificates($user_id);
        $balance = 0;
        foreach ($certificates as $certificate) {
            $balance += $certificate['certificate_count_days'];
        }

        return $balance;
    }

    public function updateUserCertificate($user_id)
    {
        $user_certificates = $this->getActiveCertificates($user_id);
        foreach ($user_certificates as $certificate) {
            $this->checkCertificate($certificate);
        }
    }

    private function checkCertificate($certificate)
    {
        $current_datetime = new DateTime();
        if ($certificate['certificate_date_end'] < $current_datetime) {
            $this->bornCertificate(0, 'Unactive', $certificate['certificate_id']);
            $operation_name = "Born Certificate";
            (new Operation)->setOperation(
                $certificate['certificate_user_id'],
                $operation_name,
                $certificate['certificate_count_days'],
                $certificate['certificate_count_days'],
                0,
                $certificate['certificate_date_end'],
            );
            if ($certificate['certificate_type'] == "Standart") {
                $this->createNewCertificate($certificate);
            }
        }
    }

    private function createNewCertificate($certificate)
    {
        $conn = (new DBService)->getDBConf();

        $vacation_day = (new DBService)->getData(
            ["r.role_vacation_day"],
            "user JOIN role as r ON user.user_role = r.role_id WHERE user.user_id = " . $certificate['certificate_user_id']
        );

        $sql = "INSERT INTO `certificate` (
            certificate_name, 
            certificate_date_start, 
            certififcate_date_end, 
            certificate_count_days, 
            certificate_user_id, 
            certificate_type
            VALUES (?, ?, ?, ?, ?, ?)";
        $certificate_name = "Standart Certificate";
        $certificate_date_end = new DateTime($certificate['certificate_date_end']);
        $certificate_date_end->modify('+1 day');
        $certificate_type = "Standart";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param(
                $stmt,
                "sssiis",
                $certificate_name,
                $certificate['certificate_date_end'],
                $certificate_date_end,
                $vacation_day,
                $certificate['certificate_user_id'],
                $certificate_type,
            );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        $operation_name = "Give new Certificate";
        (new Operation)->setOperation(
            $certificate['certificate_user_id'],
            $operation_name,
            0,
            $vacation_day,
            $vacation_day,
            $certificate['certificate_date_end'],
        );
    }

    public function updateCertificate($days_lost, $certificate_id)
    {
        $current_date = new DateTime();
        $certificate = (new DBService)->getData(["*"], "certificate WHERE certificate_id = " . $certificate_id);
        $math_days = $certificate['certificate_count_days'] - $days_lost;
        $conn = (new DBService)->getDBConf();
        $sql = "UPDATE `certificate` 
        SET certificate_count_days = ? WHERE certificate_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "isi", $days_lost, $certificate_id);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        $operation_name = "Vacation";
        (new Operation)->setOperation(
            $certificate['certificate_user_id'],
            $operation_name,
            $certificate['certificate_count_days'],
            $math_days,
            $days_lost,
            $current_date,
        );
    }

    public function bornCertificate($count_days, $status, $certificate_id)
    {
        $conn = (new DBService)->getDBConf();
        $sql = "UPDATE `certificate` 
        SET certificate_count_days = ?, certificate_status = ? WHERE certificate_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "isi", $count_days, $status, $certificate_id);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
