<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require PROJECT_ROOT . '/vendor/autoload.php';
require PROJECT_ROOT . '/src/class/Page.php';
require PROJECT_ROOT . '/src/form/form-create-vacation.php';

$loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT . '/templates/');
$twig = new \Twig\Environment($loader);

$formHtml = $linksHtml = $twig->render('form.twig.html', $create_vacation_form->toArray());
$content = [
    ['name' => $create_vacation_form->getNameForm(), 'content' => $formHtml],
];

$create_vacation = new Page('Create vacation', $content, '');
