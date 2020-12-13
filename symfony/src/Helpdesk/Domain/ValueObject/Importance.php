<?php

namespace App\Helpdesk\Domain\ValueObject;

use App\Common\Exception\NotSupportedType;

class Importance {

    public const IMPORTANT = 'IMPORTANT';
    public const NORMALLY = 'NORMALLY';
    public const CRITICAL = 'IMPORTANT';

    public function __construct(string $guid) {
        if (!self::isValid($guid)) {
            throw new NotSupportedType('Not supported type of importance');
        }
    }

    public static function getTypes(): array {
        return [
            self::IMPORTANT => 'important',
            self::NORMALLY  => 'normally',
            self::CRITICAL  => 'critical',
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

}