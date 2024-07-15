<?php
require '/xampp/htdocs/sites/vendor/autoload.php';
require '/xampp/htdocs/sites/src/Page.php';
require 'create-vacation-form.php';

$loader = new \Twig\Loader\FilesystemLoader('/xampp/htdocs/sites/templates/');
$twig = new \Twig\Environment($loader);

$formHtml = $linksHtml = $twig->render('form.twig.html', $create_vacation_form->toArray());
$content = [
    ['name' => $create_vacation_form->getNameForm(), 'content' => $formHtml],
];

$create_vacation = new Page('Create vacation', $content, '');
