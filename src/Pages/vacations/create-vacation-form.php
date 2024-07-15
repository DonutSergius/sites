<?php
require '/xampp/htdocs/sites/src/Form.php';


$nameForm = 'create-vacation';
$action = 'src/Forms/create_vacation.php';

$inputs = [
    ['type' => 'datetime-local', 'id' => 'date-start', 'name' => 'date-start', 'field' => 'date-start'],
    ['type' => 'datetime-local', 'id' => 'date-end', 'name' => 'date-end', 'field' => 'date-end'],
    ['type' => 'text', 'id' => 'approval', 'name' => 'approval', 'field' => 'approval'],
    ['type' => 'textarea', 'id' => 'reason', 'name' => 'reason', 'field' => 'reason'],
];

$create_vacation_form = new Form($nameForm, $action, $inputs);
