<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require PROJECT_ROOT . '/src/class/Page.php';

$content = [
    ['name' => 'first', 'content' => 'First field'],
    ['name' => 'second', 'content' => 'Second field'],
    ['name' => 'Third', 'content' => 'Third field'],
];

$home_page = new Page('Home', $content, 'Test sidebar content');
