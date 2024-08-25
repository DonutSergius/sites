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
        $labels = [];
        $data = $service->getData($service->setLabel($labels), 'homepageview ORDER BY vacation_id DESC');

        $content = [
            ['name' => 'homepage-table', 'content' => (new VacationTable)->buildVacationTable($data)],
        ];

        return new Page('Home', $content, '');
    }
}
