<?php

namespace Sites\Table;

use Sites\Class\Table;

class ApprovalVacationTable
{
    function buildTable($result)
    {
        $table_name = 'approval-vacation-list';
        $vacation_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (!empty($vacation_data)) {
            $first_row = $vacation_data[0];
            $header_labels = (new Table)->getVacationLabels(array_keys($first_row));
            $body_rows = $this->getBodyRows($vacation_data, array_keys($first_row));
        } else {
            $header_labels = [];
            $body_rows = [];
        }

        $header_labels[] = [
            'title' => 'Action',
            'machine_name' => 'action'
        ];

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
                    $value = (new Table)->formatDate($value);
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


            $body_rows[] = $body_row;
        }

        return $body_rows;
    }
}
