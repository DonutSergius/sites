<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require PROJECT_ROOT . '/vendor/autoload.php';
require PROJECT_ROOT . '/src/class/Page.php';
require PROJECT_ROOT . '/src/form/form-create-vacation.php';

function buildCreateVacationPage()
{
    $content = [
        ['name' => 'create_vacation', 'content' =>  buildVacationForm()],
    ];

    return new Page('Create vacation', $content, '');
}
