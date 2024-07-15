<?php
require '/xampp/htdocs/sites/src/Page.php';

$content = [
    ['name' => 'first', 'content' => 'First field'],
    ['name' => 'second', 'content' => 'Second field'],
    ['name' => 'Third', 'content' => 'Third field'],
];

$home_page = new Page('Home', $content, 'Test sidebar content');
