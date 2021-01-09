<?php

namespace App\User\Entity\ValueObject;

use App\Common\Exception\NotSupportedType;

class Role {

    public const ADMIN = 'ROLE_ADMIN';
    public const CLIENT = 'ROLE_CLIENT';
    public const USER = 'ROLE_USER';

    private string $guid;

    public function __construct(string $guid) {
        if (!self::isValid($guid)) {
            throw new NotSupportedType('Not supported type of user role');
        }
        $this->guid = $guid;
    }

    public static function getTypes(): array {
        return [
            self::ADMIN  => 'Administrator',
            self::USER   => 'User',
            self::CLIENT => 'Client',
        ];
    }

    /**
     * @param string $guid
     *
     * @return bool
     */
    public static function isValid(string $guid): bool {
        return in_array($guid, array_keys(self::getTypes()));
    }

    /**
     * @return string
     */
    public function getLevelName(): string {
        return self::getTypes()[$this->guid];
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->guid;
    }

}