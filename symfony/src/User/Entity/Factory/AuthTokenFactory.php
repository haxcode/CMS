<?php

namespace App\User\Entity\Factory;

use App\User\Entity\User;
use App\User\Entity\AuthToken;
use DateInterval;
use DateTime;
use Symfony\Component\Uid\Uuid;

class AuthTokenFactory {

    public static function createAuthToken(User $user): AuthToken {
        $token = new AuthToken(Uuid::v4());
        $token->setUserId($user->getId());
        $token->setToken(self::generateToken($user->getEmail()));
        $token->setExpireAt((new DateTime())->add(new DateInterval('PT1H')));
        $token->setIsRefresh(FALSE);
        return $token;
    }

    public static function createRefreshAuthToken(User $user): AuthToken {
        $token = new AuthToken(UUID::random());
        $token->setUserId($user->getId());
        $token->setToken(self::generateToken($user->getEmail()));
        $token->setExpireAt((new DateTime())->add(new DateInterval('P1D')));
        $token->setIsRefresh(TRUE);
        return $token;
    }

    /**
     * @param string $login
     *
     * @return string
     */
    protected static function generateToken(string $login): string {
        return sha1($login.random_int(1, 100000).$login.'##TOKEN##');
    }

}