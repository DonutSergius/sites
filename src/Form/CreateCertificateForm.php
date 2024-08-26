<?php

namespace Sites\Form;

use Sites\Class\Form;
use Sites\Class\Elements;
use Sites\Services\DBService;
use Sites\Services\Operation;
use DateTime;

class CreateCertificateForm
{
    public function buildForm()
    {
        $nameForm = 'сreate_certificate';
        $action = 'src/FormActions/create_certificate.php';
        $scripts = 'src\js\formScripts\create_certificate.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $create_vacation_form = new Form($nameForm, $action, $inputs, $scripts);

        return $twig->render('form.twig.html', $create_vacation_form->toArray());
    }

    public function getInputsElements()
    {
        return [
            (new Elements('Select date end', 'date', 'date-end'))->createInput(),
            (new Elements('Enter count days', 'number', 'count-days'))->createInput(),
            (new Elements('Enter user nickname', 'text', 'user-nickname'))->createInput(),
        ];
    }

    public function validationForm()
    {
        session_start();
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
            $response = $this->submitForm($user_id);
        }

        echo json_encode($response);
    }

    private function submitForm($user_id)
    {
        $date_start = new DateTime();
        $date_end = $_POST['date-end'] ?? null;
        $count_days = $_POST['count-days'] ?? null;
        $user_nickname = $_POST['user-nickname'] ?? null;

        $certificate_name = 'Bonus certificate to ' . $user_nickname;
        $certificate_type = "Bonus";
        $date_end = new DateTime($date_end);
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

        $op_name = "Gived Bonus Certificate";
        $count_before = 0;
        (new Operation)->setOperation($user_id, $op_name, $count_before, $count_days, $count_days, $start);
        /* 
        $sql_op = "INSERT INTO operation (
            operation_user_id, operation_name, operation_count_before, operation_count, operation_count_after, operation_date)
            VALUES (?, ?, ?, ?, ?, ?)";
        $op_name = "Gived Bonus Certificate";
        $count_before = 0;
        if ($stmt_op = mysqli_prepare($conn, $sql_op)) {
            mysqli_stmt_bind_param(
                $stmt_op,
                "isiiis",
                $user_id,
                $op_name,
                $count_before,
                $count_days,
                $count_days,
                $start,
            );
            mysqli_stmt_execute($stmt_op);
        }

        mysqli_close($conn); */

        $response['confirm'] = 'Bonus Certificate created';

        return $response;
    }
}
