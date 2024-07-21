<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require_once PROJECT_ROOT . '/db_config.php';
require PROJECT_ROOT . '/src/class/Table.php';
require PROJECT_ROOT . '/vendor/autoload.php';

function buildVacationTable($sql)
{
    $table_name = 'vacation-list';
    $header_lables = getHeaderLables();

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $result = mysqli_query($conn, $sql);
    $vacation_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);

    $body_rows = getBodyRows($vacation_data);

    $vacationTable = new Table($table_name, $header_lables, $body_rows);
    $loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT . '/templates/');
    $twig = new \Twig\Environment($loader);

    return $twig->render('table.twig.html', $vacationTable->toArray());
}

function getBodyRows($vacation_data)
{
    $body_rows = [];

    foreach ($vacation_data as $row) {
        $body_row = [];
        foreach ($row as $column_name => $value) {
            $body_row[] = [
                'class' => $column_name,
                'value' => $value
            ];
        }
        $body_rows[] = $body_row;
    }

    return  $body_rows;
}

function getHeaderLables()
{
    return [
        [
            'class' => 'id',
            'name' => 'Id',
        ],
        [
            'class' => 'vacation_type',
            'name' => 'Type',
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
}
