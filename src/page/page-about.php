<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require PROJECT_ROOT . '/src/class/Page.php';

$content = [
    ['name' => 'first', 'content' => 'New content about us'],
];

$about_page = new Page('About us', $content, '');
