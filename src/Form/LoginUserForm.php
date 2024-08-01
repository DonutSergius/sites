<?php

namespace Sites\Form;

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require PROJECT_ROOT . '/vendor/autoload.php';

use Sites\Class\Form;

/**
 * Create form.
 * 
 * Require Class Form.
 */
class LoginUserForm
{
    /**
     * Function to build form.
     */
    public function buildLoginUserForm()
    {
        $nameForm = 'login_user_form';
        $action = 'src/FormActions/login_user.php';
        $scripts = 'src/js/formScripts/login_user_form.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT . '/templates/');
        $twig = new \Twig\Environment($loader);

        $login_user_form = new Form($nameForm, $action, $inputs, $scripts);

        return $twig->render('form.twig.html', $login_user_form->toArray());
    }

    /**
     * Function to get elements in form.
     */
    private function getInputsElements()
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
}
