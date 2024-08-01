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
    public static function buildCreateRolePage()
    {
        $content = [
            ['name' => 'create-role', 'content' => (new CreateRoleForm)->buildCreateRoleForm()],
        ];

        return new Page('Create Role', $content, '');
    }
}
