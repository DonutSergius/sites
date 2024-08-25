<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Table\VacationTable;
use Sites\Services\DBService;

class ApprovalVacationPage
{
    public function buildPage()
    {
        $service = new DBService;
        $label = ["va.*"];
        $data = $service->getData($service->setLabel($label), "`vacationtoapproval` as va 
            JOIN vacation_request as vq 
            ON vq.vacation_id = va.vacation_id 
            WHERE vq.vacation_approval = " . $_SESSION['user_id'] . "
            ORDER BY va.vacation_id DESC");
        $content = [
            ['name' => 'user-table', 'content' => (new VacationTable)->buildVacationTable($data)],
        ];

        return new Page('Approval Vacation', $content, '');
    }
}
