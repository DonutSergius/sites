<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Table\VacationTable;
use Sites\Services\DBService;


class MyVacationRequestPage
{
    public function buildPage()
    {
        $service = new DBService;
        $label = ["vacation_type, vacation_date_type, vacation_date_start, vacation_date_end, vacation_reason, vacation_status"];
        $data = $service->getData($service->setLabel($label), "vacation_request WHERE vacation_user_id =" . $_SESSION['user_id'] . " ORDER BY vacation_id DESC");

        $content = [
            ['name' => 'user-table', 'content' => (new VacationTable)->buildVacationTable($data)],
        ];

        return new Page('My vacation request', $content, '');
    }
}
