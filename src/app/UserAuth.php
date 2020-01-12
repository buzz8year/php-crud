<?php

namespace app;

use models\User;


// EXPLAIN: ...
class UserAuth
{
    // EXPLAIN: ...
    private static $authenticated_user;

    // EXPLAIN: ...
    public static function clearAuthenticatedUser()
    {
        self::$authenticated_user = null;

        if (session_status() !== PHP_SESSION_ACTIVE) {
            trigger_error("Session is not active", E_USER_WARNING);
        } elseif (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }
    }


    // EXPLAIN: ...
    public static function setAuthenticatedUser(User $user): void
    {
        self::$authenticated_user = $user;

        if (session_status() !== PHP_SESSION_ACTIVE) {
            trigger_error("Session is not active", E_USER_WARNING);
        } else {
            $_SESSION['user_id'] = $user->getId();
        }

    }


    // EXPLAIN: ...
    public static function getAuthenticatedUser(): User
    {
        if (isset(self::$authenticated_user)) {
            return self::$authenticated_user;
        }

        if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
            $user = User::get($_SESSION['user_id']);
            if ($user->getId()) {
                self::$authenticated_user = $user;
                return $user;
            }
         }

        return new User();
    }

    // EXPLAIN: ...
    public static function isUserAuthenticated(): bool
    {
        return self::getAuthenticatedUser()->getId() && true;
    }

}