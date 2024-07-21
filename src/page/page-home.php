<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require_once PROJECT_ROOT . '/db_config.php';
require PROJECT_ROOT . '/src/class/Page.php';
require PROJECT_ROOT . '/src/table/table-vacation.php';

function buidHomePage()
{
    $sql = "SELECT * FROM Vacation";

    $content = [
        ['name' => 'homepage-table', 'content' => buildVacationTable($sql)],
    ];

    return new Page('Home', $content, 'Test sidebar content');
}
