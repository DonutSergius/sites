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
    public function buildPage()
    {
        $content = [
            ['name' => 'login_user', 'content' => (new LoginUserForm())->buildForm()],
        ];

        return new Page('Login', $content, '');
    }
}
