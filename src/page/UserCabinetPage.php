<?php

namespace Sites\Page;

use Sites\Class\Page;

require_once $_SERVER['DOCUMENT_ROOT'] . '/sites/config.php';
require_once PROJECT_ROOT . '/db_config.php';

/**
 * Create user cabinet page.
 * 
 * Require Class Page.
 * Require Table table-vacation.
 */
class UserCabinetPage
{
    /**
     * function to build table on page.
     */
    public function buildUserCabinet()
    {
        $userInfo = $this->getUserInfo(getDBConf(), $_SESSION['user_nickname']);

        if ($userInfo === false) {
            $content = [
                ['name' => 'user-info', 'content' => 'No user information found.'],
            ];
        } else {
            $content = [
                ['name' => 'user-first-name', 'content' => 'First Name: ' . $userInfo['user_first_name']],
                ['name' => 'user-last-name', 'content' => 'Last Name: ' . $userInfo['user_last_name']],
                ['name' => 'user-created', 'content' => 'Created: ' . $userInfo['user_created']],
                ['name' => 'user-email', 'content' => 'Email: ' . $userInfo['user_email']],
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
