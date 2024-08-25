<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Table\VacationTable;
use Sites\Services\DBService;

class HomePage
{
    public function buildPage()
    {
        $service = new DBService;
        $labels = ['user, vacation_type', 'vacation_date_type', 'vacation_date_start', 'vacation_date_end', 'vacation_reason'];
        $data = $service->getData($service->setLabel($labels), 'vacation_info ORDER BY vacation_id DESC');

        $content = [
            ['name' => 'homepage-table', 'content' => (new VacationTable)->buildVacationTable($data)],
        ];

        return new Page('Home', $content, '');
    }
}
