<?php

namespace Sites\Page;

use Sites\Class\Page;
use Sites\Services\DBService;
use Sites\Services\Certificate;

class UserCabinetPage
{
    public function buildPage()
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates/');
        $twig = new \Twig\Environment($loader);

        $userInfo = $this->getUserInfo((new DBService)->getDBConf(), $_SESSION['user_nickname']);
        $linksHtml = $twig->render('links.twig.html', ['links' => (new \Sites\Links)->buildUserLinks(), 'session' => $_SESSION]);

        $balance = (new Certificate)->getUserBalance($_SESSION['user_id']);

        if ($userInfo === false) {
            $content = [
                ['name' => 'user-info', 'content' => 'No user information found.'],
            ];
        } else {
            $content = [
                ['name' => 'user-links', 'content' => $linksHtml],
                ['name' => 'user-first-name', 'content' => 'First Name: ' . $userInfo['user_first_name']],
                ['name' => 'user-last-name', 'content' => 'Last Name: ' . $userInfo['user_last_name']],
                ['name' => 'user-created', 'content' => 'Created: ' . $userInfo['user_created']],
                ['name' => 'user-email', 'content' => 'Email: ' . $userInfo['user_email']],
                ['name' => 'user-balance', 'content' => 'Balance: ' . $balance],

            ];
        }

        return new Page($_SESSION['user_nickname'] . ' cabinet', $content, '');
    }

    private function getUserInfo($conn, $username)
    {
        $sql = 'SELECT user_first_name, user_last_name, user_created, user_email FROM user_info WHERE user_nickname = ?';
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result(
                $stmt,
                $user_first_name,
                $user_last_name,
                $user_created,
                $user_email
            );
            if (mysqli_stmt_fetch($stmt)) {
                return [
                    'user_first_name' => $user_first_name,
                    'user_last_name' => $user_last_name,
                    'user_created' => $user_created,
                    'user_email' => $user_email,
                ];
            }
            mysqli_stmt_close($stmt);
        }
        return false;
    }
}
