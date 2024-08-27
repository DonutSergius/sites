<?php

namespace Sites\Form;

use Sites\Class\Form;
use Sites\Class\Elements;
use Sites\Services\DBService;
use Sites\Services\Certificate;
use DateTime;

class CreateVacationForm
{
    function buildForm()
    {
        $nameForm = 'сreate_vacation';
        $action = 'src/FormActions/create_vacation.php';
        $scripts = 'src/js/formScripts/vacation_form.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $create_vacation_form = new Form($nameForm, $action, $inputs, $scripts);

        return $twig->render('form.twig.html', $create_vacation_form->toArray());
    }

    function getInputsElements()
    {
        return [
            (new Elements('Select type vacation', 'select', 'vacation-type'))->createSelect([
                'paid' => 'Paid',
                'unpaid' => 'Unpaid',
            ]),
            (new Elements('Select time unpaid vacation', 'select', 'vacation-time'))->createSelect([
                'fullDay' => 'Full day',
                'specificTime' => 'Specific Time',
            ]),
            (new Elements('Select date start', 'date', 'date-start'))->createInput(),
            (new Elements('Select date end', 'date', 'date-end'))->createInput(),
            (new Elements('Select date and time start', 'datetime-local', 'datetime-start'))->createInput(),
            (new Elements('Select date and time end', 'datetime-local', 'datetime-end'))->createInput(),
            (new Elements('Enter user nickname who approval this request', 'text', 'approval'))->createInput(),
            (new Elements('Reason', 'textarea', 'reason'))->createInput(),
        ];
    }

    private function checkUserNickname($approval)
    {
        $admin_user_id = NULL;
        $conn = (new DBService)->getDBConf();
        $sql = "SELECT user_id FROM `user` WHERE user_nickname = ? AND (user_role = '2' OR user_role = '3')";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $approval);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = $result->fetch_assoc()) {
                $admin_user_id = $row['user_id'];
            }

            mysqli_stmt_close($stmt);
        }

        return $admin_user_id;
    }

    public function validationForm()
    {
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
                $errors = $this->checkFullDayVacation($dateStart, $dateEnd);
                $response['error'] = implode(". \n", $errors);
            } else {
                $response['error'] = 'Please fill all fields';
            }
        } else {
            if ($vacationTime === "specificTime") {
                if ($datetimeStart && $datetimeEnd && $approval && $reason) {
                    $errors = $this->checkSpecificTimeVacation($datetimeStart, $datetimeEnd);
                    $response['error'] = implode(". \n", $errors);
                } else {
                    $response['error'] = 'Please fill all fields';
                }
            } else {
                if ($dateStart && $dateEnd && $approval && $reason) {
                    $errors = $this->checkFullDayVacation($dateStart, $dateEnd);
                    $response['error'] = implode(". \n", $errors);
                } else {
                    $response['error'] = 'Please fill all fields';
                }
            }
        }

        if ($approval) {
            $admin_user_id = $this->checkUserNickname($approval);
            if ($admin_user_id === NULL) {
                $value = $response['error'];
                $newLine = 'User dont exist or are not PM';
                $response['error'] = $value . "\n" . $newLine;
            }
        }

        if (empty($response['error'])) {
            $response = $this->submitForm($admin_user_id);
        }

        if (isset($response['error'])) {
            $response_log['error'] = $response['error'];
        }

        echo json_encode($response);
    }

    private function submitForm($admin_user_id)
    {
        $vacationTime = $_POST['vacation-time'] ?? null;

        if ($vacationTime == 'fullDay') {
            $start = new DateTime($_POST['date-start']);
            $end = new DateTime($_POST['date-end']);
        } else {
            $start = new DateTime($_POST['datetime-start']);
            $end = new DateTime($_POST['datetime-end']);
        }

        $date_start = $start->format('Y-m-d H:i:s');
        $date_end = $end->format('Y-m-d H:i:s');
        $status = "Pending";

        $sql = "INSERT INTO vacation_request 
        (vacation_user_id, vacation_type, vacation_date_type, vacation_date_start, 
        vacation_date_end, vacation_reason, vacation_status,vacation_approval) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $conn = (new DBService)->getDBConf();
        $user_id = $_SESSION['user_id'];
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param(
                $stmt,
                "issssssi",
                $user_id,
                $_POST['vacation-type'],
                $vacationTime,
                $date_start,
                $date_end,
                $_POST['date-end'],
                $status,
                $admin_user_id
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
        return $response;
    }

    private function checkFullDayVacation($date_start, $date_end)
    {
        $start = new DateTime($date_start);
        $end = new DateTime($date_end);

        $errors = array_merge(
            $this->cheсkStartDate($start),
            $this->cheсkStartEndDate($start, $end)
        );

        return $errors;
    }

    private function checkSpecificTimeVacation($date_start, $date_end)
    {
        $start = new DateTime($date_start);
        $end = new DateTime($date_end);
        $errors = array_merge(
            $this->cheсkStartDate($start),
            $this->cheсkStartEndDate($start, $end),
            $this->checkDateTime($start, $end),
        );

        return $errors;
    }

    private function checkDateTime($dateStart, $dateEnd)
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

    private function cheсkStartEndDate($dateStart, $dateEnd)
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

        $userBalance = (new Certificate)->getUserBalance($_SESSION['user_id']);

        if ($userBalance < $daysDifference) {
            $errors[] = 'You have only ' . $userBalance . ' days';
        }

        return $errors;
    }

    private function cheсkStartDate($dateStart)
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
}
