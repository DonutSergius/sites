<?php

namespace Sites\Page\Vacations;

use Sites\Class\Page;
use Sites\Form\CreateVacationForm;

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';

/**
 * Create form create vacation page.
 * 
 * Require Class Page.
 * Require Form form-create-page.
 */
class CreateVacationPage
{
    /**
     * Function to build form on page.
     */
    public static function buildCreateVacationPage()
    {
        $content = [
            ['name' => 'create_vacation', 'content' => (new CreateVacationForm)->buildVacationForm()],
        ];

        return new Page('Create vacation', $content, $_SESSION['user_id']);
    }
}
