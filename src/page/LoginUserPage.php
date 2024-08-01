<?php

namespace Sites\Page;

use Sites\Form\LoginUserForm;
use Sites\Class\Page;

/**
 * Create user cabinet page.
 * 
 * Require Class Page.
 * Require Form form-login-user.
 */

class LoginUserPage
{
    /**
     * Function to build login form.
     */
    public static function buildLoginUserPage()
    {
        $content = [
            ['name' => 'login_user', 'content' => (new LoginUserForm())->buildLoginUserForm()],
        ];

        return new Page('Login', $content, '');
    }
}
