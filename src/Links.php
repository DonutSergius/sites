<?php

$currentPage = basename($_SERVER['REQUEST_URI']);

$links = [
    ['url' => 'home', 'title' => 'Home'],
    ['url' => 'create-vacation', 'title' => 'Create vacation'],
];

foreach ($links as &$link) {
    $link['active'] = $link['url'] === $currentPage;
}
