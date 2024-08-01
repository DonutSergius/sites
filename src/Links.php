<?php

namespace Sites;

class Links
{
    public function buildLinks()
    {
        $currentPage = basename($_SERVER['REQUEST_URI']);

        $links = [
            ['url' => 'home', 'title' => 'Home', 'tag' => 'all'],
            ['url' => 'create-vacation', 'title' => 'Create vacation', 'tag' => 'all'],
        ];

        if (empty($_SESSION['user_role'])) {
            return null;
        }

        switch ($_SESSION['user_role']) {
            case 'admin':
                $links = array_merge($links, $this->getAdminLinks());
                break;
            case 'PM':
                $links = array_merge($links, $this->getPMLinks());
                break;
            case 'TeamLead':
                $links = array_merge($links, $this->getTLLinks($_SESSION['user_role']));
                break;
            default:
                $links = array_merge($links, $this->getStandartLinks($_SESSION['user_role']));
                break;
        }

        foreach ($links as &$link) {
            $link['active'] = $link['url'] === $currentPage;
        }

        return $links;
    }

    private function getAdminLinks()
    {
        return array_merge($this->getTLLinks('admin'), [
            ['url' => 'create-user', 'title' => 'Create user', 'tag' => 'admin'],
            ['url' => 'create-role', 'title' => 'Create role', 'tag' => 'admin'],

        ]);
    }

    private function getPMLinks()
    {
        return array_merge($this->getStandartLinks('PM'), [
            ['url' => 'approval-vacation', 'title' => 'Approval vacation', 'tag' => 'PM'],
        ]);
    }

    private function getTLLinks($user_role)
    {
        return array_merge($this->getStandartLinks($user_role), [
            ['url' => 'approval-vacation', 'title' => 'Approval vacation', 'tag' => $user_role],
            ['url' => 'create-certificate', 'title' => 'Create certificate', 'tag' => $user_role],
        ]);
    }

    private function getStandartLinks($user_role)
    {
        return [
            ['url' => 'my-vacation-request', 'title' => 'My vacation request', 'tag' => $user_role],
            ['url' => 'my-operation', 'title' => 'My operation', 'tag' => $user_role],
            ['url' => 'cancel-vacation', 'title' => 'Cancel vacation', 'tag' => $user_role],
        ];
    }
}
