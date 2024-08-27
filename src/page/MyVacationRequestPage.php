<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Table\MyVacationRequestTable;
use Sites\Services\DBService;


class MyVacationRequestPage
{
    public function buildPage()
    {
        $service = new DBService;
        $label = ["uservacationrequest.*"];
        $data = $service->getData($service->setLabel($label), "`uservacationrequest`
                    JOIN vacation_request as vq 
                    ON uservacationrequest.vacation_id = vq.vacation_id 
                    WHERE vq.vacation_user_id = " . $_SESSION['user_id']);

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $linksHtml = $twig->render('links.twig.html', ['links' => (new \Sites\Links)->buildUserLinks(), 'session' => $_SESSION]);

        $content = [
            ['name' => 'user-links', 'content' => $linksHtml],
            ['name' => 'user-table', 'content' => (new MyVacationRequestTable)->buildTable($data)],
        ];

        return new Page('My vacation request', $content, '');
    }
}
