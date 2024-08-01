<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Form\CreateUserForm;

/**
 * Create user page.
 * 
 * Require Class Page.
 * Require Form form-create-user.
 */
class CreateUserPage
{
    /**
     * Function to build Create User form.
     */
    public static function buildCreateUserPage()
    {
        $content = [
            ['name' => 'cretae-user', 'content' => (new CreateUserForm)->buildCreateUserForm()],
        ];

        return new Page('Create user', $content, '');
    }
}
