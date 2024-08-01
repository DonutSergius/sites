<?php

namespace Sites\Page;

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require_once PROJECT_ROOT . '/db_config.php';

use Sites\Class\Page;
use Sites\Table\VacationTable;

/**
 * Create home page.
 * 
 * Require Class Page.
 * Require Table table-vacation.
 */
class HomePage
{
    /**
     * Function build table on page.
     */
    function buildHomePage()
    {
        $sql = "SELECT * FROM vacation_info ORDER BY vacation_id DESC";

        $content = [
            ['name' => 'homepage-table', 'content' => (new VacationTable)->buildVacationTable($sql)],
        ];

        return new Page('Home', $content, '');
    }
}
