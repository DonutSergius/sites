<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Form\CreateRoleForm;

class CreateRolePage
{
    public function buildPage()
    {
        $content = [
            ['name' => 'create-role', 'content' => (new CreateRoleForm)->buildForm()],
        ];

        return new Page('Create Role', $content, '');
    }
}
