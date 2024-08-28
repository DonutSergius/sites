<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Table\ApprovalVacationTable;
use Sites\Services\DBService;
use DateTime;

class ApprovalVacationPage
{
    public function buildPage()
    {
        $service = new DBService;
        $current_time = new DateTime();
        $current_time_format = $current_time->format("Y-m-d H:i:s");
        $label = ["va.*"];
        $data = $service->getData($label, "`vacationtoapproval` as va ", "JOIN vacation_request as vq 
            ON vq.vacation_id = va.vacation_id 
            WHERE vq.vacation_approval = " . $_SESSION['user_id'] . "
            AND va.vacation_date_start > '" . $current_time_format . "'");
        $content = [
            ['name' => 'user-table', 'content' => (new ApprovalVacationTable)->buildTable($data)],
        ];

        return new Page('Approval Vacation', $content, '');
    }
}
