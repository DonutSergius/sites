<?php
require 'vendor/autoload.php';

session_start();

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader);

if (empty($_SESSION['user_role'])) {
    $page = (new Sites\Page\LoginUserPage())->buildLoginUserPage();

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

$linksHtml = $twig->render('links.twig.html', ['links' => (new Sites\Links)->buildLinks(), 'session' => $_SESSION]);
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
                return (new \Sites\Page\HomePage())->buildHomePage();
            },
        ],
        'create-vacation' => [
            'function' => 'Sites\\Page\\Vacations\\CreateVacationPage::buildCreateVacationPage'
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
                return (new \Sites\Page\UserCabinetPage())->buildUserCabinet();
            },
        ],
        'my-vacation-request' => [
            'function' => 'Sites\\Page\\MyVacationRequestPage::buildMyVacationRequest'
        ],
        'create-user' => [
            'function' => 'Sites\\Page\\CreateUserPage::buildCreateUserPage'
        ],
        'create-role' => [
            'function' => 'Sites\\Page\\CreateRolePage::buildCreateRolePage'
        ],
    ];
}
