<?php

use Sites\Form\CreateVacationForm;

require_once __DIR__ . '/../../vendor/autoload.php';

$handler = new CreateVacationForm();
$handler->validationForm();
