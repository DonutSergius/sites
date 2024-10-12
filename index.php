<?php

require 'vendor/autoload.php';

use Sites\Page;
use Sites\Links;

session_start();

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader);

if (empty($_SESSION['user_role'])) {
    $page = (new Sites\Page\LoginUserPage())->buildPage();

    $login = $twig->render('login-user-form.twig.html', ['title' => $page->getTitle(), 'contents' => $page->getContent()]);

    $titleHtml = $twig->render('page-title.twig.html', ['title' => $page->getTitle()]);
    $contentHtml = $twig->render('page-content.twig.html', ['contents' => $page->getContent()]);
    $sidebarHtml = $twig->render('page-sidebar.twig.html', ['sidebar' => $page->getSidebar()]);

    $pageData = [
        'links' => '',
        'title' => '',
        'content' => $login,
        'sidebar' => '',
    ];
    echo $twig->render('page.twig.html', $pageData);
    exit;
}

$pageKey = $_GET['page'] ?? 'home';
$pages = getPagesList();
$linksGlobal = (new Links)->buildMainLinks();
$linksUser = (new Links)->buildUserLinks();
$allLinks = array_merge($linksGlobal, $linksUser);
$urls = array_column($allLinks, 'url');

if (isset($pages[$pageKey])) {
    $pageConfig = $pages[$pageKey];

    if (!in_array($pageKey, $urls)) {
        $pageTitle = "Access denied";
        $pageContent = $twig->render('page-access-denied.twig.html');
        $pageSidebar = "";
    } else {
        if (isset($pageConfig['action'])) {
            $pageConfig['action']();
        } else {
            $page = $pageConfig['function']();

            $pageTitle = $page->getTitle();
            $pageContent = $page->getContent();
            $pageSidebar = $page->getSidebar();
        }
    }
} else {
    $pageTitle = "Not Found";
    $pageContent = $twig->render('page-not-found.twig.html');
    $pageSidebar = "";
}

$linksHtml = $twig->render('links.twig.html', ['links' => $linksGlobal, 'session' => $_SESSION]);
$titleHtml = $twig->render('page-title.twig.html', ['title' => $pageTitle]);
$contentHtml = $twig->render('page-content.twig.html', ['contents' => $pageContent]);
$sidebarHtml = $twig->render('page-sidebar.twig.html', ['sidebar' => $pageSidebar]);

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
                return (new Page\CreateVacationPage())->buildPage();
            },
        ],
        'logout' => [
            'action' => function () {
                session_destroy();
                header('Location: home');
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
        'my-certificates' => [
            'function' => function () {
                return (new Page\MyCertificatePage())->buildPage();
            },
        ],
    ];
}
