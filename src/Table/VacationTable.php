<?php

namespace Sites\Table;

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require_once PROJECT_ROOT . '/db_config.php';

use Sites\Class\Table;

/**
 * Create vacation table.
 * 
 * Require Class table
 */
class VacationTable
{

    /**
     * Function to build table.
     */
    function buildVacationTable($sql, $type = 1)
    {
        $table_name = 'vacation-list';
        $header_lables = $this->getHeaderLables($type);
        if ($type == 2) {
        }

        $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $result = mysqli_query($conn, $sql);
        $vacation_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_close($conn);

        $body_rows = $this->getBodyRows($vacation_data);

        $vacationTable = new Table($table_name, $header_lables, $body_rows);
        $loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT . '/templates/');
        $twig = new \Twig\Environment($loader);

        return $twig->render('table.twig.html', $vacationTable->toArray());
    }

    /**
     * Get table rows.
     */
    function getBodyRows($vacation_data)
    {
        $body_rows = [];

        foreach ($vacation_data as $row) {
            $body_row = [];
            $date_type = $row['vacation_date_type'];

            foreach ($row as $column_name => $value) {
                if ($column_name == 'vacation_user_id') {
                    continue;
                }

                if (
                    $date_type == 'fullDay' &&
                    ($column_name == 'vacation_date_start' || $column_name == 'vacation_date_end')
                ) {
                    $value = $this->formatDate($value);
                }

                $body_row[] = [
                    'class' => $column_name,
                    'value' => $value
                ];
            }
            $body_rows[] = $body_row;
        }

        return  $body_rows;
    }

    /**
     * Function to convert time.
     */
    function formatDate($date_value, $format = 'Y-m-d')
    {
        $date = new \DateTime($date_value);
        return $date->format($format);
    }

    /**
     * Get table header columns.
     */
    function getHeaderLables($type)
    {
        $labels = [
            [
                'class' => 'id',
                'name' => 'Id',
            ],
        ];

        if ($type != 2) {
            $labels[] = [
                'class' => 'user_created',
                'name' => 'User',
            ];
        }

        $additional_labels = [
            [
                'class' => 'vacation_type',
                'name' => 'Type',
            ],
            [
                'class' => 'vacation_time',
                'name' => 'Time',
            ],
            [
                'class' => 'date_start',
                'name' => 'Start',
            ],
            [
                'class' => 'date_end',
                'name' => 'End',
            ],
            [
                'class' => 'vacation_reason',
                'name' => 'Reason',
            ],
            [
                'class' => 'vacation_approval',
                'name' => 'Approval',
            ],
        ];

        $labels = array_merge($labels, $additional_labels);

        return $labels;
    }
}
