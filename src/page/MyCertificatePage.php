<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Table\MyCertificatesTable;
use Sites\Services\DBService;
use Sites\Services\Certificate;


class MyCertificatePage
{
    public function buildPage()
    {
        $labels = ['certificate_name', 'certificate_date_start', 'certificate_date_end', 'certificate_count_days', 'certificate_type'];
        $certificatesResult = (new Certificate)->getActiveCertificates($_SESSION['user_id']);
        if ($certificatesResult) {
            $certificates = $certificatesResult->fetch_all(MYSQLI_ASSOC);

            $data = array_map(function ($certificate) use ($labels) {
                return array_intersect_key($certificate, array_flip($labels));
            }, $certificates);
        } else {
            $data = [];
        }

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $linksHtml = $twig->render('links.twig.html', ['links' => (new \Sites\Links)->buildUserLinks(), 'session' => $_SESSION]);

        $content = [
            ['name' => 'user-links', 'content' => $linksHtml],
            ['name' => 'user-table', 'content' => (new MyCertificatesTable)->buildTable($data)],
        ];

        return new Page('My Operations', $content, '');
    }
}
