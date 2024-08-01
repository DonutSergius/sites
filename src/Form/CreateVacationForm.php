<?php

namespace Sites\Form;

use Sites\Class\Form;

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';

/**
 * Create form.
 * 
 * Require Class Form.
 */
class CreateVacationForm
{
    /**
     * Function to build form.
     */
    function buildVacationForm()
    {
        $nameForm = 'сreate_vacation';
        $action = 'src/FormActions/create_vacation.php';
        $scripts = 'src/js/formScripts/vacation_form.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader(PROJECT_ROOT . '/templates/');
        $twig = new \Twig\Environment($loader);

        $create_vacation_form = new Form($nameForm, $action, $inputs, $scripts);

        return $twig->render('form.twig.html', $create_vacation_form->toArray());
    }

    /**
     * Function to get elements in form.
     */
    function getInputsElements()
    {
        return [
            [
                'type' => 'select',
                'id' => 'vacation-type',
                'name' => 'vacation-type',
                'field' => 'vacation-type',
                'options' => [
                    'paid' => 'Paid',
                    'unpaid' => 'Unpaid',
                ]
            ],

            [
                'type' => 'select',
                'id' => 'vacation-time',
                'name' => 'vacation-time',
                'field' => 'vacation-time',
                'options' => [
                    'fullDay' => 'Full day',
                    'specificTime' => 'Specific Time',
                ]
            ],

            [
                'type' => 'date',
                'id' => 'date-start',
                'name' => 'date-start',
                'field' => 'date-start'
            ],

            [
                'type' => 'date',
                'id' => 'date-end',
                'name' => 'date-end',
                'field' => 'date-end'
            ],

            [
                'type' => 'datetime-local',
                'id' => 'datetime-start',
                'name' => 'datetime-start',
                'field' => 'datetime-start'
            ],

            [
                'type' => 'datetime-local',
                'id' => 'datetime-end',
                'name' => 'datetime-end',
                'field' => 'datetime-end'
            ],

            [
                'type' => 'text',
                'id' => 'approval',
                'name' => 'approval',
                'field' => 'approval'
            ],

            [
                'type' => 'textarea',
                'id' => 'reason',
                'name' => 'reason',
                'field' => 'reason'
            ],
        ];
    }
}
