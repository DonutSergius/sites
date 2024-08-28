<?php

namespace Sites\Table;

use Sites\Class\Table;
use DateTime;

class MyVacationRequestTable
{
    private $table;

    public function __construct()
    {
        $this->table = new Table();
    }


    function buildTable($result)
    {
        $table_name = 'my-vacation-request-list';
        $vacation_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (!empty($vacation_data)) {
            $first_row = $vacation_data[0];
            $header_labels = $this->table->getVacationLabels(array_keys($first_row));
            $body_rows = $this->getBodyRows($vacation_data, array_keys($first_row));
            $header_labels[] = [
                'title' => 'Cancel',
                'machine_name' => 'cancel'
            ];
        } else {
            $header_labels = [];
            $body_rows = [];
        }

        $this->table->setName($table_name);
        $this->table->setHeaders($header_labels);
        $this->table->setRows($body_rows);

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        return $twig->render('table.twig.html', $this->table->toArray());
    }

    function getBodyRows($vacation_data, $columns)
    {
        $body_rows = [];
        $currernt_time = new DateTime();
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
                    $value = $this->table->formatDate($value);
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

            $current_time_formatted = $currernt_time->format('Y-m-d');

            if ($row['vacation_status'] != "canceled" && $row['vacation_date_start'] > $current_time_formatted) {
                $body_row[] = [
                    'class' => 'workflow',
                    'element' => 'vacation',
                    'action' => '/sites/src/FormActions/cancel.php',
                    'id' => $element_id,
                    'value' => 'Cancel',
                ];
            }
            $body_rows[] = $body_row;
        }

        return $body_rows;
    }
}
