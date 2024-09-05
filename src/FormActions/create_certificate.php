<?php

use Sites\Form\CreateCertificateForm;

require_once __DIR__ . '/../../vendor/autoload.php';

$handler = new CreateCertificateForm();
$handler->validationForm();
