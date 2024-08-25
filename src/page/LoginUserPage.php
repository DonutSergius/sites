<?php

namespace Sites\Page;

use Sites\Form\LoginUserForm;
use Sites\Class\Page;

class LoginUserPage
{
    public function buildPage()
    {
        $content = [
            ['name' => 'login_user', 'content' => (new LoginUserForm())->buildForm()],
        ];

        return new Page('Login', $content, '');
    }
}
