<?php

namespace Sites\Form;

use Sites\Class\Form;
use Sites\Class\Elements;
use Sites\Services\DBService;

class StatisticFilterForm {

    function buildForm()
    {
        $nameForm = 'statistic_filter_form';
        $action = 'src/FormActions/statistic_filter_form.php';
        $scripts = 'src/JS/FormScripts/statistic_filter_form.js';

        $inputs = $this->getInputsElements();

        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $create_vacation_form = new Form($nameForm, $action, $inputs, $scripts);
        $this->getUserList();
        return $twig->render('form.twig.html', $create_vacation_form->toArray());
    }

    function getInputsElements()
    {
        $user_list = $this->getUserList();

        return [
            (new Elements('Author', 'select', 'vacation-author'))->createSelect(
                $user_list
            ),
            (new Elements('Type vacation', 'select', 'vacation-type'))->createSelect([
                'paid' => 'Paid',
                'unpaid' => 'Unpaid',
            ]),
            (new Elements('Time type vacation', 'select', 'vacation-time'))->createSelect([
                'fullDay' => 'Full day',
                'specificTime' => 'Specific Time',
            ]),
        ];
    }

    function getUserList () {
        $service = new DBService;
        $labels = ['user.user_id', 'user.user_nickname'];
        $data = $service->getData($labels, 'user', '');
        $user_list =  mysqli_fetch_all($data, MYSQLI_ASSOC);

        foreach ($user_list as $user) {
            $userData[$user['user_nickname']] = $user['user_nickname'];
        }

        return $userData;
    }
}
