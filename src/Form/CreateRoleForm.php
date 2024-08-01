<?php

namespace Sites\Form;

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';

use Sites\Class\Form;

/**
 * Create form.
 * 
 * Require Class Form.
 */
class CreateRoleForm
{
    /**
     * Function to build form.
     */
    public function buildCreateRoleForm()
    {
        $nameForm = 'cretae_role_form';
        $action = 'src/FormActions/create_role.php';
        $scripts = 'src/js/formScripts/create_role_form.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT . '/templates/');
        $twig = new \Twig\Environment($loader);

        $create_role_form = new Form($nameForm, $action, $inputs, $scripts);

        return $twig->render('form.twig.html', $create_role_form->toArray());
    }

    /**
     * Function to get elements in form.
     */
    private function getInputsElements()
    {
        return [
            [
                'type' => 'text',
                'id' => 'role_name',
                'name' => 'role_name',
                'field' => 'role_name',
            ],
            [
                'type' => 'number',
                'id' => 'role_vacation_day',
                'name' => 'role_vacation_day',
                'field' => 'role_vacation_day',
            ],

        ];
    }
}
