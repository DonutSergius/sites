<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Table\VacationTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require_once PROJECT_ROOT . '/db_config.php';


class MyVacationRequestPage
{
    public function buildPage()
    {
        $sql = "SELECT * FROM vacation_request WHERE vacation_user_id =" . $_SESSION['user_id'] . " ORDER BY vacation_id DESC";

        $content = [
            ['name' => 'user-table', 'content' => (new VacationTable)->buildVacationTable($sql, 2)],
        ];

        return new Page('My vacation request', $content, '');
    }
}
