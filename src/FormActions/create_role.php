<?php

use Sites\Form\CreateRoleForm;

require_once __DIR__ . '/../../vendor/autoload.php';

$handler = new CreateRoleForm();
$handler->validationForm();
