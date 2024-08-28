<?php

namespace Sites\Page\Vacations;

use Sites\Class\Page;
use Sites\Form\CreateVacationForm;

class CreateVacationPage
{
    public function buildPage()
    {
        $content = [
            ['name' => 'create_vacation', 'content' => (new CreateVacationForm)->buildForm()],
        ];

        return new Page('Create vacation', $content, '');
    }
}
