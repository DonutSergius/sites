<?php
require 'vendor/autoload.php';
require 'src/Links.php';

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader);

$pageKey = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($pageKey) {
    case 'home':
        require 'src/page/page-home.php';
        $page = buidHomePage();
        break;
    case 'about':
        require 'src/page/page-about.php';
        $page = $about_page;
        break;
    case 'create-vacation':
        require 'src/page/vacations/page-create-vacation.php';
        $page = buildCreateVacationPage();
        break;
    default:
        echo $twig->render('page-not-found.twig.html', ['content' => $_SERVER['REQUEST_METHOD']]);
        return;
}

$linksHtml = $twig->render('page-links.twig.html', ['links' => $links]);
$titleHtml = $twig->render('page-title.twig.html', ['title' => $page->getTitle()]);
$contentHtml = $twig->render('page-content.twig.html', ['contents' => $page->getContent()]);
$sidebarHtml = $twig->render('page-sidebar.twig.html', ['sidebar' => $page->getSidebar()]);

$pageData = [
    'links' => $linksHtml,
    'title' => $titleHtml,
    'content' => $contentHtml,
    'sidebar' => $sidebarHtml,
];

echo $twig->render('page.twig.html', $pageData);
