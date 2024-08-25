<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Table\VacationTable;
use Sites\Services\DBService;


class MyOperationPage
{
    public function buildPage()
    {
        $service = new DBService;
        $label = ["operation_name, operation_count_before, operation_count, operation_count_after, operation_date"];
        $data = $service->getData($service->setLabel($label), "`operation`");

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $linksHtml = $twig->render('links.twig.html', ['links' => (new \Sites\Links)->buildUserLinks(), 'session' => $_SESSION]);

        $content = [
            ['name' => 'user-links', 'content' => $linksHtml],
            ['name' => 'user-table', 'content' => (new VacationTable)->buildVacationTable($data)],
        ];

        return new Page('My Operations', $content, '');
    }
}
