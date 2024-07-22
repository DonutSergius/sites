<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require PROJECT_ROOT . '/src/class/Form.php';
require PROJECT_ROOT . '/vendor/autoload.php';

function buildLoginUserForm()
{
    $nameForm = 'login_user_form';
    $action = 'src/formActions/login_user.php';
    $scripts = 'src/js/formScripts/login_user_form.js';

    $inputs = getInputsElements();

    $loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT . '/templates/');
    $twig = new \Twig\Environment($loader);

    $login_user_form = new Form($nameForm, $action, $inputs, $scripts);

    return $twig->render('form.twig.html', $login_user_form->toArray());
}

function getInputsElements()
{
    return [
        [
            'type' => 'text',
            'id' => 'user_nickname',
            'name' => 'user_nickname',
            'field' => 'user_nickname',
        ],
        [
            'type' => 'password',
            'id' => 'user_password',
            'name' => 'user_password',
            'field' => 'user_password',
        ],
    ];
}
