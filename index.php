<?php

require 'vendor/autoload.php';

use Sites\Page;

session_start();

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader);

if (empty($_SESSION['user_role'])) {
    $page = (new Sites\Page\LoginUserPage())->buildPage();

    $titleHtml = $twig->render('page-title.twig.html', ['title' => $page->getTitle()]);
    $contentHtml = $twig->render('page-content.twig.html', ['contents' => $page->getContent()]);
    $sidebarHtml = $twig->render('page-sidebar.twig.html', ['sidebar' => $page->getSidebar()]);

    $pageData = [
        'links' => '',
        'title' => $titleHtml,
        'content' => $contentHtml,
        'sidebar' => $sidebarHtml,
    ];
    echo $twig->render('page.twig.html', $pageData);
    exit;
}

$pageKey = $_GET['page'] ?? 'home';
$pages = getPagesList();

if (isset($pages[$pageKey])) {
    $pageConfig = $pages[$pageKey];

    if (isset($pageConfig['action'])) {
        $pageConfig['action']();
    } else {
        $page = $pageConfig['function']();
    }
} else {
    echo $twig->render('page-not-found.twig.html', ['content' => $_SERVER['REQUEST_METHOD']]);
    return;
}

$linksHtml = $twig->render('links.twig.html', ['links' => (new Sites\Links)->buildMainLinks(), 'session' => $_SESSION]);
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

function getPagesList()
{
    return [
        'home' => [
            'function' => function () {
                return (new Page\HomePage())->buildPage();
            },
        ],
        'create-vacation' => [
            'function' => function () {
                return (new Page\Vacations\CreateVacationPage())->buildPage();
            },
        ],
        'logout' => [
            'action' => function () {
                session_destroy();
                header('Location: /sites/home');
                exit();
            }
        ],
        'user-cabinet' => [
            'function' => function () {
                return (new Page\UserCabinetPage())->buildPage();
            },
        ],
        'my-vacation-request' => [
            'function' => function () {
                return (new Page\MyVacationRequestPage())->buildPage();
            },
        ],
        'create-user' => [
            'function' => function () {
                return (new Page\CreateUserPage())->buildPage();
            },
        ],
        'create-role' => [
            'function' => function () {
                return (new Page\CreateRolePage())->buildPage();
            },
        ],
        'create-certificate' => [
            'function' => function () {
                return (new Page\CreateCertificatePage())->buildPage();
            },
        ],
        'approval-vacation' => [
            'function' => function () {
                return (new Page\ApprovalVacationPage())->buildPage();
            },
        ],
        'my-operations' => [
            'function' => function () {
                return (new Page\MyOperationPage())->buildPage();
            },
        ],
    ];
}
