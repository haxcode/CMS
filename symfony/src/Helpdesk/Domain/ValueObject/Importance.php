<?php

namespace App\Helpdesk\Domain\ValueObject;

use App\Common\Exception\NotSupportedType;
use Stringable;

class Importance implements Stringable {

    public const IMPORTANT = 'IMPORTANT';
    public const NORMALLY = 'NORMALLY';
    public const CRITICAL = 'CRITICAL';
    private string $guid;

    public function __construct(string $guid) {
        if (!self::isValid($guid)) {
            throw new NotSupportedType('Not supported type of importance');
        }
        $this->guid = $guid;
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