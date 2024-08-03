<?php

namespace Sites\Form;

use Sites\Class\Form;

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require_once PROJECT_ROOT . '/db_config.php';

/**
 * Create form.
 * 
 * Require Class Form.
 */
class CreateUserForm
{
    /**
     * Function to build form.
     */
    public function buildForm()
    {
        $nameForm = 'cretae_user_form';
        $action = 'src/FormActions/create_user.php';
        $scripts = 'src/js/formScripts/create_user_form.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT . '/templates/');
        $twig = new \Twig\Environment($loader);

        $create_user_form = new Form($nameForm, $action, $inputs, $scripts);

        return $twig->render('form.twig.html', $create_user_form->toArray());
    }

    /**
     * Function to get elements in form.
     */
    private function getInputsElements()
    {
        $sql = "SELECT role_id, role_name FROM role";
        $conn = getDBConf();
        $result = mysqli_query($conn, $sql);

        $options = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $options[$row['role_id']] = $row['role_name'];
        }

        mysqli_close($conn);

        return [
            [
                'type' => 'text',
                'id' => 'user_nickname',
                'name' => 'user_nickname',
                'field' => 'user_nickname',
            ],
            [
                'type' => 'select',
                'id' => 'user_role',
                'name' => 'user_role',
                'field' => 'user_role',
                'options' => $options
            ],
            [
                'type' => 'text',
                'id' => 'user_firstname',
                'name' => 'user_firstname',
                'field' => 'user_firstname',
            ],
            [
                'type' => 'text',
                'id' => 'user_lastname',
                'name' => 'user_lastname',
                'field' => 'user_lastname',
            ],
            [
                'type' => 'email',
                'id' => 'user_email',
                'name' => 'user_email',
                'field' => 'user_email',
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
