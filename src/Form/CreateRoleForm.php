<?php

namespace Sites\Form;

use Sites\Class\Form;
use Sites\Class\Elements;
use Sites\Services\DBService;

class CreateRoleForm
{
    public function buildForm()
    {
        $nameForm = 'cretae_role_form';
        $action = 'src/FormActions/create_role.php';
        $scripts = 'src/JS/FormScripts/create_role_form.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $create_role_form = new Form($nameForm, $action, $inputs, $scripts);

        return $twig->render('form.twig.html', $create_role_form->toArray());
    }

    public function validationForm()
    {
        $response = [
            'error' => '',
            'confirm' => '',
        ];

        $roleName = $_POST['role_name'] ?? null;
        $roleVacationDay = $_POST['role_vacation_day'] ?? null;

        $conn = (new DBService)->getDBConf();
        $sql = 'INSERT INTO role (role_name, role_vacation_day) VALUES (?, ?)';
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $roleName, $roleVacationDay);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $response['confirm'] = "New role created";
        }

        echo json_encode($response);
    }

    /**
     * Function to get elements in form.
     */
    private function getInputsElements()
    {
        return [
            (new Elements('Enter role name', 'text', 'role_name'))->createInput(),
            (new Elements('Enter nubmer of vacation days', 'number', 'role_vacation_day'))->createInput(),
        ];
    }
}
