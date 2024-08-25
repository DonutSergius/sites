<?php

namespace Sites\Form;

use Sites\Class\Form;
use Sites\Class\Elements;

class LoginUserForm
{
    public function buildForm()
    {
        $nameForm = 'login_user_form';
        $action = 'src/FormActions/login_user.php';
        $scripts = 'src/js/formScripts/login_user_form.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $login_user_form = new Form($nameForm, $action, $inputs, $scripts);

        return $twig->render('form.twig.html', $login_user_form->toArray());
    }

    private function getInputsElements()
    {
        return [
            (new Elements('Your nickname', 'text', 'user_nickname'))->createInput(),
            (new Elements('Password', 'password', 'user_password'))->createInput(),
        ];
    }
}
