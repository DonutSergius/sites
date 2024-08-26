<?php

namespace Sites\Table;

use Sites\Class\Table;

class VacationTable
{
    function buildVacationTable($result)
    {
        $table_name = 'vacation-list';
        $vacation_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (!empty($vacation_data)) {
            $first_row = $vacation_data[0];
            $header_labels = $this->generateHeaderLabels(array_keys($first_row));
            $body_rows = $this->getBodyRows($vacation_data, array_keys($first_row));
        } else {
            $header_labels = [];
            $body_rows = [];
        }

        $pageKey = $_GET['page'] ?? 'home';

        if ($pageKey == 'my-vacation-request') {
            $header_labels[] = [
                'title' => 'Cancel',
                'machine_name' => 'cancel'
            ];
        }
        if ($pageKey == 'approval-vacation') {
            $header_labels[] = [
                'title' => 'Action',
                'machine_name' => 'action'
            ];
        }

        $vacationTable = new Table($table_name, $header_labels, $body_rows);
        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        return $twig->render('table.twig.html', $vacationTable->toArray());
    }

    function getBodyRows($vacation_data, $columns)
    {
        $body_rows = [];
        $element_id = 0;
        foreach ($vacation_data as $row) {
            $body_row = [];
            if (isset($row['vacation_date_type'])) {
                $date_type = $row['vacation_date_type'];
            } else $date_type = NULL;

            foreach ($columns as $column_name) {
                $value = $row[$column_name];

                if (
                    $date_type == 'fullDay' &&
                    ($column_name == 'vacation_date_start' || $column_name == 'vacation_date_end')
                ) {
                    $value = $this->formatDate($value);
                }

                if ($column_name == 'vacation_id') {
                    $element_id = $value;
                    continue;
                }

                $body_row[] = [
                    'class' => $column_name,
                    'value' => $value
                ];
            }

            $pageKey = $_GET['page'] ?? 'home';

            if ($pageKey == 'my-vacation-request' && $row['vacation_status'] != "canceled") {
                $body_row[] = [
                    'class' => 'workflow',
                    'element' => 'vacation',
                    'action' => '/sites/src/FormActions/cancel.php',
                    'id' => $element_id,
                    'value' => 'Cancel',
                ];
            }
            if ($pageKey == 'approval-vacation') {
                $body_row[] = [
                    'class' => 'workflow',
                    'element' => 'vacation',
                    'action' => '/sites/src/FormActions/approve.php',
                    'id' => $element_id,
                    'value' => 'Approve',
                ];
                $body_row[] = [
                    'class' => 'workflow',
                    'element' => 'vacation',
                    'action' => '/sites/src/FormActions/disapprove.php',
                    'id' => $element_id,
                    'value' => 'Disapprove',
                ];
            }

            $body_rows[] = $body_row;
        }

        return $body_rows;
    }

    function formatDate($date_value, $format = 'Y-m-d')
    {
        $date = new \DateTime($date_value);
        return $date->format($format);
    }

    function generateHeaderLabels($columns)
    {
        $all_headers = [
            'user_nickname' => 'User',
            'vacation_type' => 'Type',
            'vacation_date_type' => 'Time type',
            'vacation_date_start' => 'Date start',
            'vacation_date_end' => 'Date end',
            'vacation_reason' => 'Reason',
            'vacation_status' => 'Status',
            'vacation_approval' => 'Approval',
            // TEMP TITLE
            'operation_name' => 'Name',
            'operation_count_before' => 'Before',
            'operation_count' => 'Action',
            'operation_count_after' => 'Result',
            'operation_date' => 'Date',
        ];

        $header_labels = [];
        foreach ($columns as $column) {
            if (isset($all_headers[$column])) {
                $header_labels[] = [
                    'title' => $all_headers[$column],
                    'machine_name' => $column
                ];
            }
        }

        return $header_labels;
    }
}
