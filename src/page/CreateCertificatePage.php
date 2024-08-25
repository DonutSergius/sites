<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Form\CreateCertificateForm;

class CreateCertificatePage
{
    public function buildPage()
    {
        $content = [
            ['name' => 'create_certificate', 'content' => (new CreateCertificateForm)->buildForm()],
        ];

        return new Page('Create certificate', $content, '');
    }
}
