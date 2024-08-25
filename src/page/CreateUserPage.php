<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Form\CreateUserForm;

class CreateUserPage
{
    public function buildPage()
    {
        $content = [
            ['name' => 'cretae-user', 'content' => (new CreateUserForm)->buildForm()],
        ];

        return new Page('Create user', $content, '');
    }
}
