<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Form\CreateRoleForm;

/**
 * Create user page.
 * 
 * Require Class Page.
 * Require Form form-create-role.
 */
class CreateRolePage
{
    /**
     * Function to build Create User form.
     */
    public function buildPage()
    {
        $content = [
            ['name' => 'create-role', 'content' => (new CreateRoleForm)->buildForm()],
        ];

        return new Page('Create Role', $content, '');
    }
}
