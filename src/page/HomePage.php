<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Table\HomePageTable;
use Sites\Services\DBService;

class HomePage
{
    public function buildPage()
    {
        $service = new DBService;
        $labels = ['hv.*'];
        $data = $service->getData($service->setLabel($labels), '`homepageview` as hv 
                JOIN vacation_request as vr 
                ON hv.vacation_id = vr.vacation_id 
                WHERE vr.vacation_status = "Approved" AND TIMESTAMP(hv.vacation_date_start) > CURRENT_TIMESTAMP
                ORDER BY vacation_id DESC');

        $content = [
            ['name' => 'homepage-table', 'content' => (new HomePageTable)->buildTable($data)],
        ];

        return new Page('Home', $content, '');
    }
}
