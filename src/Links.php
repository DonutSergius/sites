<?php

namespace Sites;

class Links
{
    public function buildMainLinks()
    {
        $currentPage = basename($_SERVER['REQUEST_URI']);

        if (empty($_SESSION['user_role'])) {
            return null;
        }

        $links = [
            ['url' => 'home', 'title' => 'Home', 'tag' => 'all'],
            ['url' => 'create-vacation', 'title' => 'Create vacation', 'tag' => 'all'],
        ];

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
        }

        $links = array_merge($links, $this->getUserCabinetLinks());

        foreach ($links as &$link) {
            $link['active'] = $link['url'] === $currentPage;
        }

        return $links;
    }

    public function buildUserLinks()
    {
        return $this->getStandartLinks($_SESSION['user_role']);
    }

    private function getUserCabinetLinks()
    {
        if (isset($_SESSION['user_nickname'])) {
            $links = [
                ['url' => 'user-cabinet', 'title' => $_SESSION['user_nickname'], 'tag' => 'all'],
                ['url' => 'logout', 'title' => 'Logout', 'tag' => 'all'],
            ];
        } else {
            $links = [
                ['url' => 'login', 'title' => 'Login', 'tag' => 'all'],
            ];
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
        return [
            ['url' => 'approval-vacation', 'title' => 'Approval vacation', 'tag' => 'PM'],
        ];
    }

    private function getTLLinks($user_role)
    {
        return [
            ['url' => 'approval-vacation', 'title' => 'Approval vacation', 'tag' => $user_role],
            ['url' => 'create-certificate', 'title' => 'Create certificate', 'tag' => $user_role],
        ];
    }

    private function getStandartLinks($user_role)
    {
        return [
            ['url' => 'my-vacation-request', 'title' => 'My vacation request', 'tag' => $user_role],
            ['url' => 'my-operations', 'title' => 'My operation', 'tag' => $user_role],
        ];
    }
}
