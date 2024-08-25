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
        $label = ["vi.user, vi.vacation_type, vi.vacation_date_type, vi.vacation_date_start, vi.vacation_date_end, vi.vacation_reason"];
        $data = $service->getData($service->setLabel($label), "vacation_info AS vi 
            JOIN vacation_request AS v ON v.vacation_id = vi.vacation_id
            WHERE v.vacation_status = 'Pending'
            ORDER BY vi.vacation_id DESC");

        $content = [
            ['name' => 'user-table', 'content' => (new VacationTable)->buildVacationTable($data)],
        ];

        return new Page('Approval Vacation', $content, '');
    }
}
