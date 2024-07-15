<?php
require 'vendor/autoload.php';
require 'src/Links.php';

$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader);

$pageKey = isset($_GET['page']) ? $_GET['page'] : 'home';

$message = '';

// Перевірка методу запиту
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pageKey === 'create-vacation') {
    // Обробка даних з форми
    $dateStart = $_POST['date-start'] ?? null;
    $dateEnd = $_POST['date-end'] ?? null;
    $approval = $_POST['approval'] ?? null;
    $reason = $_POST['reason'] ?? null;

    // Перевірка обов'язкових полів
    if ($dateStart && $dateEnd && $approval && $reason) {
        // Тут ви можете обробити дані, наприклад, зберегти їх у базі даних
        $message = 'Гуд.';
    } else {
        $message = 'Будь ласка, заповніть всі поля форми.';
    }
    return;
}


switch ($pageKey) {
    case 'home':
        require 'src/Pages/home-page.php';
        $page = $home_page;
        break;
    case 'about':
        require 'src/Pages/about-page.php';
        $page = $about_page;
        break;
    case 'create-vacation':
        require 'src/Pages/vacations/create-vacation-page.php';
        $page = $create_vacation;
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
    'message' => $message
];

echo $twig->render('page.twig.html', $pageData);
