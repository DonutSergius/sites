<?php

namespace Sites\Form;

use Sites\Class\Form;
use Sites\Services\DBService;
use Sites\Class\Elements;

class CreateUserForm
{
    public function buildForm()
    {
        $nameForm = 'cretae_user_form';
        $action = 'src/FormActions/create_user.php';
        $scripts = 'src/JS/FormScripts/create_user_form.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $create_user_form = new Form($nameForm, $action, $inputs, $scripts);

        return $twig->render('form.twig.html', $create_user_form->toArray());
    }

    private function getInputsElements()
    {
        $service = new DBService;

        $data = $service->getData(["*"], 'role');

        $options = [];
        while ($row = mysqli_fetch_assoc($data)) {
            $options[$row['role_id']] = $row['role_name'];
        }

        return [
            (new Elements('Enter user nickname', 'text', 'user_nickname'))->createInput(),
            (new Elements('Select user role', 'select', 'user_role'))->createSelect($options),
            (new Elements('Enter user first name', 'text', 'user_firstname'))->createInput(),
            (new Elements('Enter user last name', 'text', 'user_lastname'))->createInput(),
            (new Elements('Enter user email', 'email', 'user_email'))->createInput(),
            (new Elements('Enter user password', 'password', 'user_password'))->createInput(),
        ];
    }
}
