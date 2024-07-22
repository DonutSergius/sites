<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require PROJECT_ROOT . '/vendor/autoload.php';
require PROJECT_ROOT . '/src/class/Page.php';
require PROJECT_ROOT . '/src/form/form-login-user.php';


function buildLoginUserPage()
{
    $content = [
        ['name' => 'login_user', 'content' =>  buildLoginUserForm()],
    ];

    return new Page('Login', $content, '');
}
